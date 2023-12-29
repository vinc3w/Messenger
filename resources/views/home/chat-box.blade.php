<div id="chat-container" class="h-full w-full flex-col max-md:hidden">

	<div id="chat" class="h-full w-full flex flex-col">

		<header class="bg-white p-5 flex items-center">
			<button class="hover:bg-gray-100 flex justify-center items-center h-9 w-9 rounded-lg active:bg-gray-200 transition-colors duration-100 md:hidden"
					onclick="
						window.history.pushState(window.history.state?.split('|')[0] + '|app', null, window.location.pathname);
						window.dispatchEvent(new Event('popstate'));
					">
				<i class="fa-solid fa-arrow-left"></i>
			</button>
			<div id="chat-user-profile-image" class="bg-no-repeat bg-center bg-cover w-11 h-11 rounded-lg bg-gray-300 ml-2"></div>
			<div class="ml-5">
				<div id="channel-name" class="text-lg font-semibold leading-5"></div>
				<div id="channel-status" class="leading-5"></div>
			</div>
		</header>
		
		<div id="message-container" class="h-full px-5 py-3 overflow-auto"></div>

		<div id="empty-message-container" class="h-full flex flex-col justify-center items-center hidden">
			<x-sad-face class="h-20"></x-sad-face>
			<div class="text-3xl font-semibold">No Messages</div>
			<div class="">Send a message to start chatting</div>
		</div>

		<div class="m-5 mt-auto">
			<div id="reply" class="flex justify-between items-stretch bg-gray-200 rounded-tl-lg rounded-tr-lg p-2 hidden">
				<div class="bg-gray-300 w-full p-1 rounded-lg mr-1">
					<div name="name" class="text-sm opacity-70"></div>
					<div name="message" class="max-h-24 overflow-auto"></div>
				</div>
				<button name="cancel-btn" class="p-2 hover:bg-gray-300 active:bg-gray-400 rounded-md">
					<i class="fa-solid fa-circle-xmark"></i>
				</button>
			</div>
			<form id="message-form" class="">
				@csrf
				@method('post')
				<div id="message-error" class="text-red-600 space-y-1 px-3 py-1 bg-white shadow mb-1 rounded-lg empty:hidden"></div>
				<input type="hidden" name="channelId">
				<input type="hidden" name="replyTo">
				<div class="relative ">
					<i class="fa-solid fa-paperclip absolute top-0 left-0 flex items-center h-full pl-2"></i>
					<x-text-input id="message-input" class="w-full px-[32px] py-3"
											type="text"
											name="message"
											placeholder="Send a message"
											tabindex="1" />
					<button type="submit" class="absolute top-0 right-0 flex items-center h-full pr-2">
						<i class="fa-solid fa-paper-plane"></i>
					</button>
				</div>
			</form>
		</div>

	</div>

	<div id="no-channel-display" class="flex flex-col justify-center items-center h-full w-full p-5 hidden">
		<x-sad-face class="h-64"></x-sad-face>
		<div class="text-4xl text-center mt-5 mb-2">Don't have a friend to talk to?</div>
		<x-add-friend-form>
			<x-slot name="uid">2</x-slot>
			<x-slot name="trigger">
				<x-primary-button>Add a friend</x-primary-button>
			</x-slot>
		</x-add-friend-form>
	</div>

</div>