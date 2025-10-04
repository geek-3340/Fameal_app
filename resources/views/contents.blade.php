<x-app-layout>
    @if (request()->routeIs('menus.month.index') ||
            request()->routeIs('menus.week.index') ||
            request()->routeIs('baby.menus.month.index') ||
            request()->routeIs('baby.menus.week.index'))
        <x-contents-board shadow="visible" width="contents">
            <div id="calendar"
                data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
                data-month-url="{{ route('menus.month.index') }}" data-week-url="{{ route('menus.week.index') }}"
                data-menus-event='@json($events)' data-menus-by-date='@json($menusByDate)'>
            </div>
        </x-contents-board>
        <x-day-modal :dishes="$dishes" />
    @endif

    @if (request()->routeIs('dishes.index'))
        @include('contents.dishes')
    @endif
</x-app-layout>
