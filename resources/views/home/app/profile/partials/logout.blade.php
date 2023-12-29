<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900">
            {{ __('Log Out') }}
        </h2>

		<p class="mt-1 text-sm text-gray-600">
			{{ __('Log out of your account here') }}
		</p>
		
		<form method="post" action="{{ route('logout') }}">
			@csrf
			<x-primary-button class="mt-3">{{ __('Log Out') }}</x-primary-button>
		</form>
	</header>
</section>
