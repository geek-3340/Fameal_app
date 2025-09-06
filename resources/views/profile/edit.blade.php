<x-guest-layout>

    <h1 class="text-center font-bold mb-4 text-2xl">
        {{ __('Profile Menu') }}
    </h1>

    <div>
        <div class=" w-11/12 h-max mx-auto my-5 p-5 border border-filter rounded-md">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        <div class=" w-11/12 h-max mx-auto my-5 p-5 border border-filter rounded-md">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
        <div class=" w-11/12 h-max mx-auto my-5 p-5 border border-filter rounded-md">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-guest-layout>
