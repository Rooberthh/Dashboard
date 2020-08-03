<nav class="bg-green-500 p-6 border-b-8 border-green-600 mb-8">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white mr-6">
            <a href="/" class="font-semibold text-3xl tracking-tight">Dashboard</a>
        </div>
        @if(Auth::check())
        <div class="flex mr-auto">
            <a href="{{ route('boards.index') }}" class="mr-6 text-white font-bold">Boards</a>
            <a href="{{ route('events.index') }}" class="mr-6 text-white font-bold">Calendar</a>
            <a href="{{ route('hue.index') }}" class="mr-6 text-white font-bold">Hue</a>
        </div>
        @endif
        @if(Auth::check())
            <div class="flex ml-auto">
                <dropdown>
                    <template v-slot:trigger>
                        <button type="button" id="profile">
                            <img src="{{ gravatar_url(Auth()->user()->email) }}"
                                 alt=" {{ Auth()->user() }}'s avatar"
                                 class="rounded-full w-8"
                            >
                        </button>
                    </template>
                    <a class="block px-4 text-normal py-2" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </dropdown>
            </div>
        @endif
        @if(!Auth::check())
        <div class="flex ml-auto">
            <a href="/login/google" class="mr-6 text-white font-bold">Login</a>
        </div>
        @endif
    </div>
</nav>
