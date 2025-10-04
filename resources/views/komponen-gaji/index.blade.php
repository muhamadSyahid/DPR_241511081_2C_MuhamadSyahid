<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Komponen Gaji - Data Komponen Gaji</title>
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

        /* Compact pagination styling */
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

        /* Make previous/next arrows smaller */
        .pagination .page-link i {
            font-size: 0.7rem;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-money-bill-wave fa-2x mb-2"></i>
                <h1 class="h2 fw-bold mb-0">Komponen Gaji</h1>
                <p class="mb-0 opacity-75 small">Sistem Manajemen Data Komponen Gaji DPR</p>
            </div>

            <div class="p-3">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Error Message -->
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-1">Data Komponen Gaji</h4>
                        <small class="text-muted">
                            <i class="fas fa-user-tag me-1"></i>
                            Logged in as: <strong>{{ session('user_name') }}</strong>
                            <span class="badge bg-{{ $userRole == 'Admin' ? 'success' : 'secondary' }} badge-sm">{{ $userRole }}</span>
                        </small>
                    </div>

                    <div class="d-flex gap-1">
                        @if ($userRole == 'Admin')
                            <a href="{{ route('komponen-gaji.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </a>
                        @endif
                        
                        <a href="{{ route('anggota.index') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-users me-1"></i>Anggota
                        </a>

                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <form method="GET" action="{{ route('komponen-gaji.index') }}" class="d-flex">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control form-control-sm" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       placeholder="Cari nama komponen, kategori, jabatan..."
                                       style="border-radius: 0 5px 5px 0;">
                                <button type="submit" class="btn btn-primary btn-sm ms-1" style="border-radius: 5px;">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                                @if($search)
                                    <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary btn-sm ms-1" style="border-radius: 5px;">
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
                                    <span class="badge bg-info badge-sm ms-1">{{ $komponenGaji->total() }}</span>
                                </small>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Table -->
                @if ($komponenGaji->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th style="width: 25%">Nama Komponen</th>
                                    <th style="width: 15%">Kategori</th>
                                    <th style="width: 15%">Jabatan</th>
                                    <th style="width: 15%">Nominal</th>
                                    <th style="width: 10%">Satuan</th>
                                    @if ($userRole == 'Admin')
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    @else
                                        <th class="text-center" style="width: 15%">Detail</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($komponenGaji as $index => $item)
                                    <tr>
                                        <td>{{ $item->id_komponen_gaji }}</td>
                                        <td>{{ $item->nama_komponen }}</td>
                                        <td>
                                            <span class="badge bg-info badge-sm">{{ $item->kategori }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary badge-sm">{{ $item->jabatan }}</span>
                                        </td>
                                        <td>
                                            <small class="text-success fw-bold">{{ $item->formatted_nominal }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark badge-sm">{{ $item->satuan }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('komponen-gaji.show', $item->id_komponen_gaji) }}"
                                                    class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if ($userRole == 'Admin')
                                                    <a href="{{ route('komponen-gaji.edit', $item->id_komponen_gaji) }}"
                                                        class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('komponen-gaji.destroy', $item->id_komponen_gaji) }}"
                                                        method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Page navigation">
                            {{ $komponenGaji->links('pagination::bootstrap-4', ['class' => 'pagination-sm']) }}
                        </nav>
                    </div>
                @else
                    <div class="text-center py-3">
                        @if($search)
                            <i class="fas fa-search fa-3x text-muted mb-2"></i>
                            <h5 class="text-muted">Tidak ada hasil pencarian</h5>
                            <p class="text-muted small">
                                Tidak ditemukan komponen gaji untuk: <strong>"{{ $search }}"</strong>
                            </p>
                            <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        @else
                            <i class="fas fa-money-bill-wave fa-3x text-muted mb-2"></i>
                            <h5 class="text-muted">Belum ada data</h5>
                            <p class="text-muted small">Klik "Tambah" untuk menambahkan data pertama</p>
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