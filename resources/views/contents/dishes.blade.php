<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h1 class=" text-2xl text-center font-bold mb-4">料理登録</h1>
        <form action="{{ route('dishes.store') }}" method="POST">
            @csrf
            <div class="flex justify-between w-full">
                <div class="flex w-5/6">
                    <x-input-label for="dish_name" :value="__('Dish name')"
                        class="flex items-center text-xl font-normal w-20 mr-2" />
                    <x-text-input id="dish_name" type="text" name="name" :value="old('dish_name')" class="w-full mr-2"
                        required />
                </div>
                <x-button class="w-1/6">
                    {{ __('Register dish') }}
                </x-button>
            </div>
            <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
        </form>
    </x-contents-board>
    <x-contents-board type="two-contents" class="mx-0">
        <h1 class="text-2xl text-center font-bold mb-4">登録料理一覧</h1>
        @foreach ($dishes as $dish)
            <div class="mb-2 p-2 border border-gray-200 rounded-lg flex justify-between">
                <p class=" text-base">{{ $dish->name }}</p>
                <form action="{{ route('dishes.destroy', $dish->id) }}" method="post">
                    @csrf
                    <button class="mr-3">
                        <x-close-delete-svg size="sm"></x-close-delete-svg>
                    </button>
                </form>
            </div>
        @endforeach
    </x-contents-board>
</div>
