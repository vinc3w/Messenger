<x-guest-layout>

    <x-slot name="title">{{ __('Confirm Password') }}</x-slot>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        
        <x-primary-button class="mt-4 py-3 w-full">
            {{ __('Confirm') }}
        </x-primary-button>
    </form>
</x-guest-layout>
