<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h1 class=" text-xl text-center font-bold mb-8">料理登録</h1>
        <form action="{{ route('dishes.store') }}" method="POST">
            @csrf
            <div class="mb-4 flex justify-between">
                <label>
                    <input type="radio" name="category" value="主食" class="hidden peer" checked>
                    <span
                        class="cursor-pointer px-8 py-1 rounded-xl border border-main peer-checked:bg-main peer-checked:bg-opacity-50">
                        主食
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" value="主菜" class="hidden peer">
                    <span
                        class="cursor-pointer px-8 py-1 rounded-xl border border-customRed peer-checked:bg-customRed peer-checked:bg-opacity-50">
                        主菜
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" value="副菜" class="hidden peer">
                    <span
                        class="cursor-pointer px-8 py-1 rounded-xl border border-customGreen peer-checked:bg-customGreen peer-checked:bg-opacity-50">
                        副菜
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" value="その他" class="hidden peer">
                    <span
                        class="cursor-pointer px-8 py-1 rounded-xl border border-gray-400 peer-checked:bg-gray-400 peer-checked:bg-opacity-50">
                        その他
                    </span>
                </label>
            </div>
            <div>
                <x-input-label for="dish_name" class="translate-x-[10%]" :value="__('Dish name')" />
                <x-text-input id="dish_name" type="text" name="name" :value="old('dish_name')"
                    class="w-4/5 translate-x-[10%] mt-1 mb-4" required />
                <x-input-label for="dish_recipe_url" class="translate-x-[10%]" :value="__('Recipe URL')" />
                <x-text-input id="dish_recipe_url" type="text" name="recipe_url" :value="old('dish_recipe_url')"
                    class="w-4/5 translate-x-[10%] mt-1" />
            </div>
            <x-button class="!block mx-auto !mt-4 w-3/12">
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
                @if ($staples->count() > 0)
                    <h3 class="font-semibold text-main text-lg mb-2">主食</h3>
                    @foreach ($staples as $staple)
                        <div class="mb-2 p-2 border border-main rounded-lg flex justify-between">
                            <p>{{ $staple->name }}</p>
                            <form action="{{ route('dishes.destroy', $staple->id) }}" method="post">
                                @csrf
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
                @if ($mains->count() > 0)
                    <h3 class="font-semibold text-customRed text-lg mb-2">主菜</h3>
                    @foreach ($mains as $main)
                        <div class="mb-2 p-2 border border-customRed rounded-lg flex justify-between">
                            <p>{{ $main->name }}</p>
                            <form action="{{ route('dishes.destroy', $main->id) }}" method="post">
                                @csrf
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
                @if ($sides->count() > 0)
                    <h3 class="font-semibold text-customGreen text-lg mb-2">副菜</h3>
                    @foreach ($sides as $side)
                        <div class="mb-2 p-2 border border-customGreen rounded-lg flex justify-between">
                            <p>{{ $side->name }}</p>
                            <form action="{{ route('dishes.destroy', $side->id) }}" method="post">
                                @csrf
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
                @if ($others->count() > 0)
                    <h3 class="font-semibold text-gray-400 text-lg mb-2">その他</h3>
                    @foreach ($others as $other)
                        <div class="mb-2 p-2 border border-gray-400 rounded-lg flex justify-between">
                            <p>{{ $other->name }}</p>
                            <form action="{{ route('dishes.destroy', $other->id) }}" method="post">
                                @csrf
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            @endif
    </x-contents-board>
</div>
