<x-contents-board type="shopping-list">
    <h2 class="text-xl text-center font-bold mb-8">買い物リスト</h2>

    <form action="{{ route('shopping.list.store') }}" method="POST" class="mb-8">
        @csrf
        <div class="flex justify-center">
            <x-text-input id="shopping_list_name" type="text" name="name" :value="old('shopping_list_name')" class="w-3/5 mr-2"
                required />
            <x-button>
                追加
            </x-button>
        </div>
        <x-input-error :messages="$errors->get('shopping_list_name')" class="mt-2" />
    </form>
    {{-- <form action="{{ route('babyfoods.destroy', $babyfood->id) }}" method="post">
        @csrf
        <button class="mr-2">
            <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
        </button>
    </form> --}}

    @if ($listItems->count() === 0)
        <div class="text-gray-400">買い物リストはありません。</div>
    @else
        @foreach ($listItems as $listItem)
            <div class="mx-auto mb-2 p-2 border border-gray-200 rounded-lg flex w-4/5">
                <input type="checkbox" name="is_checked" id="shopping_list_checked"
                    class="rounded-xl w-6 h-6 mr-4 border-gray-300 text-main focus:outline-none focus:ring-0 focus:ring-offset-0">
                <p>{{ $listItem->name }}</p>
            </div>
        @endforeach
    @endif
</x-contents-board>
