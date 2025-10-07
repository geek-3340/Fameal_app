<x-app-layout>
    <div class="w-max mt-8 mx-auto">
        <h1 class="text-center font-bold text-xl">
            {{ __('Profile Menu') }}
        </h1>
        <div class="flex">
            <x-contents-board>
                @include('profile.partials.update-profile-information-form')
            </x-contents-board>
            <x-contents-board class="!mx-4">
                @include('profile.partials.update-password-form')
            </x-contents-board>
            <x-contents-board>
                @include('profile.partials.delete-user-form')
            </x-contents-board>
        </div>
    </div>
</x-app-layout>
