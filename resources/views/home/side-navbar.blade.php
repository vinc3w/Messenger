<div class="relative">

	<nav class="flex flex-col items-end justify-center min-w-fit h-full top-0 overflow-auto w-60 bg-white p-5 mr-1 max-lg:hidden">

		<div class="flex justify-start items-center w-full">
			<x-application-logo class="h-9 w-9" fill="#4287f8"></x-application-logo>
			<div class="text-2xl ml-2 font-bold">Messenger</div>
		</div>

		<ul class="my-12 w-full">
			<li class="w-full">
				<button class="w-full flex justify-between items-center p-3 rounded-md hover:bg-gray-100 active:bg-gray-200 transition-colors duration-100"
						onclick="
							if (window.history.state === 'channel') return;
							window.history.pushState('channel', null, window.location.pathname);
							window.dispatchEvent(new Event('popstate'));
						">
					<div class="flex justify-start items-center">
						<i class="fa-solid fa-message text-xl"></i>
						<div class="ml-2">Channel</div>
					</div>
					<div class="new-message-count flex justify-center items-center bg-red-500 aspect-square rounded-lg text-white text-sm ml-7 w-[26px] empty:bg-transparent"></div>
				</button>
			</li>
			<li class="w-full">
				<button class="w-full flex justify-between items-center p-3 rounded-md hover:bg-gray-100 active:bg-gray-200 transition-colors duration-100"
						onclick="
								if (window.history.state === 'notification') return;
								window.history.pushState('notification', null, window.location.pathname);
								window.dispatchEvent(new Event('popstate'));
							">
					<div class="flex justify-start items-center">
						<i class="fa-solid fa-bell text-xl"></i>
						<div class="ml-2">Notification</div>
					</div>
					<div class="notification-count flex justify-center items-center bg-red-500 aspect-square rounded-lg text-white text-sm ml-7 w-[26px] empty:bg-transparent"></div>
				</button>
			</li>
			<li class="w-full">
				<button class="w-full flex justify-start items-center p-3 rounded-md hover:bg-gray-100 active:bg-gray-200 transition-colors duration-100"
						onclick="
							if (window.history.state === 'profile') return;
							window.history.pushState('profile', null, window.location.pathname);
							window.dispatchEvent(new Event('popstate'));
						">
					<i class="fa-solid fa-user text-xl"></i>
					<div class="ml-2">Profile</div>
				</button>
			</li>
		</ul>

		<div class="mt-auto w-full flex">
			<div id="side-bar-profile-image" style="background-image: url({{ Auth::user()->profile_image ?: '/assets/images/default-profile-image.jpg' }})" class="bg-no-repeat bg-center bg-cover w-14 h-14 rounded-lg bg-gray-300"></div>
			<div class="ml-2">
				<div class="font-semibold text-lg text-ellipsis whitespace-nowrap overflow-hidden">{{ Auth::user()->name }}</div>
				<x-pop-out delay="1000">
					<x-slot name="trigger">
						<div class="opacity-70" title="Click to copy" onclick="navigator.clipboard.writeText('{{ Auth::user()->id }}')">
							{{ '@'.Auth::user()->id }}
						</div>
					</x-slot>
					<div>
						Copied Successfully ✅
					</div>
				</x-pop-out>
			</div>
		</div>

	</nav>

</div>
