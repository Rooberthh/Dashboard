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
                <a href="{{ route('logout') }}"  class="mr-6 text-white font-bold">Logout</a>
            </div>
        @endif
        @if(!Auth::check())
        <div class="flex ml-auto">
            <a href="/login/google" class="mr-6 text-white font-bold">Login</a>
        </div>
        @endif
    </div>
</nav>
