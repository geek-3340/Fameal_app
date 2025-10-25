<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h2 class=" text-xl text-center font-bold mb-8">離乳食登録</h2>
        <form action="{{ route('babyfoods.store') }}" method="POST">
            @csrf
            <div class="mb-4 flex justify-between">
                <label>
                    <input type="radio" name="category" value="エネルギー" class="hidden peer" checked>
                    <span
                        class="cursor-pointer px-5 py-1 rounded-xl border-2 border-main peer-checked:bg-main peer-checked:bg-opacity-50">
                        エネルギー
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" value="タンパク質" class="hidden peer">
                    <span
                        class="cursor-pointer px-5 py-1 rounded-xl border-2 border-customRed peer-checked:bg-customRed peer-checked:bg-opacity-50">
                        タンパク質
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" value="ビタミン" class="hidden peer">
                    <span
                        class="cursor-pointer px-5 py-1 rounded-xl border-2 border-customGreen peer-checked:bg-customGreen peer-checked:bg-opacity-50">
                        ビタミン
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" value="その他" class="hidden peer">
                    <span
                        class="cursor-pointer px-5 py-1 rounded-xl border-2 border-gray-400 peer-checked:bg-gray-400 peer-checked:bg-opacity-50">
                        その他
                    </span>
                </label>
            </div>
            <x-input-label for="dish_name">
                食材名
            </x-input-label>
            <div class="flex justify-between">
                <x-text-input id="dish_name" type="text" name="name" :value="old('dish_name')" class="w-4/5 mt-1 mr-2"
                    required />
                <x-button>
                    {{ __('Register dish') }}
                </x-button>
            </div>
            <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
        </form>
    </x-contents-board>

    <x-contents-board type="two-contents" class="mx-0">
        <h2 class="text-xl text-center font-bold mb-4">登録食材一覧</h2>
        @if ($babyfoods->count() === 0)
            <div class="text-gray-400">離乳食登録はありません。</div>
        @else
            @if ($energyFoods->count() > 0)
                <h3 class="font-semibold text-main text-lg mb-2">エネルギー</h3>
                @foreach ($energyFoods as $energyFood)
                    <div class="mb-2 p-2 border border-main rounded-lg flex justify-between">
                        <p>{{ $energyFood->name }}</p>
                        <form action="{{ route('dishes.destroy', $energyFood->id) }}" method="post">
                            @csrf
                            <button class="mr-2">
                                <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
            @if ($proteinFoods->count() > 0)
                <h3 class="font-semibold text-customRed text-lg mb-2">タンパク質</h3>
                @foreach ($proteinFoods as $proteinFood)
                    <div class="mb-2 p-2 border border-customRed rounded-lg flex justify-between">
                        <p>{{ $proteinFood->name }}</p>
                        <form action="{{ route('dishes.destroy', $proteinFood->id) }}" method="post">
                            @csrf
                            <button class="mr-2">
                                <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
            @if ($vitaminFoods->count() > 0)
                <h3 class="font-semibold text-customGreen text-lg mb-2">ビタミン</h3>
                @foreach ($vitaminFoods as $vitaminFood)
                    <div class="mb-2 p-2 border border-customGreen rounded-lg flex justify-between">
                        <p>{{ $vitaminFood->name }}</p>
                        <form action="{{ route('dishes.destroy', $vitaminFood->id) }}" method="post">
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
