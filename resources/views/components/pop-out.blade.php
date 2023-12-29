<div x-data="{ show: false, timeout: null }">
	<div @click="clearTimeout(timeout); show = true; timeout = setTimeout(() => show = false, {{ $delay }})" class="cursor-pointer">
		{{ $trigger }}
	</div>
	<div class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white shadow rounded-lg p-9"
		x-show="show" 
		style="display: none;"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 sm:scale-100"
        x-transition:leave="ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
		{{ $slot }}
	</div>
</div>
