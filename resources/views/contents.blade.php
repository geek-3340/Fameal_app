<x-app-layout>
    @if (request()->routeIs('menus.month.index') ||
            request()->routeIs('menus.week.index') ||
            request()->routeIs('baby.menus.month.index') ||
            request()->routeIs('baby.menus.week.index'))
        <div id="calendar"
            data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
            data-month-url="{{ route('menus.month.index') }}"
            data-week-url="{{ route('menus.week.index') }}"
            data-menus-event='@json($events)'
            data-menus-by-date='@json($menusByDate)'>
        </div>
        <x-day-modal :dishes="$dishes" />
    @endif

    @if (request()->routeIs('dishes.index'))
        @include('pages.dishes')
    @endif

</x-app-layout>
