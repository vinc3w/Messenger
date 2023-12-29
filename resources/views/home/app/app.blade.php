<div id="app-container" class="bg-white mr-1 flex flex-col max-md:hidden md:min-w-[336px] md:max-w-[336px] max-md:w-full">
	
	<div class="flex justify-between items-center p-5">
		<div id="app-title" class="text-xl font-semibold"></div>
		<x-add-friend-form>
			<x-slot name="uid">1</x-slot>
			<x-slot name="trigger">
				<button class="hover:bg-gray-100 flex justify-center items-center h-9 w-9 rounded-lg active:bg-gray-200 transition-colors duration-100" title="Add Friend">
					<i class="fa-solid fa-plus"></i>
				</button>
			</x-slot>
		</x-add-friend-form>
	</div>

	<div id="app" class="h-full overflow-auto px-5 pb-3">
		@include('home.app.channel.list')
		@include('home.app.notification.list')
		@include('home.app.profile.edit')
	</div>

	<nav class="mt-auto p-2 border-t-gray-100 border-t-2 lg:hidden">
	
		<ul class="flex justify-evenly items-center w-full">
			<li class="relative">
				<button class="flex justify-between items-center p-2 rounded-full hover:bg-gray-100 active:bg-gray-200 transition-colors duration-100"
						onclick="
							if (window.history.state === 'channel') return;
							window.history.pushState('channel', null, window.location.pathname);
							window.dispatchEvent(new Event('popstate'));
						">
					<div class="flex justify-center items-center w-7 h-7">
						<i class="fa-solid fa-message text-xl"></i>
					</div>
					<div class="new-message-count absolute top-0 right-0 flex justify-center items-center bg-red-500 rounded-lg text-white text-xs w-5 h-5 empty:bg-transparent"></div>
				</button>
			</li>
			<li class="relative">
				<button class="flex justify-between items-center p-2 rounded-full hover:bg-gray-100 active:bg-gray-200 transition-colors duration-100"
						onclick="
							if (window.history.state === 'notification') return;
							window.history.pushState('notification', null, window.location.pathname);
							window.dispatchEvent(new Event('popstate'));
						">
					<div class="flex justify-center items-center w-7 h-7">
						<i class="fa-solid fa-bell text-xl"></i>
					</div>
					<div class="notification-count absolute top-0 right-0 flex justify-center items-center bg-red-500 rounded-lg text-white text-xs w-5 h-5 empty:bg-transparent"></div>
				</button>
			</li>
			<li>
				<button class="block p-2 rounded-full hover:bg-gray-100 active:bg-gray-200 transition-colors duration-100"
				onclick="
							if (window.history.state === 'profile') return;
							window.history.pushState('profile', null, window.location.pathname);
							window.dispatchEvent(new Event('popstate'));
						">
					<i class="flex justify-center items-center fa-solid fa-user text-xl w-7 h-7"></i>
				</button>
			</li>
		</ul>

	</nav>

</div>
