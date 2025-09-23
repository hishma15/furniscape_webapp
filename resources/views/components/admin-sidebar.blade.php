<aside id="sidebar" class="h-fit w-60 bg-beige text-beige left-0 flex flex-col shadow-lg z-50 pt-4">
    <!-- <aside id="sidebar" class="fixed top-0 left-0 w-60 h-full bg-beige text-brown transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 shadow-lg pt-20"> -->
        <nav class="px-4 py-6 space-y-4 text-lg font-montserrat">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidemenu">
                <i class="fa-solid fa-gauge"></i> Admin Dashboard
            </a>
            <a href="{{route('admin.products')}}" class="admin-sidemenu">
                <i class="fa-solid fa-box"></i> Manage Products
            </a>
            <a href="#" class="admin-sidemenu">
                <i class="fa-solid fa-cart-shopping"></i> Manage Orders
            </a>
            <a href=" {{route('admin.consultations') }}" class="admin-sidemenu">
                <i class="fa-solid fa-comments"></i> Manage Consultation
            </a>
            <a href="#" class="admin-sidemenu">
                <i class="fa-solid fa-users"></i> Manage Users
            </a>
            <a href="{{route('admin.categories') }}" class="admin-sidemenu">
                <i class="fa-solid fa-folder"></i> Manage Categories
            </a>
        </nav>
    </aside>