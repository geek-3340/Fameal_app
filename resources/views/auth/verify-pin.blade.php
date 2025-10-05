<x-app-layout>
    <x-contents-board>
        <h1 class=" text-center text-xl font-bold">メールアドレス認証</h1>

        <form method="POST" action="{{ route('verify.pin.store') }}">
            @csrf

            <div class="text-center mt-4">
                <p class="text-sm text-start text-graytext">
                    <span class="text-link">{{ Auth::user()->email }}</span>
                    に送信された６桁の認証コードを入力して下さい。
                </p>
                <x-text-input id="two_factor_code" type="text" name="two_factor_code" class="block mt-1 w-full"
                    placeholder="認証コードを入力" required autofocus />
                @error('two_factor_code')
                    <div>
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <x-button width="full" type="primary" class="mt-4">
                認証する
            </x-button>

        </form>
        <form method="POST" action="{{ route('verify.pin.regenerate') }}" class=" text-center">
            @csrf
            
            <button type="submit" class="text-blue-600 text-sm underline bg-transparent border-none mt-4">
                コードを再送信
            </button>

        </form>
    </x-contents-board>
</x-app-layout>
