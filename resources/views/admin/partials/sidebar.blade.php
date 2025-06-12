<!-- resources/views/admin/partials/sidebar.blade.php -->
<div class="sidebar position-fixed top-0 start-0 h-100" style="width: var(--sidebar-width); z-index: 1000;">
    <div class="d-flex flex-column h-100 text-white" style="background: linear-gradient(180deg, var(--dark-bg) 0%, #34495E 100%);">
        
        <div class="sidebar-header p-4 border-bottom border-secondary">
            <div class="d-flex align-items-center">
                <div class="bg-warning rounded-circle p-2 me-3">
                    <i class="fas fa-hard-hat text-dark"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">Admin Panel</h5>
                    <small class="text-warning">{{ setting('site_name', 'Sewa Alat Berat') }}</small>
                </div>
            </div>
        </div>
        
        <nav class="sidebar-nav flex-grow-1 py-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.equipment.index') }}" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center {{ request()->routeIs('admin.equipment.*') ? 'active' : '' }}">
                        <i class="fas fa-truck me-3"></i>
                        <span>Kelola Alat</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.kategori.index') }}" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-tags me-3"></i>
                        <span>Kategori Alat</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="#" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center">
                        <i class="fas fa-calendar-check me-3"></i>
                        <span>Booking</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="#" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center">
                        <i class="fas fa-credit-card me-3"></i>
                        <span>Pembayaran</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="#" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center">
                        <i class="fas fa-users me-3"></i>
                        <span>Customer</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="#" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center">
                        <i class="fas fa-chart-bar me-3"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="#" 
                       class="nav-link text-white px-4 py-3 d-flex align-items-center">
                        <i class="fas fa-cog me-3"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="sidebar-footer p-4 border-top border-secondary">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-warning rounded-circle p-2 me-3">
                    <i class="fas fa-user text-dark"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-bold">{{ auth()->user()->nama_lengkap }}</div>
                    <small class="text-warning">Administrator</small>
                </div>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-warning btn-sm w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.sidebar .nav-link {
    transition: all 0.3s ease;
    border-radius: 0;
}

.sidebar .nav-link:hover {
    background-color: rgba(255, 193, 7, 0.1);
    border-left: 4px solid var(--primary-yellow);
    padding-left: calc(1.5rem - 4px);
}

.sidebar .nav-link.active {
    background-color: rgba(255, 193, 7, 0.2);
    border-left: 4px solid var(--primary-yellow);
    padding-left: calc(1.5rem - 4px);
}

.sidebar .nav-link i {
    width: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
}
</style>