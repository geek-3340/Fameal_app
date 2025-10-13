<!-- <div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h1 class=" text-xl text-center font-bold mb-4">離乳食登録</h1>
        <form action="{{ route('babyfoods.store') }}" method="POST">
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
        <h1 class="text-xl text-center font-bold mb-4">登録食材一覧</h1>
        @if ($babyfoods->count() === 0)
            <div class="text-gray-400">離乳食登録はありません。</div>
        @else
            @foreach ($babyfoods as $babyfood)
                <div class="mb-2 p-2 border border-gray-200 rounded-lg flex justify-between">
                    <p>{{ $babyfood->name }}</p>
                    <form action="{{ route('babyfoods.destroy', $babufood->id) }}" method="post">
                        @csrf
                        <button class="mr-2">
                            <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                        </button>
                    </form>
                </div>
            @endforeach
        @endif
    </x-contents-board>
</div> -->
