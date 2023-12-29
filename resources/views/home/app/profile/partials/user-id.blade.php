<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Id') }}
        </h2>

        <p class="text-sm text-gray-600">
            {{ __("This is your user id. Your friends can use this id to add you as friend!") }}
        </p>
    </header>
    <x-pop-out delay="1000">
        <x-slot name="trigger">
            <div class="border border-gray-300 p-2 rounded-md mt-3">
                <div>{{ Auth::user()->id }}</div>
            </div>
        </x-slot>
        <div>
            Copied Successfully ✅
        </div>
    </x-pop-out>
</section>
