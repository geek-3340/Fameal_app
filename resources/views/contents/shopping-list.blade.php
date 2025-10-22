<x-contents-board type="shopping-list">
    <h2 class="text-xl text-center font-bold mb-8">買い物リスト</h2>

    <form action="{{ route('shopping.list.store') }}" method="POST" class="mb-8">
        @csrf
        <div class="flex justify-between w-4/5 mx-auto">
            <x-text-input id="shopping_list_name" type="text" name="name" :value="old('shopping_list_name')" class="w-4/5 mr-2"
                required />
            <x-button class="w-1/5">
                追　加
            </x-button>
        </div>
        <x-input-error :messages="$errors->get('shopping_list_name')" class="mt-2" />
    </form>
    <div class="w-4/5 mx-auto mb-8 flex justify-center gap-4">
        <form action=""><x-button use="register">買い物リスト自動作成</x-button></form>
        <form action="{{ route('shopping.list.destroy') }}" method="post">
            @csrf
            <x-button use="danger">チェック項目削除</x-button>
        </form>
    </div>

    @if ($listItems->count() === 0)
        <div class="text-gray-400">買い物リストはありません。</div>
    @else
        <ul>
        @foreach ($listItems as $listItem)
            <li class="mx-auto mb-2 p-2 border border-gray-200 rounded-lg flex w-4/5">
                <input type="checkbox" data-id="{{ $listItem->id }}" {{ $listItem->is_checked ? 'checked' : '' }}
                    class="rounded-xl w-6 h-6 mr-4 border-gray-300 text-main focus:outline-none focus:ring-0 focus:ring-offset-0">
                <p class="{{ $listItem->is_checked ? 'line-through text-gray-400' : '' }}">{{ $listItem->name }}
                </p>
            </li>
        @endforeach
        </ul>
    @endif
</x-contents-board>
