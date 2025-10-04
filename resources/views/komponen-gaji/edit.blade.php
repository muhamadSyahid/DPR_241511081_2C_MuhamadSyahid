<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Komponen Gaji - {{ $komponenGaji->nama_komponen }}</title>
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

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .current-data-card {
            background: rgba(255, 235, 59, 0.1);
            border: 2px solid #ffc107;
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-edit fa-2x mb-2"></i>
                <h1 class="h2 fw-bold mb-0">Edit Komponen Gaji</h1>
                <p class="mb-0 opacity-75 small">{{ $komponenGaji->nama_komponen }}</p>
            </div>

            <div class="p-3">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>

                <!-- Current Data Display -->
                <div class="current-data-card">
                    <h5 class="fw-bold mb-2">
                        <i class="fas fa-info-circle text-warning me-2"></i>
                        Data Saat Ini
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nama:</strong> {{ $komponenGaji->nama_komponen }}</p>
                            <p class="mb-1"><strong>Kategori:</strong> <span class="badge bg-info">{{ $komponenGaji->kategori }}</span></p>
                            <p class="mb-1"><strong>Jabatan:</strong> <span class="badge bg-secondary">{{ $komponenGaji->jabatan }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Nominal:</strong> <span class="text-success fw-bold">{{ $komponenGaji->formatted_nominal }}</span></p>
                            <p class="mb-1"><strong>Satuan:</strong> <span class="badge bg-warning text-dark">{{ $komponenGaji->satuan }}</span></p>
                        </div>
                    </div>
                    @if ($komponenGaji->deskripsi)
                        <p class="mb-0 mt-2"><strong>Deskripsi:</strong> {{ $komponenGaji->deskripsi }}</p>
                    @endif
                </div>

                <!-- Edit Form -->
                <form action="{{ route('komponen-gaji.update', $komponenGaji) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Terjadi Kesalahan:
                            </h6>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Nama Komponen -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_komponen" class="form-label fw-bold">
                                <i class="fas fa-tag me-1"></i>Nama Komponen
                            </label>
                            <input type="text" class="form-control @error('nama_komponen') is-invalid @enderror" 
                                   id="nama_komponen" 
                                   name="nama_komponen" 
                                   value="{{ old('nama_komponen', $komponenGaji->nama_komponen) }}" 
                                   placeholder="Masukkan nama komponen gaji" 
                                   required>
                            @error('nama_komponen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-bold">
                                <i class="fas fa-list me-1"></i>Kategori
                            </label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriOptions as $option)
                                    <option value="{{ $option }}" 
                                            {{ old('kategori', $komponenGaji->kategori) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label fw-bold">
                                <i class="fas fa-user-tie me-1"></i>Jabatan
                            </label>
                            <select class="form-select @error('jabatan') is-invalid @enderror" 
                                    id="jabatan" 
                                    name="jabatan" 
                                    required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($jabatanOptions as $option)
                                    <option value="{{ $option }}" 
                                            {{ old('jabatan', $komponenGaji->jabatan) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div class="col-md-6 mb-3">
                            <label for="satuan" class="form-label fw-bold">
                                <i class="fas fa-clock me-1"></i>Satuan
                            </label>
                            <select class="form-select @error('satuan') is-invalid @enderror" 
                                    id="satuan" 
                                    name="satuan" 
                                    required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuanOptions as $option)
                                    <option value="{{ $option }}" 
                                            {{ old('satuan', $komponenGaji->satuan) == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nominal -->
                        <div class="col-md-12 mb-3">
                            <label for="nominal" class="form-label fw-bold">
                                <i class="fas fa-money-bill-wave me-1"></i>Nominal (Rp)
                            </label>
                            <input type="number" class="form-control @error('nominal') is-invalid @enderror" 
                                   id="nominal" 
                                   name="nominal" 
                                   value="{{ old('nominal', $komponenGaji->nominal) }}" 
                                   placeholder="Masukkan nominal dalam rupiah" 
                                   min="0" 
                                   step="1000" 
                                   required>
                            @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Masukkan nominal tanpa titik atau koma pemisah ribuan
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi" class="form-label fw-bold">
                                <i class="fas fa-comment me-1"></i>Deskripsi
                                <small class="text-muted">(Opsional)</small>
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3" 
                                      placeholder="Masukkan deskripsi komponen gaji (opsional)">{{ old('deskripsi', $komponenGaji->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>

                <!-- Warning Note -->
                <div class="alert alert-warning mt-3" role="alert">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Perhatian!
                    </h6>
                    <ul class="mb-0 small">
                        <li>Perubahan data akan mempengaruhi perhitungan gaji yang sudah ada</li>
                        <li>Pastikan data yang dimasukkan sudah benar sebelum menyimpan</li>
                        <li>Komponen gaji yang sedang digunakan dalam penggajian tidak dapat dihapus</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        // Format nominal input as currency
        document.getElementById('nominal').addEventListener('input', function(e) {
            let value = e.target.value;
            if (value) {
                // Remove any non-digit characters
                value = value.replace(/\D/g, '');
                e.target.value = value;
            }
        });
    </script>
</body>

</html>