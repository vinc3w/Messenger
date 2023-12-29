<x-guest-layout>

    <x-slot name="title">{{ __('Verify Email') }}</x-slot>

    <div class="mb-2 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        <br>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-2 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="text-sm text-gray-600"> 
        {{ __('Sent to: ').Auth::user()->email }}
    </div>

    <div class="text-sm text-gray-600 mb-4">
            {{ __('Entered the wrong email? Change your email ') }}<a href="{{ route('update.email.form') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('here') }}</a>
    </div>
    
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <x-primary-button class="w-full">
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </div>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="underline mt-2 text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Log Out') }}
        </button>
    </form>

</x-guest-layout>
