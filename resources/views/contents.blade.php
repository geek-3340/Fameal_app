<x-app-layout>
    @if (request()->routeIs('menus.month.index') ||
            request()->routeIs('menus.week.index') ||
            request()->routeIs('baby.menus.month.index') ||
            request()->routeIs('baby.menus.week.index'))
        <div id="calendar"
            data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
            data-month-url="{{ route('menus.month.index') }}" data-week-url="{{ route('menus.week.index') }}"
            data-menus-event='@json($events)'></div>
        {{-- モーダル部分例 --}}
        <div x-data="{ open: false, selectedDate: '' }" @open-modal.window="open = true; selectedDate = $event.detail.date">
            <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
                <div class="bg-white p-6 rounded shadow w-96">
                    <div class="flex justify-between">
                        <h2 class="text-lg font-bold mt-3 mb-5">料理を登録</h2>
                        <button @click="open = false" class="">
                            <svg fill="#3d3d3d" version="1.1" id="Ebene_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64"
                                enable-background="new 0 0 64 64" xml:space="preserve" stroke="#3d3d3d" class="w-6 h-6">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <path
                                            d="M17.586,46.414C17.977,46.805,18.488,47,19,47s1.023-0.195,1.414-0.586L32,34.828l11.586,11.586 C43.977,46.805,44.488,47,45,47s1.023-0.195,1.414-0.586c0.781-0.781,0.781-2.047,0-2.828L34.828,32l11.586-11.586 c0.781-0.781,0.781-2.047,0-2.828c-0.781-0.781-2.047-0.781-2.828,0L32,29.172L20.414,17.586c-0.781-0.781-2.047-0.781-2.828,0 c-0.781,0.781-0.781,2.047,0,2.828L29.172,32L17.586,43.586C16.805,44.367,16.805,45.633,17.586,46.414z">
                                        </path>
                                        <path
                                            d="M32,64c8.547,0,16.583-3.329,22.626-9.373C60.671,48.583,64,40.547,64,32s-3.329-16.583-9.374-22.626 C48.583,3.329,40.547,0,32,0S15.417,3.329,9.374,9.373C3.329,15.417,0,23.453,0,32s3.329,16.583,9.374,22.626 C15.417,60.671,23.453,64,32,64z M12.202,12.202C17.49,6.913,24.521,4,32,4s14.51,2.913,19.798,8.202C57.087,17.49,60,24.521,60,32 s-2.913,14.51-8.202,19.798C46.51,57.087,39.479,60,32,60s-14.51-2.913-19.798-8.202C6.913,46.51,4,39.479,4,32 S6.913,17.49,12.202,12.202z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </button>
                    </div>
                    <p class="mb-5">選択日: <span x-text="selectedDate"></span></p>
                    <form action="{{ route('menus.dishes.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="date" :value="selectedDate">
                        <label for="dish_id" class="block mb-2">料理を選択</label>
                        <select name="dish_id" id="dish_id" class="w-full border rounded mb-4" required>
                            <option value="">選択してください</option>
                            @foreach ($dishes as $dish)
                                <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="flex items-center justify-center mt-3 mx-auto w-24 h-10 text-sm text-text bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">登録</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if (request()->routeIs('dishes.index'))
        @include('pages.dishes')
    @endif

</x-app-layout>
