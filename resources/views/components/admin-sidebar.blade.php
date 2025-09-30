<aside id="sidebar" class="w-60 bg-beige text-beige shadow-lg h-full">
    <nav class="p-6 space-y-4 text-lg font-montserrat">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidemenu">
            <i class="fa-solid fa-gauge"></i> Admin Dashboard
        </a>
        <a href="{{route('admin.products')}}" class="admin-sidemenu">
            <i class="fa-solid fa-box"></i> Manage Products
        </a>
        <a href="{{route('admin.orders')}}" class="admin-sidemenu">
            <i class="fa-solid fa-cart-shopping"></i> Manage Orders
        </a>
        <a href="{{route('admin.consultations')}}" class="admin-sidemenu">
            <i class="fa-solid fa-comments"></i> Manage Consultation
        </a>
        <a href="{{route('admin.users')}}" class="admin-sidemenu">
            <i class="fa-solid fa-users"></i> Manage Users
        </a>
        <a href="{{route('admin.categories')}}" class="admin-sidemenu">
            <i class="fa-solid fa-folder"></i> Manage Categories
        </a>
    </nav>
</aside>
