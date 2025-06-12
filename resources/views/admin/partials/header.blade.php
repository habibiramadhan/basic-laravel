<!-- resources/views/admin/partials/header.blade.php -->
<header class="header bg-white shadow-sm border-bottom">
    <div class="container-fluid">
        <div class="row align-items-center py-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <button class="btn btn-link d-md-none me-3 p-0" id="sidebarToggle">
                        <i class="fas fa-bars text-warning fs-4"></i>
                    </button>
                    
                    <div>
                        <h4 class="mb-0 text-dark fw-bold">@yield('page-title', 'Dashboard')</h4>
                        <small class="text-muted">@yield('page-subtitle', 'Selamat datang di panel admin')</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-end">
                    <div class="me-4">
                        <span class="text-muted">{{ now()->format('l, d F Y') }}</span>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle p-0 d-flex align-items-center" 
                                type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <div class="bg-warning rounded-circle p-2 me-2">
                                <i class="fas fa-user text-dark"></i>
                            </div>
                            <span class="text-dark">{{ auth()->user()->nama_lengkap }}</span>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-circle me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2"></i>Pengaturan
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
        
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }
});
</script>