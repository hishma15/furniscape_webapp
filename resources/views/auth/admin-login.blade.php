<x-guest-layout>
    <div class="customer-auth-back" style="background-image: url('{{ asset('images/admin-back.jpg') }}');">
        {{-- <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Login')}}
            </h2>
        </x-slot> --}}
        <div class="cusotmer-auth-section pb-5">

            <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

            <h2 class="auth-heading">ADMIN LOGIN</h2>

            <form method="POST" action="{{ route('admin.login') }} " id="admin-login-form">
            @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                </div>

                <div class="mt-4">
                    <x-button>
                        {{ __('Login') }}
                    </x-button>
                </div>

            </form>
            

        </div>

    </div>

    @vite('resources/js/auth.js')
    
</x-guest-layout>
