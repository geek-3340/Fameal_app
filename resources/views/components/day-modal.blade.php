<div x-data="{ open: false, selectedDate: '', formattedDate: '', dishes: [] }"
    @open-modal.window="
        open = true;
        selectedDate = $event.detail.date;
        formattedDate = $event.detail.formattedDate;
        dishes = (window.dishesByDate[selectedDate]) ? window.dishesByDate[selectedDate] : [];
    ">
    <div x-show="open" x-cloak @keydown.escape.window="open = false"
        class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
        <x-contents-board class="bg-white" @click.away="open = false">

            <div class="flex justify-between items-start">
                <div></div>
                <h2 class="text-xl font-bold mb-8">料理を登録</h2>
                <button @click="open = false" class="pt-1">
                    <x-icons.close-delete-svg size="base" class="" />
                </button>
            </div>
            <form action="{{ route('menus.dishes.store') }}" method="post">
                @csrf
                <input type="hidden" name="date" :value="selectedDate">
                <label for="dish_id" class="hidden"></label>
                <select name="dish_id" id="dish_id" class="w-full border rounded mb-4 focus:border-main focus:ring-main" required>
                    <option value="">料理を選択</option>
                    @foreach ($dishes as $dish)
                        <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                    @endforeach
                </select>
                <x-button type="submit" width="full">
                    登録
                </x-button>
            </form>

            <div class="w-full border-b border-gray-300 mt-4"></div>

            <div class="mt-4">
                <template x-if="dishes.length > 0">
                    <div>
                        <p class="mb-4 font-semibold"><span x-text="formattedDate"></span>の献立</p>
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
                    <div>
                        <p class="mb-4 font-semibold block"><span x-text="formattedDate"></span>の献立</p>
                        <div class="text-gray-400 text-sm">献立登録はありません。</div>
                    </div>
                </template>
            </div>

        </x-contents-board>
    </div>
</div>
