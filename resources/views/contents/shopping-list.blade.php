<x-contents-board type="content">
    <h2 class="text-xl text-center font-bold mb-4">買い物リスト</h2>
    {{-- @if ($babyfoods->count() === 0)
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
        @endif --}}
</x-contents-board>
