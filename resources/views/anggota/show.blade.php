<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anggota DPR - Detail Anggota</title>
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
            max-width: 800px;
            margin: 0 auto;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
        }

        .detail-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            border-bottom: 1px solid #dee2e6;
            padding: 0.75rem 0;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
        }

        .btn-warning,
        .btn-secondary {
            border-radius: 50px;
            padding: 12px 30px;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-user-circle fa-4x mb-3"></i>
                <h1 class="display-6 fw-bold mb-0">Detail Anggota DPR</h1>
                <p class="mb-0 opacity-75">Informasi lengkap anggota dewan</p>
            </div>

            <div class="p-4">
                <div class="detail-card">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-primary">{{ $anggota->full_name }}</h2>
                        <span class="badge bg-info fs-6">ID: {{ $anggota->id_anggota }}</span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><i class="fas fa-user me-2 text-primary"></i>Nama Depan:</strong>
                                    </div>
                                    <div class="col-8">
                                        {{ $anggota->nama_depan }}
                                    </div>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><i class="fas fa-user me-2 text-primary"></i>Nama Belakang:</strong>
                                    </div>
                                    <div class="col-8">
                                        {{ $anggota->nama_belakang }}
                                    </div>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><i class="fas fa-graduation-cap me-2 text-primary"></i>Gelar
                                            Depan:</strong>
                                    </div>
                                    <div class="col-8">
                                        {{ $anggota->gelar_depan ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-item">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><i class="fas fa-graduation-cap me-2 text-primary"></i>Gelar
                                            Belakang:</strong>
                                    </div>
                                    <div class="col-8">
                                        {{ $anggota->gelar_belakang ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><i class="fas fa-briefcase me-2 text-primary"></i>Jabatan:</strong>
                                    </div>
                                    <div class="col-8">
                                        <span class="badge bg-info">
                                            {{ \App\Models\Anggota::getJabatanOptions()[$anggota->jabatan] ?? $anggota->jabatan }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-item">
                                <div class="row">
                                    <div class="col-4">
                                        <strong><i class="fas fa-heart me-2 text-primary"></i>Status
                                            Pernikahan:</strong>
                                    </div>
                                    <div class="col-8">
                                        <span class="badge bg-secondary">
                                            {{ \App\Models\Anggota::getStatusPernikahanOptions()[$anggota->status_pernikahan] ?? $anggota->status_pernikahan }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($anggota->created_at)
                        <div class="detail-item mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong><i class="fas fa-calendar-plus me-2 text-success"></i>Dibuat pada:</strong>
                                    {{ $anggota->created_at->format('d M Y, H:i') }}
                                </div>
                                @if ($anggota->updated_at && $anggota->updated_at != $anggota->created_at)
                                    <div class="col-md-6">
                                        <strong><i class="fas fa-calendar-edit me-2 text-warning"></i>Diperbarui
                                            pada:</strong>
                                        {{ $anggota->updated_at->format('d M Y, H:i') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-3 justify-content-end mt-4">
                    <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>

                    @if ($userRole == 'Admin')
                        <a href="{{ route('anggota.edit', $anggota->id_anggota) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                        <form action="{{ route('anggota.destroy', $anggota->id_anggota) }}" method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Hapus Data
                            </button>
                        </form>
                    @else
                        <span class="badge bg-secondary fs-6 py-2 px-3">
                            <i class="fas fa-eye me-2"></i>Read-Only Access
                        </span>
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
