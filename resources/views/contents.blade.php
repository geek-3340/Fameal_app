<x-app-layout>
    @if (request()->routeIs('menus.month.index') ||
            request()->routeIs('menus.week.index') ||
            request()->routeIs('baby.menus.month.index') ||
            request()->routeIs('baby.menus.week.index'))
        <div
            id="calendar"
            data-initial-view="{{ request()->routeIs('menus.week.index') ? 'dayGridWeek' : 'dayGridMonth' }}"
            data-month-url="{{ route('menus.month.index') }}"
            data-week-url="{{ route('menus.week.index') }}"
        ></div>
    @endif
    @if (request()->routeIs('dishes.index'))
        <div class="flex mx-auto">
            <div class="w-1/2 h-max mx-5 p-10 border border-filter rounded-xl">
                <h1 class=" text-2xl text-center font-bold mb-4">料理登録</h1>
                <form action="{{ route('dishes.store') }}" method="POST">
                    @csrf
                    <div>
                        <div class="flex">
                            <x-input-label for="dish_name" :value="__('Dish name')"
                                class="flex items-center mr-3 text-xl font-normal" />
                            <x-text-input id="dish_name" type="text" name="name" :value="old('dish_name')" required />
                        </div>
                        <x-input-error :messages="$errors->get('dish_name')" class="mt-2" />
                    </div>
                    <button
                        class="flex items-center justify-center mt-6 mx-auto w-24 h-10 text-sm text-text bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                        {{ __('Register dish') }}
                    </button>
                </form>
            </div>
            <div class="w-1/2 mx-5 p-10 border border-filter rounded-xl">
                <h1 class="text-2xl text-center font-bold mb-4">登録料理一覧</h1>
                @foreach ($dishes as $dish)
                    <div class="mb-2 p-2 border border-gray-200 rounded-lg">
                        <p class=" text-base">{{ $dish->name }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-app-layout>
