<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h1 class=" text-xl text-center font-bold mb-8">料理登録</h1>
        <form action="{{ route('dishes.store') }}" method="POST">
            @csrf
            <div class="mb-4 flex justify-between">
                <label>
                    <input type="radio" name="category" class="hidden peer" checked>
                    <span class="px-8 py-1 rounded-xl border border-main peer-checked:bg-sub">
                        主食
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" class="hidden peer">
                    <span class="px-8 py-1 rounded-xl border border-red-400 peer-checked:bg-red-300">
                        主菜
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" class="hidden peer">
                    <span class="px-8 py-1 rounded-xl border border-green-400 peer-checked:bg-green-300">
                        副菜
                    </span>
                </label>
                <label>
                    <input type="radio" name="category" class="hidden peer">
                    <span class="px-8 py-1 rounded-xl border border-gray-400 peer-checked:bg-gray-300">
                        その他
                    </span>
                </label>
            </div>
            <x-input-label for="dish_name" :value="__('Dish name')" />
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
        <h1 class="text-xl text-center font-bold mb-4">登録料理一覧</h1>
        @if ($dishes->count() === 0)
            <div class="text-gray-400">料理登録はありません。</div>
        @else
            @foreach ($dishes as $dish)
                <div class="mb-2 p-2 border border-gray-200 rounded-lg flex justify-between">
                    <p>{{ $dish->name }}</p>
                    <form action="{{ route('dishes.destroy', $dish->id) }}" method="post">
                        @csrf
                        <button class="mr-2">
                            <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </x-contents-board>
</div>
