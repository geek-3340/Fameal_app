<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h1 class=" text-xl text-center font-bold mb-8">料理登録</h1>
        <form action="{{ route('dishes.store') }}" method="POST">
            @csrf
            {{-- カテゴリー選択 --}}
            <div class="mb-4 flex justify-between">
                @foreach (['主食' => 'main', '主菜' => 'customRed', '副菜' => 'customGreen', 'その他' => 'gray-400'] as $label => $color)
                    <label>
                        <input type="radio" name="category" :value="'{{ $label }}'" class="hidden peer"
                            x-model="dish.category">
                        <span
                            class="cursor-pointer px-8 py-1 rounded-xl border-2 border-{{ $color }} peer-checked:bg-{{ $color }} peer-checked:bg-opacity-50">
                            {{ $label }}
                        </span>
                    </label>
                @endforeach
            </div>
            <div>
                <x-input-label for="dish_name" class="translate-x-[10%]" :value="__('Dish name')" />
                <x-text-input id="dish_name" type="text" name="name" :value="old('dish_name')"
                    class="w-4/5 translate-x-[10%] mt-1 mb-4" required />
                <x-input-label for="dish_recipe_url" class="translate-x-[10%]" :value="__('Recipe URL')" />
                <x-text-input id="dish_recipe_url" type="url" name="recipe_url" :value="old('dish_recipe_url')"
                    class="w-4/5 translate-x-[10%] mt-1" />
            </div>
            <x-button class="!block mx-auto !mt-4">
                {{ __('Register dish') }}
            </x-button>
            <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
        </form>
    </x-contents-board>

    <x-contents-board type="two-contents" class="mx-0">
        <h2 class="text-xl text-center font-bold mb-4">登録料理一覧</h1>
            @if ($dishes->count() === 0)
                <div class="text-gray-400">料理登録はありません。</div>
            @else
                <p class="text-graytext text-center">料理名をクリックして料理編集・材料登録</p>
                @if ($staples->count() > 0)
                    <h3 class="font-semibold text-main text-lg mb-2">主食</h3>
                    @foreach ($staples as $staple)
                        <div class="mb-2 p-2 border border-main rounded-lg flex justify-between">
                            <a href="#" class="open-dish-modal"
                                data-dish-id="{{ $staple->id }}">{{ $staple->name }}</a>
                            <form action="{{ route('dishes.destroy', $staple) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"
                                        class="translate-y-[3px]"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
                @if ($mains->count() > 0)
                    <h3 class="font-semibold text-customRed text-lg mb-2">主菜</h3>
                    @foreach ($mains as $main)
                        <div class="mb-2 p-2 border border-customRed rounded-lg flex justify-between">
                            <a href="#" class="open-dish-modal"
                                data-dish-id="{{ $main->id }}">{{ $main->name }}</a>
                            <form action="{{ route('dishes.destroy', $main) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"
                                        class="translate-y-[3px]"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
                @if ($sides->count() > 0)
                    <h3 class="font-semibold text-customGreen text-lg mb-2">副菜</h3>
                    @foreach ($sides as $side)
                        <div class="mb-2 p-2 border border-customGreen rounded-lg flex justify-between">
                            <a href="#" class="open-dish-modal"
                                data-dish-id="{{ $side->id }}">{{ $side->name }}</a>
                            <form action="{{ route('dishes.destroy', $side) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"
                                        class="translate-y-[3px]"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
                @if ($others->count() > 0)
                    <h3 class="font-semibold text-gray-400 text-lg mb-2">その他</h3>
                    @foreach ($others as $other)
                        <div class="mb-2 p-2 border border-gray-400 rounded-lg flex justify-between">
                            <a href="#" class="open-dish-modal"
                                data-dish-id="{{ $other->id }}">{{ $other->name }}</a>
                            <form action="{{ route('dishes.destroy', $other) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"
                                        class="translate-y-[3px]"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            @endif
    </x-contents-board>
</div>

{{-- dish modal --}}
<div x-data="{ open: false, dish: {}, ingredients: [] }"
    @open-dish-modal.window="
        dish = $event.detail.dish;
        ingredients=$event.detail.ingredients;
        open = true;
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
            <form :action="`/dishes/${dish.id}`" method="POST" id="dish-update" class="w-full">
                @csrf
                @method('PUT')
                {{-- カテゴリー選択 --}}
                <div class="mb-4 flex justify-between">
                    @foreach (['主食' => 'main', '主菜' => 'customRed', '副菜' => 'customGreen', 'その他' => 'gray-400'] as $label => $color)
                        <label>
                            <input type="radio" name="category" :value="'{{ $label }}'" class="hidden peer"
                                x-model="dish.category">
                            <span
                                class="cursor-pointer px-8 py-1 rounded-xl border-2 border-{{ $color }} peer-checked:bg-{{ $color }} peer-checked:bg-opacity-50">
                                {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>
                {{-- Dish name --}}
                <div class="w-max mx-auto">
                    <x-input-label for="dish_name" :value="__('Dish name')" />
                    <x-text-input id="dish_name" type="url" name="name" class="w-80 mt-1 mb-4"
                        x-model="dish.name" {{-- ← 初期値をバインド --}} required />
                    <x-input-label for="dish_recipe_url" :value="__('Recipe URL')" />
                    <x-text-input id="dish_recipe_url" type="text" name="recipe_url" class="w-80 mt-1"
                        x-model="dish.recipe_url" {{-- ← これも同様 --}} />
                </div>
                <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
                <x-button class="!block mx-auto !mt-4">
                    {{ __('Save') }}
                </x-button>
            </form>

            <div class="w-4/5 border-b border-gray-300 mx-auto mt-4"></div>

            <form action="{{ route('ingredients.store') }}" method="POST" class="w-max mx-auto">
                @csrf
                <x-input-label for="ingredients_name" class="mt-4" :value="__('Ingredient name')" />
                <x-text-input id="ingredients_name" type="text" name="name" use="secondary"
                    class="w-60 mt-1 mr-1" />
                <input type="hidden" name="dish_id" :value="dish.id">
                <x-button use="register">
                    {{ __('Register Ingredients') }}
                </x-button>
            </form>

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
                                        <form :action="`/ingredients/${ingredient.id}`" method="post" @submit>
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
