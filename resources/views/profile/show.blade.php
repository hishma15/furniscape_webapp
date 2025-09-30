<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

        <h1 class="heading-style">MY PROFILE</h1>


    <div class="py-2">

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">


                {{-- This will load the toggle + dynamic content --}}
            <div class="p-6 bg-beige shadow sm:rounded-lg mb-6">
                    @livewire('customer.user-activity')
                    {{-- <livewire:customer.user-activity /> --}}
            </div>



            {{-- profile info and passoword update --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    <div class="p-6 bg-beige shadow sm:rounded-lg">

                    @livewire('profile.update-profile-information-form')

                    </div>
                    {{-- <x-section-border /> --}}
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="p-6 bg-beige shadow sm:rounded-lg">
                    @livewire('profile.update-password-form')
                    </div>
                    {{-- <x-section-border /> --}}
                @endif

            </div>

            {{-- 2fa and browser sesssions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="p-6 bg-beige shadow sm:rounded-lg">
                    @livewire('profile.two-factor-authentication-form')
                </div>
                {{-- <x-section-border /> --}}
                @endif

                <div class="mt-10 sm:mt-0 p-6 bg-beige shadow sm:rounded-lg">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
            </div>

            {{-- Delete account --}}
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>

    @vite('resources/js/customer-consultation.js')
</x-app-layout>
