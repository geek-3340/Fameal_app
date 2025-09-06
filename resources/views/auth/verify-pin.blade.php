<x-guest-layout>

    <h1 class=" text-center font-bold mb-4">メールアドレス認証</h1>

    <form method="POST" action="{{ route('verify.pin.store') }}">
        @csrf

        <div class="text-center mt-4">
            <x-input-label for="two_factor_code" value="認証コード" class=" text-start" />
            <p class="text-sm text-start my-2 text-graytext"><span
                    class="text-link">{{ Auth::user()->email }}</span>に送信された６桁の認証コードを入力して下さい。</p>
            <x-text-input id="two_factor_code" type="text" name="two_factor_code" class="w-full" placeholder="認証コードを入力" required autofocus />
            @error('two_factor_code')
                <div>
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                </div>
            @enderror
        </div>

        <div class="text-center mt-4">
            <button
                class="flex items-center justify-center mt-6 w-full h-10 text-sm text-text bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
                認証する
            </button>
        </div>
    </form>
    <form method="POST" action="{{ route('verify.pin.regenerate') }}" class=" text-center">
        @csrf
        <button type="submit" class="text-blue-600 text-sm underline bg-transparent border-none mt-5">
            コードを再送信
        </button>

    </form>
</x-guest-layout>
