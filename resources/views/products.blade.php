<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session()->has('success'))
    <div class="text-green-700 bg-green-100 border border-green-300 p-3 rounded mt-4">
        {{ session('success') }}
    </div>
    @endif

    <div id="livewire-success-message" class="hidden text-green-700 bg-green-100 border border-green-300 p-3 rounded mt-4"></div>


    @livewire('customer.product-details-modal')

    @livewire('customer.product-search', ['initialSearchTerm' => request('search'), 'category_id' => request('category_id')])

    <script>
window.addEventListener('notify-success', event => {
    const message = event.detail?.message || 'No message found';
    console.log('Message:', message);

    const livewireMessageBox = document.getElementById('livewire-success-message');
    if (livewireMessageBox) {
        livewireMessageBox.textContent = message;
        livewireMessageBox.classList.remove('hidden');

        setTimeout(() => {
            livewireMessageBox.classList.add('hidden');
            livewireMessageBox.textContent = '';
        }, 3000);
    }
});


</script>


</x-app-layout>

