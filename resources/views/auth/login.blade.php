<x-guest-layout>
    <div class="customer-auth-back" style="background-image: url('{{ asset('images/loginback.png') }}');">
        {{-- <x-authentication-card> --}}
            {{-- <x-slot name="logo"> --}}
                {{-- <x-authentication-card-logo /> --}}
            {{-- </x-slot> --}}

            <div class="cusotmer-auth-section pb-5">

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <div class="text-center">
                    <span class="auth-question">DON'T HAVE AN ACCOUNT?
                        <a href="{{ route('register') }}" onClick="changeForm()" class="hover:underline"> Register </a>
                    </span>
                </div>
                <h2 class="auth-heading">LOGIN</h2>

                <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf

                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    </div>

                    <div class="mt-4">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        

                        <x-button class="ms-4">
                            {{ __('Log in') }}
                        </x-button>
                    </div>
                </form>
            </div>
            

            
        {{-- </x-authentication-card> --}}
    </div>
</x-guest-layout>
