<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    /**
     * Show email form
     */
    public function updateEmailForm(Request $request): View
    {

        return view('auth.change-email');

    }

    /**
     * Update email
     */
    public function updateEmail(Request $request): RedirectResponse
    {
        
        $request->user()->email = $request->email;
        $request->user()->save();

        return Redirect::to('/verify-email');

    }

    /**
     * Update the user's profile image
     */
    public function updateProfileImage(Request $request): JsonResponse
    {

        $request->validate([
            'image' => 'mimes:jpg,png,svg'
        ]);

        $imagePath = Storage::url($request->file('image')->store('/public/profile-images'));

        $request->user()->profile_image = $imagePath;
        $request->user()->save();

        return response()->json([
            'imagePath' => $imagePath
        ]);

    }

    /**
     * Remove the user's profile image
     */
    public function removeProfileImage(Request $request)
    {

        if ($request->user()->profile_image === null) {
            return http_response_code(200);
        }

        Storage::delete('/public/profile-images/'.explode('/', $request->user()->profile_image)[3]);

        $request->user()->profile_image = null;
        $request->user()->save();

        return http_response_code(200);

    }

    /**
     * Update the user's profile information.
     */
    public function updateInformation(ProfileUpdateRequest $request): JsonResponse
    {
        
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return response()->json([
            'status' => 'profile-updated'
        ]);

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');

    }
}
