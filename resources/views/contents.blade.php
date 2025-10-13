<x-app-layout>
    <div class="pt-20 pl-48 max-md:pl-0">
        @if(request()->routeIs('dishes.index'))
            @include('contents.dishes')
        <!-- @elseif(request()=>routeIs('babyfoods.index')) -->
            <!-- @include('contents.babyfoods') -->
        <!-- @elseif(request()=>routeIs('shopping.list.index')) -->
            <!-- @include('contsnts.shopping-list') -->
        @else
            <x-contents-board type="content">
                <div id="calendar"
                    data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
                    data-month-url="{{ route('menus.month.index') }}" data-week-url="{{ route('menus.week.index') }}"
                    data-menus-event='@json($events)' data-menus-by-date='@json($menusByDate)'>
                </div>
            </x-contents-board>
            <x-day-modal :dishes="$dishes" />
        @endif
    </div>
</x-app-layout>
