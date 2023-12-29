<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="update-profile-information-form" class="mt-3 space-y-3">
        @csrf
        @method('PATCH')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input name="name" type="text" class="mt-1 block w-full" :value="old('name', Auth::user()->name)" autofocus autocomplete="name" />
            <div id="update-profile-information-form-name-error"class="text-sm text-red-600 space-y-1"></div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input name="email" type="email" class="mt-1 block w-full" :value="old('email', Auth::user()->email)" autocomplete="username" />
            <div id="update-profile-information-form-email-error"class="text-sm text-red-600 space-y-1"></div>

            <div id="update-profile-information-form-verify-email" class="hidden">
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <p id="update-profile-information-form-save-indicator" class="text-sm text-gray-600 hidden">
                {{ __('Saved.') }}
            </p>
        </div>
    </form>
</section>
