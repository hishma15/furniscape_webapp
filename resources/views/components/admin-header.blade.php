<header class="bg-beige text-black flex flex-row justify-between items-center p-2">
    <div class="container mx-auto flex flex-row gap-4 items-center relative">

        <!-- Logo -->
        <div class="flex items-center">
            <a href="#">
                <img src="{{ asset('images/logoPNG.png') }}" alt="FurniScape Logo" style="height: 120px;" class="w-auto">
            </a>
        </div>

        <div class="font-lustria text-2xl pl-5">
            <h1>FURNISCAPE ADMIN!</h1>
        </div>

        
        
    </div>
    <form method="POST" action="{{ route('admin.logout') }}" class="p-4">
        @csrf
        <button class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition">
            Logout
        </button>
    </form>
</header>