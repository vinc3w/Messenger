<x-app-layout>

    <div x-data="" class="flex items-stretch h-screen">

        @include('home.side-navbar')
        @include('home.app.app')
        @include('home.chat-box')

    </div>

    <script>
        window.state = {
            user: {!! Auth::user() !!}
        };
    </script>
    
    @vite(['resources/js/home/home.js'])

</x-app-layout>
