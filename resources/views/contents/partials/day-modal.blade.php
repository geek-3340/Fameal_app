{{-- 献立登録モーダル --}}
<div x-data="{ open: false, selectedDate: '', formattedDate: '', dishes: [] }"
    @open-day-modal.window="
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

            {{-- 献立登録フォーム --}}
            <form action="{{ route('menus.dishes.store') }}" method="post">
                @csrf
                <input type="hidden" name="date" :value="selectedDate">
                <div class="mb-4 flex justify-between">
                    @foreach (['朝食' => 'checked', '昼食' => '', '夕食' => ''] as $category => $checked)
                        <label>
                            <input type="radio" name="category" value="{{ $category }}" class="hidden peer"
                                {{ $checked }}>
                            <span
                                class="cursor-pointer px-4 py-1 rounded-xl border-2 border-main peer-checked:bg-main peer-checked:bg-opacity-50">
                                {{ $category }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <label for="dish_id" class="hidden"></label>
                <select name="dish_id" id="dish_id"
                    class="w-full border rounded mb-4 focus:border-main focus:ring-main" required>
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

            {{-- 献立一覧表示 --}}
            <div class="mt-4 pr-1 max-h-[50vh] overflow-y-auto scrollbar">
                @foreach (['朝食', '昼食', '夕食'] as $category)
                    <template x-if="dishes.filter(d => d.menu_category === '{{ $category }}').length > 0">
                        <div class="mb-2">
                            <h3 class="text-main">{{ $category }}</h3>
                            <ul class="border-t border-dashed border-gray-300">
                                <template x-for="dish in dishes.filter(d => d.menu_category === '{{ $category }}')"
                                    :key="dish.id">
                                    <li
                                        class="flex items-center justify-between py-1 border-b border-dashed border-gray-300">
                                        <div class="flex flex-col">
                                            <span x-text="dish.dish_name" class="text-sm"></span>
                                            <template x-if="dish.dish_recipe_url">
                                                <a :href="dish.dish_recipe_url" target="_blank" +
                                                    class="pb-[1px] text-xs text-link hover:pb-0 hover:border-b border-link transition">
                                                    レシピサイト
                                                </a>
                                            </template>
                                        </div>
                                        <form :action="`/menus-dishes/${dish.id}`" method="post" @submit>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-sm">削除</button>
                                        </form>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                @endforeach
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
