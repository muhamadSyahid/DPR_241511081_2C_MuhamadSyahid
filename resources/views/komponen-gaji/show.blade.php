<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Komponen Gaji - {{ $komponenGaji->nama_komponen }}</title>
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

        .detail-card {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #555;
        }

        .badge-custom {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .nominal-display {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-eye fa-3x mb-3"></i>
                <h1 class="display-5 fw-bold mb-0">Detail Komponen Gaji</h1>
                <p class="mb-0 opacity-75">Informasi lengkap komponen gaji</p>
            </div>

            <div class="p-4">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>

                <!-- Component Name Header -->
                <div class="text-center mb-4">
                    <h2 class="display-6 fw-bold text-primary">{{ $komponenGaji->nama_komponen }}</h2>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <span class="badge bg-info badge-custom">{{ $komponenGaji->kategori }}</span>
                        <span class="badge bg-secondary badge-custom">{{ $komponenGaji->jabatan }}</span>
                        <span class="badge bg-warning text-dark badge-custom">{{ $komponenGaji->satuan }}</span>
                    </div>
                </div>

                <!-- Main Details -->
                <div class="row">
                    <!-- Nominal Display -->
                    <div class="col-md-12 mb-4">
                        <div class="detail-card text-center">
                            <div class="detail-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Nominal
                            </div>
                            <div class="nominal-display">{{ $komponenGaji->formatted_nominal }}</div>
                        </div>
                    </div>

                    <!-- Component Details -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <div class="detail-label">
                                <i class="fas fa-tag me-2"></i>Nama Komponen
                            </div>
                            <div class="detail-value">{{ $komponenGaji->nama_komponen }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <div class="detail-label">
                                <i class="fas fa-layer-group me-2"></i>Kategori
                            </div>
                            <div class="detail-value">
                                <span class="badge bg-info badge-custom">{{ $komponenGaji->kategori }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <div class="detail-label">
                                <i class="fas fa-user-tie me-2"></i>Jabatan
                            </div>
                            <div class="detail-value">
                                <span class="badge bg-secondary badge-custom">{{ $komponenGaji->jabatan }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <div class="detail-label">
                                <i class="fas fa-calculator me-2"></i>Satuan
                            </div>
                            <div class="detail-value">
                                <span class="badge bg-warning text-dark badge-custom">{{ $komponenGaji->satuan }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($komponenGaji->deskripsi)
                        <div class="col-md-12 mb-3">
                            <div class="detail-card">
                                <div class="detail-label">
                                    <i class="fas fa-align-left me-2"></i>Deskripsi
                                </div>
                                <div class="detail-value">{{ $komponenGaji->deskripsi }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- System Info -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <div class="detail-label">
                                <i class="fas fa-key me-2"></i>ID Komponen
                            </div>
                            <div class="detail-value">
                                <code>{{ $komponenGaji->id_komponen_gaji }}</code>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-card">
                            <div class="detail-label">
                                <i class="fas fa-calculator me-2"></i>Nominal (Raw)
                            </div>
                            <div class="detail-value">
                                <code>{{ number_format($komponenGaji->nominal, 2) }}</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-list me-2"></i>Daftar Komponen
                    </a>

                    @if (session('user_role') == 'Admin')
                        <a href="{{ route('komponen-gaji.edit', $komponenGaji->id_komponen_gaji) }}" class="btn btn-warning btn-lg">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>

                        <form action="{{ route('komponen-gaji.destroy', $komponenGaji->id_komponen_gaji) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus komponen gaji \'{{ $komponenGaji->nama_komponen }}\'?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-lg">
                                <i class="fas fa-trash me-2"></i>Hapus Data
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Component Information -->
                <div class="mt-5">
                    <div class="card" style="background: rgba(102, 126, 234, 0.1); border: 1px solid rgba(102, 126, 234, 0.3);">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi Komponen
                            </h6>
                            
                            @if($komponenGaji->kategori == 'Gaji Pokok')
                                <p class="card-text">
                                    <strong>Gaji Pokok</strong> adalah komponen dasar dalam struktur gaji yang diberikan kepada setiap anggota DPR sesuai dengan jabatan yang dimiliki.
                                </p>
                            @elseif($komponenGaji->kategori == 'Tunjangan')
                                <p class="card-text">
                                    <strong>Tunjangan</strong> adalah tambahan penghasilan yang diberikan di luar gaji pokok, dapat berupa tunjangan jabatan, transportasi, atau tunjangan lainnya.
                                </p>
                            @elseif($komponenGaji->kategori == 'Insentif')
                                <p class="card-text">
                                    <strong>Insentif</strong> adalah komponen penghasilan tambahan yang diberikan berdasarkan kinerja atau pencapaian tertentu.
                                </p>
                            @elseif($komponenGaji->kategori == 'Bonus')
                                <p class="card-text">
                                    <strong>Bonus</strong> adalah komponen penghasilan tambahan yang diberikan pada periode tertentu atau berdasarkan kebijakan khusus.
                                </p>
                            @elseif($komponenGaji->kategori == 'Potongan')
                                <p class="card-text">
                                    <strong>Potongan</strong> adalah pengurangan dari total penghasilan, seperti potongan pajak, iuran, atau potongan lainnya.
                                </p>
                            @endif

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <small class="text-muted">Berlaku untuk:</small><br>
                                    <span class="badge bg-secondary">{{ $komponenGaji->jabatan }}</span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Jenis perhitungan:</small><br>
                                    <span class="badge bg-warning text-dark">{{ $komponenGaji->satuan }}</span>
                                </div>
                                <div class="col-md-4">
                                    <small class="text-muted">Kategori:</small><br>
                                    <span class="badge bg-info">{{ $komponenGaji->kategori }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>