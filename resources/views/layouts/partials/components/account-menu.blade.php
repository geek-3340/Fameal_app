<nav x-show="openAccountMenu" x-cloak @click.away="openAccountMenu = false"
    @keydown.escape.window="openAccountMenu = false" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed z-40 top-0 right-0 flex flex-col w-48 h-screen pl-5 bg-main shadow-lg rounded-l-xl">
    <a href="{{ route('profile.edit') }}" class="text-white text-xl font-bold mt-28 mb-4">
        {{ __('Profile Menu') }}
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"
            class="text-white text-xl font-bold">
            {{ __('Log Out') }}
        </a>
    </form>
</nav>
