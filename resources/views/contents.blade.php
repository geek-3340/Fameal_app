<x-app-layout>
    <p class="fixed top-7 right-28 text-lg z-50 font-bold text-white max-xl:top-5">{{$userName}} 様</p>
    <div class="pt-20 pl-48 max-xl:pl-0 max-xl:pt-16">
        @if (request()->routeIs('dishes.index'))
            @include('contents.dishes')
        @elseif(request()->routeIs('babyfoods.index'))
            @include('contents.babyfoods')
        @elseif(request()->routeIs('shopping.list.index'))
            @include('contents.shopping-list')
        @else
            <x-contents-board type="content" class="max-xl:shadow-none max-xl:p-0">
                <div id="calendar" data-initial-view="{{ $viewType === 'week' ? 'dayGridWeek' : 'dayGridMonth' }}"
                    data-dishes-month-url="{{ route('menus.index', ['category' => 'dishes', 'viewType' => 'month']) }}"
                    data-dishes-week-url="{{ route('menus.index', ['category' => 'dishes', 'viewType' => 'week']) }}"
                    data-babyfoods-month-url="{{ route('menus.index', ['category' => 'babyfoods', 'viewType' => 'month']) }}"
                    data-babyfoods-week-url="{{ route('menus.index', ['category' => 'babyfoods', 'viewType' => 'week']) }}"
                    data-menus-for-calendar-events='@json($menusForCalendarEvents)'>
                </div>
            </x-contents-board>
            @include('contents.partials.day-modal')
        @endif
    </div>
</x-app-layout>
