@props(['uid', 'trigger'])

<div x-data="{ show{{ $uid }}: false }">

	<div @click="show{{ $uid }} = true; $nextTick(() => $refs.input{{ $uid }}.focus());">
		{{ $trigger }}
	</div>

	<div class="fixed top-0 left-0 z-50 h-full w-full bg-black bg-opacity-70 grid place-items-center"
			@click="show{{ $uid }} = false"
			x-show="show{{ $uid }}"
			style="display: none;"
			x-transition:enter="ease-out duration-300"
			x-transition:enter-start="opacity-0 sm:translate-y-0"
			x-transition:enter-end="opacity-100"
			x-transition:leave="ease-in duration-100"
			x-transition:leave-start="opacity-100 translate-y-0"
			x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0">

		<div class="bg-white rounded-lg p-7 shadow max-w-md" onclick="event.stopPropagation()">

			<div class="text-3xl mb-2 ">{{ __('Add Friend') }}</div>

			<div class="mb-5 text-sm text-gray-600">
				{{ __('How to find your user id? Go to your profile page and go the under user id section and there is your user id.') }}
			</div>

			<form class="add-friend-form p-9 border border-gray-300 rounded-lg">
				@csrf()
				@method('post')

				<x-input-label for="friendId" :value="__('Friend Id')" />

				<x-text-input x-ref="input{{ $uid }}" class="block mt-3 w-full"
								type="text"
								name="friendId"
								autocomplete="off"
								required />

				<div name="error" class="mt-3 empty:mt-0 text-red-500"></div>
				<div name="success" class="mt-3 empty:mt-0 text-green-500"></div>

				<div class="mt-3">
					<x-primary-button class="w-full">
						{{ __('Send Friend Request') }}
					</x-primary-button>
					<x-secondary-button class="mt-1 w-full" @click="show{{ $uid }} = false">
						{{ __('Cancel') }}
					</x-secondary-button>
				</div>

			</form>

		</div>

	</div>

	
</div>
