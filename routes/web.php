<?php

use App\Http\Controllers\ChannelController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', function () {

        return redirect('/app');

    });
    
    Route::get('/app', function () {

        return view('home.home');

    });
    
    Route::get('/app/channel/{channelId}', function () {

        return view('home.home');

    });

    Route::put('/api/keep-online', function (Request $request) {
        
        $expiresAt = Carbon::now()->addSeconds(15);
        Cache::put('is-user-online-'.$request->user()->id, true, $expiresAt);

        return response()->json([
            'message' => 'Status kept online.'
        ]);

    });

    Route::post('/api/profile/update-profile-image/{profile}', [ProfileController::class, 'updateProfileImage']);
    Route::post('/api/profile/remove-profile-image/{profile}', [ProfileController::class, 'removeProfileImage']);
    Route::post('/api/profile/update-information/{profile}', [ProfileController::class, 'updateInformation']);
    Route::delete('/api/profile/${profile}', [ProfileController::class, 'destroy']);

    Route::delete('/api/friend/{id}', [FriendController::class, 'destroy']);
    Route::resource('/api/friend', FriendController::class)
        ->only(['index', 'store']);
        
    Route::get('/api/channel/{channelId}', [ChannelController::class, 'show']);

    Route::delete('/api/message/{id}', [MessageController::class, 'destroy']);
    Route::resource('/api/message', MessageController::class)
        ->only(['store', 'update']);

    Route::resource('/api/notification', NotificationController::class)
        ->only(['index', 'store', 'destroy']);

});

require __DIR__.'/auth.php';
