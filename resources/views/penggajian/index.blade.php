<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Penggajian - Data Penggajian Anggota DPR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
        }

        .input-group-text {
            border: 2px solid #667eea;
            border-right: none;
        }
        
        .form-control {
            border: 2px solid #667eea;
            border-left: none;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .badge-sm {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }

        .table-sm td, .table-sm th {
            padding: 0.5rem 0.25rem;
            font-size: 0.9rem;
        }

        .btn-group-sm > .btn, .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-link {
            padding: 0.375rem 0.5rem;
            font-size: 0.8rem;
            line-height: 1.2;
        }

        .pagination .page-item.disabled .page-link,
        .pagination .page-item .page-link {
            border-radius: 0.25rem;
            margin: 0 1px;
        }

        .pagination .page-link i {
            font-size: 0.7rem;
        }

        .take-home-pay {
            font-weight: bold;
            color: #28a745;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section">
                <div class="text-center mb-3">
                    <i class="fas fa-calculator fa-2x mb-2"></i>
                    <h1 class="h2 fw-bold mb-0">Penggajian Anggota DPR</h1>
                    <p class="mb-0 opacity-75 small">Sistem Manajemen Gaji dan Tunjangan</p>
                </div>
                
                <div class="row text-center">
                    <div class="col-md-{{ $userRole === 'Admin' ? '4' : '6' }}">
                        <a href="{{ route('anggota.index') }}" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-users me-2"></i>Data Anggota
                        </a>
                    </div>
                    @if ($userRole === 'Admin')
                        <div class="col-md-4">
                            <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-light btn-sm w-100">
                                <i class="fas fa-money-bill-wave me-2"></i>Komponen Gaji
                            </a>
                        </div>
                    @endif
                    <div class="col-md-{{ $userRole === 'Admin' ? '4' : '6' }}">
                        <a href="{{ route('penggajian.index') }}" class="btn btn-light btn-sm w-100 active">
                            <i class="fas fa-calculator me-2"></i>Penggajian
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-3">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-1">Data Penggajian</h4>
                        <small class="text-muted">
                            <i class="fas fa-user-tag me-1"></i>
                            Logged in as: <strong>{{ session('user_name') }}</strong>
                            <span class="badge bg-success badge-sm">{{ $userRole }}</span>
                        </small>
                    </div>

                    <div class="d-flex gap-1">
                        @if ($userRole === 'Admin')
                            <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </a>
                        @endif
                        
                        <a href="{{ route('anggota.index') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-users me-1"></i>Anggota
                        </a>

                        @if ($userRole === 'Admin')
                            <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-success btn-sm">
                                <i class="fas fa-money-bill-wave me-1"></i>Komponen
                            </a>
                        @endif

                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('penggajian.index') }}" class="d-flex">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control form-control-sm" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       placeholder="Cari nama, jabatan, ID anggota, atau take home pay..."
                                       style="border-radius: 0 5px 5px 0;">
                                <button type="submit" class="btn btn-primary btn-sm ms-1" style="border-radius: 5px;">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                                @if($search)
                                    <a href="{{ route('penggajian.index') }}" class="btn btn-outline-secondary btn-sm ms-1" style="border-radius: 5px;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    @if($search)
                        <div class="col-md-4">
                            <div class="alert alert-info alert-sm mb-0 py-1">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pencarian: <strong>"{{ $search }}"</strong>
                                    <span class="badge bg-info badge-sm ms-1">{{ $penggajian->total() }}</span>
                                </small>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($penggajian->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: {{ $userRole === 'Admin' ? '12%' : '15%' }}">ID Anggota</th>
                                    <th style="width: {{ $userRole === 'Admin' ? '35%' : '45%' }}">Nama Lengkap</th>
                                    <th style="width: {{ $userRole === 'Admin' ? '15%' : '18%' }}">Jabatan</th>
                                    <th style="width: {{ $userRole === 'Admin' ? '20%' : '22%' }}">Take Home Pay</th>
                                    @if ($userRole === 'Admin')
                                        <th class="text-center" style="width: 18%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($penggajian as $item)
                                    <tr>
                                        <td>{{ $item->id_anggota }}</td>
                                        <td>{{ $item->full_name }}</td>
                                        <td>
                                            <span class="badge bg-info badge-sm">{{ $item->jabatan }}</span>
                                        </td>
                                        <td>
                                            <span class="take-home-pay">{{ $item->formatted_take_home_pay }}</span>
                                        </td>
                                        @if ($userRole === 'Admin')
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('penggajian.show', $item->id_anggota) }}"
                                                        class="btn btn-info btn-sm" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" 
                                                                data-bs-toggle="dropdown" title="Aksi">
                                                            <i class="fas fa-cog"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('penggajian.create', ['anggota_id' => $item->id_anggota]) }}">
                                                                    <i class="fas fa-plus me-2"></i>Tambah Komponen
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('penggajian.destroy-all', $item->id_anggota) }}" 
                                                                      method="POST" style="display: inline;"
                                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA komponen gaji untuk anggota ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash me-2"></i>Hapus Semua
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Page navigation">
                            {{ $penggajian->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
                        </nav>
                    </div>
                @else
                    <div class="text-center py-3">
                        @if($search)
                            <i class="fas fa-search fa-3x text-muted mb-2"></i>
                            <h5 class="text-muted">Tidak ada hasil pencarian</h5>
                            <p class="text-muted small">
                                Tidak ditemukan data penggajian untuk: <strong>"{{ $search }}"</strong>
                            </p>
                            <a href="{{ route('penggajian.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        @else
                            <i class="fas fa-calculator fa-3x text-muted mb-2"></i>
                            <h5 class="text-muted">Belum ada data penggajian</h5>
                            @if ($userRole === 'Admin')
                                <p class="text-muted small">Klik "Tambah" untuk menambahkan data penggajian pertama</p>
                                <a href="{{ route('penggajian.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Tambah Data Penggajian
                                </a>
                            @else
                                <p class="text-muted small">Data penggajian belum tersedia</p>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>