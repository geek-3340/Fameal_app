<x-contents-board type="shopping-list">
    <h2 class="text-xl text-center font-bold mb-8">買い物リスト</h2>

    {{-- 買い物リスト追加フォーム --}}
    <form action="{{ route('shopping.list.store') }}" method="POST" class="mb-4">
        @csrf
        <div class="flex justify-between w-4/5 mx-auto max-xl:w-full">
            <x-text-input id="shopping_list_name" type="text" name="name" :value="old('shopping_list_name')" class="w-4/5 mr-2"
                required />
            <x-button class="w-[25%]">
                追加
            </x-button>
        </div>
        <x-input-error :messages="$errors->get('shopping_list_name')" class="mt-2" />
    </form>
    <hr class="mb-4 md:hidden">
    <form action="/shopping-list/ingredients" method="POST">
        @csrf
        <div class="flex items-center justify-between w-4/5 mx-auto mb-4 max-xl:block max-xl:w-full">
            <input type="hidden" name="start" id="start">
            <input type="hidden" name="end" id="end">
            <div class="flex max-xl:items-center max-xl:justify-center">
                <button type="button" id="prevWeek"
                    class="text-white font-bold bg-main w-8 h-8 rounded-md hover:bg-button-primaryhover transition-colors duration-200">
                    ＜</button>
                <span id="weekDisplay" class="block text-lg font-semibold mx-2 w-[300px] text-center max-xl:text-base max-xl:w-max"></span>
                <button type="button" id="nextWeek"
                    class="text-white font-bold bg-main w-8 h-8 rounded-md hover:bg-button-primaryhover transition-colors duration-200">
                    ＞</button>
            </div>
            <x-button type="submit" use="register" class="max-xl:block max-xl:mx-auto max-xl:mt-4">材料を追加</x-button>
        </div>
    </form>
    <hr class="mb-4 md:hidden">
    <form action="{{ route('shopping.list.destroy') }}" method="post" class="flex justify-end w-4/5 mx-auto mb-8 max-xl:block max-xl:w-full max-xl:text-center max-xl:mb-4">
        @csrf
        @method('DELETE')
        <x-button use="danger">チェック項目削除</x-button>
    </form>
    <hr class="mb-4 md:hidden">


    {{-- 買い物リスト一覧表示 --}}
    @if ($listItems->count() === 0)
        <div class="text-gray-400 w-4/5 mx-auto">買い物リストはありません。</div>
    @else
        <ul>
            @foreach ($listItems as $listItem)
                <li class="mx-auto mb-2 p-2 border border-gray-200 rounded-lg flex w-4/5 max-xl:w-full">
                    <input type="checkbox" data-id="{{ $listItem->id }}" {{ $listItem->is_checked ? 'checked' : '' }}
                        class="rounded-xl w-6 h-6 mr-4 border-gray-300 text-main focus:outline-none focus:ring-0 focus:ring-offset-0">
                    <p class="{{ $listItem->is_checked ? 'line-through text-gray-400' : '' }}">{{ $listItem->name }}
                    </p>
                </li>
            @endforeach
        </ul>
    @endif
</x-contents-board>
