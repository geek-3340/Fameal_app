<x-app-layout>
    <x-contents-board>
        <h1 class=" text-center font-bold mb-4">ログイン</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <p class=" text-sm">半角英数字のみ８文字以上</p>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-link hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    パスワードを忘れた方
                </a>
            @endif

            <!-- Remember Me -->
            <div class="block mt-4 text-center">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm">次回から自動ログイン</span>
                </label>
            </div>

            <x-button width="full" class="my-4">
                ログイン
            </x-button>
        </form>
        <p class="text-sm text-graytext text-center">アカウント登録がまだの方</p>
        <x-link-button href="{{ route('register') }}" type="register" width="full" class="mt-4">
            新規登録
        </x-link-button>
    </x-contents-board>
</x-app-layout>
