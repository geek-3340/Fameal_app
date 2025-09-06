<x-guest-layout>

    <h1 class=" text-center font-bold mb-4">{{ __('Register') }}</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <p class=" text-sm">半角英数字のみ８文字以上</p>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <a class="underline text-sm text-link flex justify-center mt-6" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <button
            class="flex items-center justify-center mt-6 w-full h-10 text-sm text-text bg-main rounded-full shadow-custom hover:shadow-none transition-shadow">
            {{ __('Register') }}
        </button>

    </form>
</x-guest-layout>
