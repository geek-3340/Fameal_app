<x-contents-board type="content">
    <h2 class="text-xl text-center font-bold mb-4">買い物リスト</h2>

    <form action="{{ route('shopping.list.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="flex justify-between">
            <x-text-input id="shopping_list_name" type="text" name="name" :value="old('shopping_list_name')" class="w-4/5 mr-2"
                required />
            <x-button>
                追加
            </x-button>
        </div>
        <x-input-error :messages="$errors->get('shopping_list_name')" class="mt-2" />
    </form>

    @if ($listItems->count() === 0)
        <div class="text-gray-400">買い物リストはありません。</div>
    @else
        @foreach ($listItems as $listItem)
            <div class="mb-2 p-2 border border-gray-200 rounded-lg flex justify-between">
                <p>{{ $listItem->name }}</p>
                {-- <form action="{{ route('babyfoods.destroy', $babufood->id) }}" method="post">
                    @csrf
                    <button class="mr-2">
                        <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                    </button>
                </form> --}
            </div>
        @endforeach
    @endif
</x-contents-board>
