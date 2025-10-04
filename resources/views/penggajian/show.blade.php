<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Penggajian - {{ $anggota->full_name }}</title>
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

        .detail-card {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .take-home-display {
            font-size: 2.5rem;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            padding: 2rem;
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-radius: 15px;
            border: 2px solid #28a745;
        }

        .component-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .component-item {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }

        .conditional-allowance {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-eye fa-2x mb-2"></i>
                <h1 class="h2 fw-bold mb-0">Detail Penggajian</h1>
                <p class="mb-0 opacity-75 small">{{ $anggota->full_name }}</p>
            </div>

            <div class="p-3">
                <div class="mb-3">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>

                <div class="take-home-display mb-4">
                    <div class="small text-secondary mb-1">TAKE HOME PAY</div>
                    {{ $formattedTakeHomePay }}
                    <div class="small text-secondary mt-1">per bulan</div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-user-circle me-2"></i>Informasi Anggota
                            </h5>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <td width="35%"><strong>ID Anggota:</strong></td>
                                    <td>{{ $anggota->id_anggota }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Lengkap:</strong></td>
                                    <td>{{ $anggota->full_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jabatan:</strong></td>
                                    <td><span class="badge bg-info badge-lg">{{ $anggota->jabatan }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Status Pernikahan:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $anggota->status_pernikahan == 'Kawin' ? 'success' : 'secondary' }} badge-lg">
                                            {{ $anggota->status_pernikahan }}
                                        </span>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-chart-pie me-2"></i>Ringkasan Komponen
                            </h5>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border rounded p-2 mb-2">
                                        <div class="h4 mb-0 text-primary">{{ $salaryComponents->count() }}</div>
                                        <small class="text-muted">Komponen</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded p-2 mb-2">
                                        <div class="h4 mb-0 text-success">{{ $componentsByCategory->count() }}</div>
                                        <small class="text-muted">Kategori</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded p-2 mb-2">
                                        <div class="h4 mb-0 text-warning">
                                            {{ isset($conditionalAllowances['spouse']) ? 'Ya' : 'Tidak' }}
                                        </div>
                                        <small class="text-muted">Tunjangan Khusus</small>
                                    </div>
                                </div>
                            </div>

                            @foreach ($componentsByCategory as $category => $components)
                                <div class="d-flex justify-content-between align-items-center py-1 border-top">
                                    <span class="badge bg-info">{{ $category }}</span>
                                    <span>{{ $components->count() }} komponen</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="detail-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-money-bill-wave me-2"></i>Komponen Gaji
                        </h5>
                        <a href="{{ route('penggajian.create', ['anggota_id' => $anggota->id_anggota]) }}" 
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>Tambah Komponen
                        </a>
                    </div>

                    @if ($salaryComponents->count() > 0)
                        <div class="component-list">
                            @foreach ($componentsByCategory as $category => $components)
                                <h6 class="fw-bold mt-3 mb-2">
                                    <span class="badge bg-info me-2">{{ $category }}</span>
                                    ({{ $components->count() }} komponen)
                                </h6>
                                
                                @foreach ($components as $component)
                                    <div class="component-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $component->komponenGaji->nama_komponen }}</h6>
                                                <div class="d-flex gap-2 mb-2">
                                                    <span class="badge bg-secondary badge-sm">{{ $component->komponenGaji->jabatan }}</span>
                                                    <span class="badge bg-warning text-dark badge-sm">{{ $component->komponenGaji->satuan }}</span>
                                                </div>
                                                @if ($component->komponenGaji->deskripsi)
                                                    <small class="text-muted">{{ $component->komponenGaji->deskripsi }}</small>
                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <div class="h5 mb-1 text-success">{{ $component->komponenGaji->formatted_nominal }}</div>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('penggajian.edit', [$anggota->id_anggota, $component->komponenGaji->id_komponen_gaji]) }}" 
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('penggajian.destroy', [$anggota->id_anggota, $component->komponenGaji->id_komponen_gaji]) }}" 
                                                          method="POST" style="display: inline;"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus komponen ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada komponen gaji</h6>
                            <p class="text-muted small">Klik "Tambah Komponen" untuk menambahkan komponen gaji</p>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2 justify-content-center mt-3">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-list me-1"></i>Daftar Penggajian
                    </a>
                    
                    <a href="{{ route('penggajian.create', ['anggota_id' => $anggota->id_anggota]) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Tambah Komponen
                    </a>

                    @if ($salaryComponents->count() > 0)
                        <form action="{{ route('penggajian.destroy-all', $anggota->id_anggota) }}" 
                              method="POST" style="display: inline;"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA komponen gaji untuk anggota ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-1"></i>Hapus Semua
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>