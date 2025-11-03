{{-- 献立登録モーダル --}}
<div x-data="{ open: false, selectedDate: '', formattedDate: '', dishes: [] }"
    @open-menu-edit-modal.window="
        open = true;
        selectedDate = $event.detail.date;
        formattedDate = $event.detail.formattedDate;
        dishes = (window.dishesByDate[selectedDate]) ? window.dishesByDate[selectedDate] : [];
    "
    @menu-updated.window="
        dishes = [...(window.dishesByDate[selectedDate] || []),$event.detail.newModalDish];
    ">
    <div x-show="open" x-cloak @keydown.escape.window="open = false"
        class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
        <x-contents-board type="modal" class="bg-white" @click.away="open = false">
            <div class="flex justify-between items-start">
                <div></div>
                @if ($type === 'dish')
                    <h2 class="text-xl font-bold mb-8">料理を登録</h2>
                @else
                    <h2 class="text-xl font-bold mb-8">離乳食を登録</h2>
                @endif
                <button @click="open = false" class="pt-1">
                    <x-icons.close-delete-svg size="base" class="" />
                </button>
            </div>

            {{-- 献立登録フォーム --}}
            <form id="dish-and-baby-food-form" action="{{ route('menus.dishes.store') }}" method="post">
                @csrf
                <input type="hidden" name="date" :value="selectedDate">
                <div class="w-4/5 mx-auto text-center">
                    <div class="mb-6 flex justify-between">
                        @foreach (['朝食' => 'checked', '昼食' => '', '夕食' => ''] as $category => $checked)
                            <label>
                                <input type="radio" name="category" value="{{ $category }}" class="hidden peer"
                                    {{ $checked }}>
                                <span
                                    class="cursor-pointer px-6 py-1 rounded-xl border-2 border-main peer-checked:bg-main peer-checked:bg-opacity-50">
                                    {{ $category }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @if ($type === 'dish')
                        <label for="dish_id" class="hidden"></label>
                        <select name="dish_id" id="dish_id"
                            class="w-4/5 border-gray-300 rounded-md mb-4 shadow-sm focus:border-main focus:ring-main"
                            required>
                            <option value="">料理を選択</option>
                            @foreach ($dishes as $dish)
                                <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <label for="dish_id" class="hidden"></label>
                        <select name="dish_id" id="dish_id"
                            class="w-3/5 border-gray-300 rounded-md mb-4 shadow-sm focus:border-main focus:ring-main"
                            required>
                            <option value="">離乳食を選択</option>
                            @foreach ($dishes as $dish)
                                <option value="{{ $dish->id }}">{{ $dish->name }}</option>
                            @endforeach
                        </select>
                        <x-text-input id="gram" type="number" :min="0" :step="5" name="gram"
                            :value="old('gram')" class="ml-2 w-1/5" />
                        <p class="inline text-lg ml-1">g</p>
                    @endif
                    <x-button type="submit" class="!block mx-auto">
                        登録
                    </x-button>
                </div>
            </form>

            <div class="w-full border-b border-gray-300 mt-4"></div>

            {{-- 献立一覧表示 --}}
            <div class="w-4/5 mx-auto">
                <p class="my-4 font-semibold block"><span x-text="formattedDate"></span>の献立</p>
                <div class="mt-4 pr-1 max-h-[40vh] overflow-y-auto scrollbar">
                    @foreach (['朝食', '昼食', '夕食'] as $category)
                        <template x-if="dishes.filter(d => d.menu_category === '{{ $category }}').length > 0">
                            <div class="mb-2">
                                <h3 class="text-main">{{ $category }}</h3>
                                <ul class="border-t border-dashed border-gray-300">
                                    <template
                                        x-for="dish in dishes.filter(d => d.menu_category === '{{ $category }}')"
                                        :key="dish.id">
                                        <li
                                            class="flex items-center justify-between py-1 border-b border-dashed border-gray-300">
                                            <div class="flex flex-col">
                                                <span
                                                    x-text="`${dish.dish_name} ${dish.dish_gram ? dish.dish_gram + 'g' : ''}`"
                                                    class="text-sm"></span>
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
                            <div class="text-gray-400 text-sm">献立登録はありません。</div>
                        </div>
                    </template>
                </div>
            </div>
        </x-contents-board>
    </div>
</div>
