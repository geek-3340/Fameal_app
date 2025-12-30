{{-- 料理編集モーダル --}}
<div x-data="{ open: false, dish: {}, ingredients: [] }"
    @open-dish-modal.window="
        dish = $event.detail.dish;
        ingredients=$event.detail.ingredients;
        open = true;
    "
    @ingredients-updated.window="
        ingredients=$event.detail.newIngredients;
    ">
    <div x-show="open" x-cloak @keydown.escape.window="open = false"
        class="fixed inset-0 flex items-center justify-center bg-main bg-opacity-50 z-50">
        <x-contents-board type="modal" class="bg-white" @click.away="open = false">
            <div class="flex justify-between items-start">
                <div></div>
                <h2 class="text-xl font-bold mb-8">料理編集</h2>
                <button @click="open = false" class="pt-1">
                    <x-icons.close-delete-svg size="base" class="" />
                </button>
            </div>

            {{-- 料理更新フォーム --}}
            <form :action="`/dishes/${dish.id}`" method="POST" id="dish-update" class="w-full">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="dish">
                <div class="mb-4 flex justify-between">
                    @foreach (['主食' => 'main', '主菜' => 'customRed', '副菜' => 'customGreen', 'その他' => 'gray-400'] as $label => $color)
                        <label>
                            <input type="radio" name="category" :value="'{{ $label }}'" class="hidden peer"
                                x-model="dish.category">
                            <span
                                class="cursor-pointer px-8 py-1 rounded-xl border-2 border-{{ $color }} max-md:text-sm max-md:px-4 peer-checked:bg-{{ $color }} peer-checked:bg-opacity-50">
                                {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="w-max mx-auto">
                    <x-input-label for="dish_name" :value="__('Dish name')" />
                    <x-text-input id="dish_name" type="text" name="name" class="w-80 mt-1 mb-4"
                        x-model="dish.name" required autocomplete="off" />
                    <x-input-label for="dish_recipe_url" :value="__('Recipe URL')" />
                    <x-text-input id="dish_recipe_url" type="url" name="recipe_url" class="w-80 mt-1"
                        x-model="dish.recipe_url" autocomplete="off" />
                </div>
                <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
                <x-button class="!block mx-auto !mt-4 max-md:px-8">
                    {{ __('Save') }}
                </x-button>
            </form>

            <div class="w-4/5 border-b border-gray-300 mx-auto mt-4"></div>

            {{-- 材料登録フォーム --}}
            <form action="{{ route('ingredients.store') }}" method="POST" id="ingredients-store-form"
                class="w-max mx-auto">
                @csrf
                <x-input-label for="ingredients_name" class="mt-4" :value="__('Ingredient name')" />
                <x-text-input id="ingredients_name" type="text" name="name" use="secondary" class="w-60 mt-1 mr-1"
                    autocomplete="off" />
                <x-suggest-list color="accent" id="ingredients-suggest-list" />
                <input type="hidden" name="dish_id" :value="dish.id">
                <x-button use="register">
                    {{ __('Register Ingredients') }}
                </x-button>
            </form>

            {{-- 材料一覧表示 --}}
            <div class="w-4/5 mx-auto mt-4">
                <template x-if="ingredients.length > 0">
                    <div class="mb-2">
                        <h3 class="text-accent">材料一覧</h3>
                        <div class="pr-1 max-h-[16vh] overflow-y-auto scrollbar">
                            <ul class="border-t border-dashed border-gray-300">
                                <template x-for="ingredient in ingredients" :key="ingredient.id">
                                    <li
                                        class="flex items-center justify-between py-1 border-b border-dashed border-gray-300">
                                        <span x-text="ingredient.name" class="text-sm"></span>
                                        <form :action="`/ingredients/${ingredient.id}`" method="post"
                                            class="ingredient-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:underline text-sm">削除</button>
                                        </form>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </template>
                <template x-if="ingredients.length === 0">
                    <div>
                        <div class="text-gray-400 text-sm">材料登録はありません。</div>
                    </div>
                </template>
            </div>

        </x-contents-board>
    </div>
</div>
