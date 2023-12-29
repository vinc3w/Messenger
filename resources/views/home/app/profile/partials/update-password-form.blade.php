<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form id="update-password-form" class="mt-3 space-y-3">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <div id="update-password-form-current-password-error" class="text-sm text-red-600 space-y-1"></div>
        </div>

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <div id="update-password-form-password-error" class="text-sm text-red-600 space-y-1"></div>
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <div id="update-password-form-password-confirmation-error" class="text-sm text-red-600 space-y-1"></div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <p id="update-password-form-save-indicator" class="text-sm text-gray-600 hidden">{{ __('Saved.') }}</p>
        </div>
    </form>
</section>
