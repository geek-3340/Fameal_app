<div x-show="openRight" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
    class="fixed top-0 right-0 w-64 h-screen pt-20 bg-main shadow-lg z-40 flex flex-col rounded-l-xl"
    @click.away="openRight = false" style="display: none;">
    <nav class="flex flex-col px-5 mt-8 space-y-8">
        <a href="{{ route('profile.edit') }}" class="text-white text-2xl font-bold">
            {{ __('Profile Menu') }}
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"
                class="text-white text-2xl font-bold">
                {{ __('Log Out') }}
            </a>
        </form>
    </nav>
</div>
