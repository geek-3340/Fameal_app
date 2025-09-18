<x-app-layout>
    @if (request()->routeIs('menus.month.index') ||
            request()->routeIs('menus.week.index') ||
            request()->routeIs('baby.menus.month.index') ||
            request()->routeIs('baby.menus.week.index'))
        <div id="calendar"
            data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
            data-month-url="{{ route('menus.month.index') }}" data-week-url="{{ route('menus.week.index') }}"></div>
        {{-- モーダル部分例 --}}
        <div x-data="{ open: false, selectedDate: '' }" @open-modal.window="open = true; selectedDate = $event.detail.date">
            <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded shadow w-96">
                    <h2 class="text-lg font-bold mb-4">料理を登録</h2>
                    <p class="mb-2">選択日: <span x-text="selectedDate"></span></p>
                    <form action="" method="post">
                        @csrf
                        <input type="hidden" name="date" :value="selectedDate">
                        <label for="dish_id" class="block mb-2">料理を選択</label>
                        <select name="dish_id" id="dish_id" class="w-full border rounded mb-4" required>
                            <option value="">選択してください</option>
                            @foreach ($dishes as $dish)
                                <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">登録</button>
                    </form>
                    <button @click="open = false" class="mt-4 px-4 py-2 bg-gray-300 rounded">閉じる</button>
                </div>
            </div>
        </div>
    @endif

    @if (request()->routeIs('dishes.index'))
        @include('pages.dishes')
    @endif

</x-app-layout>
