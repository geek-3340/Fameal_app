<div class="flex mx-auto w-11/12 max-md:block">

    {{-- 料理登録フォーム --}}
    <x-contents-board type="two-contents" class="mx-0 mr-8 max-md:mx-auto">
        <h1 class=" text-xl text-center font-bold mb-8">料理登録</h1>
        <form action="{{ route('dishes.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="dish">
            <div class="mb-4 flex justify-between max-md:grid max-md:grid-cols-2 max-md:gap-4 max-md:text-center">

                @php
                    $categoryGroups = [
                        ['category' => '主食', 'color' => 'main', 'checked' => 'checked'],
                        ['category' => '主菜', 'color' => 'customRed', 'checked' => ''],
                        ['category' => '副菜', 'color' => 'customGreen', 'checked' => ''],
                        ['category' => 'その他', 'color' => 'gray-400', 'checked' => ''],
                    ];
                @endphp

                @foreach ($categoryGroups as $group)
                    <label class="max-md:w-5/6 max-md:mx-auto">
                        <input type="radio" name="category" value="{{ $group['category'] }}" class="hidden peer"
                            {{ $group['checked'] }}>
                        <span
                            class="cursor-pointer px-8 py-1 rounded-xl border-2 border-{{ $group['color'] }} max-xl:text-sm max-xl:px-4 max-md:block max-md:w-full peer-checked:bg-{{ $group['color'] }} peer-checked:bg-opacity-50">
                            {{ $group['category'] }}
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="w-max mx-auto">
                <x-input-label for="dish_name" :value="__('Dish name')" />
                <x-text-input id="dish_name" type="text" name="name" :value="old('dish_name')"
                    class="w-80 mt-1 mb-4 max-md:w-60" required autocomplete="off" />
                <x-auto-complete-list />
                <x-input-label for="dish_recipe_url" :value="__('Recipe URL')" />
                <x-text-input id="dish_recipe_url" type="url" name="recipe_url" :value="old('dish_recipe_url')"
                    class="w-80 mt-1 max-md:w-60" autocomplete="off" />
            </div>
            <x-button class="!block mx-auto !mt-4 max-xl:px-8">
                {{ __('Register dish') }}
            </x-button>
            <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
        </form>
    </x-contents-board>

    {{-- 料理一覧表示 --}}
    <x-contents-board type="two-contents" class="mx-0">
        <h2 class="text-xl text-center font-bold mb-4">登録料理一覧</h2>
        @if ($dishes->count() === 0)
            <div class="text-gray-400">料理登録はありません。</div>
        @else
            <p class="text-graytext text-center mb-4">料理名をクリックして料理編集・材料登録</p>

            @php
                $dishGroups = [
                    ['dishes' => $staples, 'label' => '主食', 'color' => 'main'],
                    ['dishes' => $mains, 'label' => '主菜', 'color' => 'customRed'],
                    ['dishes' => $sides, 'label' => '副菜', 'color' => 'customGreen'],
                    ['dishes' => $others, 'label' => 'その他', 'color' => 'gray-400'],
                ];
            @endphp

            @foreach ($dishGroups as $group)
                @if ($group['dishes']->count() > 0)
                    <h3 class="font-semibold text-{{ $group['color'] }} text-lg mb-2">{{ $group['label'] }}</h3>
                    @foreach ($group['dishes'] as $dish)
                        <div class="mb-2 p-2 border border-{{ $group['color'] }} rounded-lg flex justify-between">
                            <a href="#" class="open-dish-modal hover:text-{{ $group['color'] }}"
                                data-dish-id="{{ $dish->id }}">
                                {{ $dish->name }}
                            </a>
                            <form action="{{ route('dishes.destroy', $dish) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm" class="translate-y-[3px]" />
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            @endforeach
        @endif
    </x-contents-board>
</div>

@include('contents.partials.dish-edit-modal')
