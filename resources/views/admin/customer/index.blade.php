<!-- resources/views/admin/customer/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Data Customer')
@section('page-title', 'Data Customer')
@section('page-subtitle', 'Daftar customer yang terdaftar')

@section('content')
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Total Customer</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_customers'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Customer Aktif</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['active_customers'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-user-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-0">Baru Bulan Ini</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['new_this_month'] }}</h3>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-user-plus fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form method="GET" class="d-flex gap-2">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari nama, email, atau telepon..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-warning" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
                @if(request('search'))
                    <a href="{{ route('admin.customer.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
        
        <div class="col-md-4 text-end">
            <div class="text-muted">
                <small>Customer register otomatis melalui website</small>
            </div>
        </div>
    </div>
    
    @if($customers->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-warning">
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="25%">Nama Customer</th>
                                <th width="20%">Kontak</th>
                                <th width="25%">Alamat</th>
                                <th width="10%" class="text-center">Total Booking</th>
                                <th width="10%" class="text-center">Bergabung</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td class="text-center">{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}</td>
                                
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle p-2 me-3">
                                            <i class="fas fa-user text-dark"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $customer->nama_lengkap }}</h6>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <div>
                                        <i class="fas fa-phone text-muted me-2"></i>{{ $customer->no_telepon }}
                                    </div>
                                    <div class="mt-1">
                                        <a href="{{ route('admin.customer.whatsapp', $customer) }}" 
                                           target="_blank" class="btn btn-success btn-sm">
                                            <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                        </a>
                                    </div>
                                </td>
                                
                                <td>
                                    <p class="mb-0 text-muted small">{{ Str::limit($customer->alamat, 60) }}</p>
                                </td>
                                
                                <td class="text-center">
                                    @if($customer->pemesanan_count > 0)
                                        <span class="badge bg-info fs-6">{{ $customer->pemesanan_count }} booking</span>
                                    @else
                                        <span class="badge bg-secondary">Belum ada</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <div class="small">{{ $customer->created_at->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ $customer->created_at->diffForHumans() }}</small>
                                </td>
                                
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.customer.show', $customer) }}" 
                                           class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('admin.customer.whatsapp', $customer) }}" 
                                           target="_blank" class="btn btn-outline-success" title="WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $customers->withQueryString()->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">
                        @if(request('search'))
                            Tidak ada customer yang ditemukan
                        @else
                            Belum ada customer terdaftar
                        @endif
                    </h5>
                    <p class="text-muted">
                        @if(request('search'))
                            Coba kata kunci lain untuk pencarian
                        @else
                            Customer akan muncul setelah mereka register di website
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background-color: #ffc107 !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(255, 193, 7, 0.1);
}

.badge {
    font-size: 0.8rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush