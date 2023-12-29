<seciton>
	<header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update profile image') }}
        </h2>

        <p class="text-sm text-gray-600">
            {{ __("Choose to update or remove your proifle picture.") }}
        </p>
	</header>
	<div class="mt-3">
		<div id="profile-image-view" style="background-image: url({{ Auth::user()->profile_image ?: '/assets/images/default-profile-image.jpg' }})" class="bg-no-repeat bg-center bg-cover min-w-[6rem] w-24 h-24 rounded-lg bg-gray-300"></div>
		<div class="flex mt-2">
			<div>
				<form id="upload-profile-image-form" class="hidden">
					@csrf
					@method('post')
					<input x-ref="imageInput" type="file" name="image" id="upload-profile-image-input">
				</form>
				<x-primary-button class="h-fit" @click="$refs.imageInput.click()">
					{{ __('Upload') }}
				</x-primary-button>
			</div>
			<form id="remove-profile-image-form">
				@csrf
				@method('post')
				<x-primary-button class="h-fit ml-2">{{ __('Remove') }}</x-primary-button>
			</form>
		</div>
	</div>
</seciton>