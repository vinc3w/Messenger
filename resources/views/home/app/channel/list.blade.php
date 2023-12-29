<div id="channel" class="h-full flex flex-col">

	<div class="relative mt-0">
		<i class="absolute top-0 left-0 fa-solid fa-magnifying-glass flex items-center h-full pl-2"></i>
		<x-text-input id="search-channel-form" class="w-full pl-[32px]"
						type="text"
						name="channel"
						placeholder="Search" />
	</div>

	<div id="channel-list" class="mt-5"></div>

	<div id="empty-channel-list" class="h-full flex flex-col justify-center items-center hidden">
		<x-sad-face class="h-20"></x-sad-face>
		<div class="text-3xl font-semibold">No Channels</div>
	</div>
	
</div>
	