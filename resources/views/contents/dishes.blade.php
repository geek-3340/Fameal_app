<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h1 class=" text-xl text-center font-bold mb-4">料理登録</h1>
        <form action="{{ route('dishes.store') }}" method="POST">
            @csrf
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
    </x-contents-board>
</div>
