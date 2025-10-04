<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anggota DPR - Data Anggota</title>
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
            padding: 2rem;
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
        
        .search-highlight {
            background-color: yellow;
            font-weight: bold;
            padding: 1px 3px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-users fa-3x mb-3"></i>
                <h1 class="display-5 fw-bold mb-0">Anggota DPR</h1>
                <p class="mb-0 opacity-75">Sistem Manajemen Data Anggota Dewan Perwakilan Rakyat</p>
            </div>

            <div class="p-4">
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-0">Data Anggota</h3>
                        <small class="text-muted">
                            <i class="fas fa-user-tag me-1"></i>
                            Logged in as: <strong>{{ session('user_name') }}</strong>
                            <span
                                class="badge bg-{{ $userRole == 'Admin' ? 'success' : 'secondary' }}">{{ $userRole }}</span>
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        @if ($userRole == 'Admin')
                            <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Tambah Anggota
                            </a>
                        @endif

                        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-lg">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('anggota.index') }}" class="d-flex">
                            <div class="input-group">
                                <span class="input-group-text bg-primary text-white">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       value="{{ $search ?? '' }}" 
                                       placeholder="Cari nama, gelar, jabatan, atau status..."
                                       style="border-radius: 0 10px 10px 0;">
                                <button type="submit" class="btn btn-primary ms-2" style="border-radius: 10px;">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                                @if($search)
                                    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary ms-1" style="border-radius: 10px;">
                                        <i class="fas fa-times me-1"></i>Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    @if($search)
                        <div class="col-md-6">
                            <div class="alert alert-info mb-0 py-2">
                                <i class="fas fa-info-circle me-2"></i>
                                Menampilkan hasil pencarian untuk: <strong>"{{ $search }}"</strong>
                                <span class="badge bg-info ms-2">{{ $anggota->total() }} hasil</span>
                            </div>
                        </div>
                    @endif
                </div>

                @if ($anggota->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jabatan</th>
                                    <th>Status Pernikahan</th>
                                    @if ($userRole == 'Admin')
                                        <th class="text-center">Aksi</th>
                                    @else
                                        <th class="text-center">Detail</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggota as $index => $item)
                                    <tr>
                                        <td>{{ $item->id_anggota }}</td>
                                        <td>
                                            <strong>{{ $item->full_name }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ \App\Models\Anggota::getJabatanOptions()[$item->jabatan] ?? $item->jabatan }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ \App\Models\Anggota::getStatusPernikahanOptions()[$item->status_pernikahan] ?? $item->status_pernikahan }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('anggota.show', $item->id_anggota) }}"
                                                    class="btn btn-info btn-sm" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $anggota->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        @if($search)
                            <i class="fas fa-search fa-5x text-muted mb-3"></i>
                            <h4 class="text-muted">Tidak ada hasil pencarian</h4>
                            <p class="text-muted">
                                Tidak ditemukan data anggota yang cocok dengan pencarian <strong>"{{ $search }}"</strong>
                            </p>
                            <a href="{{ route('anggota.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke semua data
                            </a>
                        @else
                            <i class="fas fa-users fa-5x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada data anggota</h4>
                            <p class="text-muted">Klik tombol "Tambah Anggota" untuk menambahkan data pertama</p>
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
