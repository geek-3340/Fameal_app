<div class="flex mx-auto w-11/12">
    <x-contents-board type="two-contents" class="mx-0 mr-8">
        <h2 class=" text-xl text-center font-bold mb-4">離乳食登録</h2>
        <form action="{{ route('babyfoods.store') }}" method="POST">
            @csrf
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
        @if ($dishes->count() === 0)
            <div class="text-gray-400">離乳食登録はありません。</div>
        @else
            @foreach ($dishes as $dish)
                <div class="mb-2 p-2 border border-gray-200 rounded-lg flex justify-between">
                    <p>{{ $dish->name }}</p>
                    <form action="{{ route('babyfoods.destroy', $dish->id) }}" method="post">
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
