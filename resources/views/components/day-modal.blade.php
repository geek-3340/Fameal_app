<div x-data="{ open: false, selectedDate: '', formattedDate: '', dishes: [] }"
    @open-modal.window="
        open = true;
        selectedDate = $event.detail.date;
        formattedDate = $event.detail.formattedDate;
        dishes = (window.dishesByDate[selectedDate]) ? window.dishesByDate[selectedDate] : [];
    ">
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded shadow w-96">
            <div class="flex justify-between">
                <div></div>
                <h2 class="text-xl font-bold mt-3 mb-5">料理を登録</h2>
                <button @click="open = false">
                    <x-close-delete-svg size="base"></x-close-delete-svg>
                </button>
            </div>
            <form action="{{ route('menus.dishes.store') }}" method="post">
                @csrf
                <input type="hidden" name="date" :value="selectedDate">
                <label for="dish_id" class="hidden"></label>
                <div class="flex mb-8">
                    <select name="dish_id" id="dish_id" class="w-full border rounded mr-2" required>
                        <option value="">料理を選択</option>
                        @foreach ($dishes as $dish)
                            <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="flex items-center justify-center mx-auto w-24 h-10 text-sm text-text bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                        登録
                    </button>
                </div>
            </form>
            <div class="mt-6">
                <template x-if="dishes.length > 0">
                    <div>
                        <p class="mb-5 font-semibold text-lg"><span x-text="formattedDate"></span>の献立</p>
                        <ul>
                            <template x-for="dish in dishes" :key="dish.id">
                                <li class="flex items-center justify-between mb-2">
                                    <span x-text="dish.dish_name"></span>
                                    <form :action="`/menus-dishes/${dish.id}`" method="post" @submit>
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:underline text-sm">削除</button>
                                    </form>
                                </li>
                            </template>
                        </ul>
                    </div>
                </template>
                <template x-if="dishes.length === 0">
                    <div class="text-gray-400 text-sm">献立登録はありません。</div>
                </template>
            </div>
        </div>
    </div>
</div>
