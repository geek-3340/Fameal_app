<x-app-layout>
    <div class="pt-20 pl-48 max-md:pl-0">
        @if (request()->routeIs('dishes.index'))
            @include('contents.dishes')
        @elseif(request()->routeIs('babyfoods.index'))
            @include('contents.babyfoods')
        @elseif(request()->routeIs('shopping.list.index'))
            @include('contents.shopping-list')
        @else
            <x-contents-board type="content">
                <div id="calendar" data-initial-view="{{ $viewType === 'week' ? 'dayGridWeek' : 'dayGridMonth' }}"
                    data-dishes-month-url="{{ route('menus.index', ['category' => 'dishes', 'viewType' => 'month']) }}"
                    data-dishes-week-url="{{ route('menus.index', ['category' => 'dishes', 'viewType' => 'week']) }}"
                    data-babyfoods-month-url="{{ route('menus.index', ['category' => 'babyfoods', 'viewType' => 'month']) }}"
                    data-babyfoods-week-url="{{ route('menus.index', ['category' => 'babyfoods', 'viewType' => 'week']) }}"
                    data-menus-event='@json($events)' data-menus-by-date='@json($menusByDate)'>
                </div>
            </x-contents-board>
            <x-day-modal :dishes="$dishes" />
        @endif
    </div>
</x-app-layout>
