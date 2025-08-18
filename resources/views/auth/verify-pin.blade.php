<x-guest-layout>
    <form method="POST" action="{{ route('verify.pin.store') }}">
        @csrf

        <div class="text-center mt-4">
            <x-input-label for="two_factor_code" value="認証コード" />
            <x-text-input id="two_factor_code" type="text" name="two_factor_code" required autofocus />
            @error('two_factor_code')
            <div>
                <span class="text-red-600 text-sm">{{ $message }}</span>
            </div>
            @enderror
        </div>

        <div class="text-center mt-4">
            <x-primary-button>認証する</x-primary-button>
        </div>
    </form>
</x-guest-layout>
