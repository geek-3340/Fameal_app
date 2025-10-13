<x-app-layout>
    <x-contents-board>
        <h1 class="text-xl font-bold text-center mb-4">ログイン</h1>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" class="flex gap-1">
                    <x-icons.email-svg />
                    {{ __('Email') }}
                </x-input-label>
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" class="flex gap-1">
                    <x-icons.password-svg />
                    {{ __('Password') }}
                </x-input-label>
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-link hover:text-indigo-900 focus:ring-indigo-500"
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

            <x-button width="full" class="mt-4">
                ログイン
            </x-button>
        </form>
        <p class="text-sm text-graytext text-center my-4">アカウント登録がまだの方</p>
        <x-link-button href="{{ route('register') }}" type="register" width="full">
            新規登録
        </x-link-button>
    </x-contents-board>
</x-app-layout>
