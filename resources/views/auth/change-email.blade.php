<x-guest-layout>

    <x-slot name="title">{{ __('Change Email') }}</x-slot>

    <div class="mb-4 text-sm text-gray-600">
        {{ __('If you have entered the wrong email during your registration, change you email here') }}
    </div>
    
    <form method="POST" action="{{ url('/update-email/'.Auth::user()->id) }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full my-2">
            {{ __('Change Email') }}
        </x-primary-button>

    </form>
    
    <div class="flex justify-between">
		
		<a href="{{ route('verification.notice') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
			{{ __('Cancel') }}
		</a>
			
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

</x-guest-layout>
