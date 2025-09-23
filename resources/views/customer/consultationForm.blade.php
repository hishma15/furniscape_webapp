<x-app-layout>
    <div class="customer-auth-back" style="background-image: url('{{ asset('images/loginback.png') }}');">
        <div class="cusotmer-auth-section">
            <h2 class="auth-heading">LETS DESIGN YOUR DREAM SPACE</h2>

            <form id="consultation-form" novalidate>
                @csrf

                <div class="mt-4">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" required readonly value="{{ Auth::user()->name }}" />
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" required readonly value="{{ Auth::user()->email }}" />
                </div>

                <div class="mt-4">
                    <x-label for="phone_no" value="{{ __('Phone Number') }}" />
                    <x-input id="phone_no" class="block mt-1 w-full" type="tel" name="phone_no" required readonly value="{{ Auth::user()->phone_no }}" />
                </div>

                <div class="mt-4">
                    <x-label for="prefered_date" value="{{ __('Prefered Date') }}" />
                    <x-input id="prefered_date" class="block mt-1 w-full" type="date" name="prefered_date" required />
                </div>

                <div class="mt-4">
                    <x-label for="prefered_time" value="{{ __('Prefered Time') }}" />
                    <x-input id="prefered_time" class="block mt-1 w-full" type="time" name="prefered_time" required />
                </div>

                <div class="mt-4">
                    <x-label for="mode" value="{{ __('Consultation Mode') }}" />
                    <select id="mode" name="mode" required class="block mt-1 w-full h-1/2 rounded-full border border-gray-300 focus:border-brown focus:ring focus:ring-brown/50">
                        <option value="">--Select Mode</option>
                        <option value="in_store">In Store</option>
                        <option value="phone_call">Phone Call</option>
                        <option value="video_call">Video Call</option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-label for="topic" value="{{ __('Topic') }}" />
                    <x-input id="topic" class="block mt-1 w-full" type="text" name="topic" required />
                </div>

                <div class="mt-4 mb-6">
                    <x-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" name="description" required class="block mt-1 w-full h-1/2 rounded-full border border-gray-300 focus:border-brown focus:ring focus:ring-brown/50"></textarea>
                </div>

                <div id="form-messages" class="mb-4 text-red-600"></div>

                <x-button>
                    {{ __('Book Consultation') }}
                </x-button>

            </form>   
        </div>
    </div>
</x-app-layout>