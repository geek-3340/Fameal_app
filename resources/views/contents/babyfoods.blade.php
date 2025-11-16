<div class="flex mx-auto w-11/12 max-md:block">

    {{-- 離乳食登録フォーム --}}
    <x-contents-board type="two-contents" class="mx-0 mr-8 max-md:mx-auto">
        <h2 class=" text-xl text-center font-bold mb-8">離乳食登録</h2>
        <form action="{{ route('babyfoods.store') }}" method="POST">
            @csrf
            <div class="mb-4 flex justify-between">

                @php
                    $categoryGroups = [
                        ['category' => 'エネルギー', 'color' => 'main', 'checked' => 'checked'],
                        ['category' => 'タンパク質', 'color' => 'customRed', 'checked' => ''],
                        ['category' => 'ビタミン', 'color' => 'customGreen', 'checked' => ''],
                        ['category' => 'その他', 'color' => 'gray-400', 'checked' => ''],
                    ];
                @endphp

                @foreach ($categoryGroups as $group)
                    <label>
                        <input type="radio" name="category" value="{{ $group['category'] }}" class="hidden peer"
                            {{ $group['checked'] }}>
                        <span
                            class="cursor-pointer px-4 py-1 rounded-xl border-2 border-{{ $group['color'] }} max-md:text-sm max-md:px-2 peer-checked:bg-{{ $group['color'] }} peer-checked:bg-opacity-50">
                            {{ $group['category'] }}
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="w-max mx-auto">
                <x-input-label for="babyfood_name">
                    食材名
                </x-input-label>
                <x-text-input id="babyfood_name" type="text" name="name" :value="old('babyfood_name')" class="w-80 mt-1"
                    required />
            </div>
            <x-button class="!block mx-auto !mt-4 max-md:px-8">
                {{ __('Register dish') }}
            </x-button>
            <x-input-error :messages="$errors->get('babyfood_name')" class="mt-2" />
        </form>
    </x-contents-board>

    {{-- 離乳食一覧表示 --}}
    <x-contents-board type="two-contents" class="mx-0">
        <h2 class="text-xl text-center font-bold mb-4">登録食材一覧</h2>
        @if ($babyfoods->count() === 0)
            <div class="text-gray-400">離乳食登録はありません。</div>
        @else
            @php
                $babyfoodsGroup = [
                    ['babyfoods' => $energyFoods, 'label' => 'エネルギー', 'color' => 'main'],
                    ['babyfoods' => $proteinFoods, 'label' => 'タンパク質', 'color' => 'customRed'],
                    ['babyfoods' => $vitaminFoods, 'label' => 'ビタミン', 'color' => 'customGreen'],
                    ['babyfoods' => $others, 'label' => 'その他', 'color' => 'gray-400'],
                ];
            @endphp

            @foreach ($babyfoodsGroup as $group)
                @if ($group['babyfoods']->count() > 0)
                    <h3 class="font-semibold text-{{ $group['color'] }} text-lg mb-2">{{ $group['label'] }}</h3>
                    @foreach ($group['babyfoods'] as $babyfood)
                        <div class="mb-2 p-2 border border-{{ $group['color'] }} rounded-lg flex justify-between">
                            <p>{{ $babyfood->name }}</p>
                            <form action="{{ route('babyfoods.destroy', $babyfood->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="mr-2">
                                    <x-icons.close-delete-svg size="sm"></x-icons.close-delete-svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            @endforeach

        @endif
    </x-contents-board>
</div>
