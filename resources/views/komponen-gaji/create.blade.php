<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Komponen Gaji - Data Komponen Gaji</title>
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

        .form-control,
        .form-select {
            border: 2px solid #667eea;
            border-radius: 10px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="main-container">
            <div class="header-section text-center">
                <i class="fas fa-plus-circle fa-3x mb-3"></i>
                <h1 class="display-5 fw-bold mb-0">Tambah Komponen Gaji</h1>
                <p class="mb-0 opacity-75">Menambahkan data komponen gaji baru</p>
            </div>

            <div class="p-4">
                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('komponen-gaji.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <!-- Nama Komponen -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_komponen" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nama Komponen
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_komponen') is-invalid @enderror" 
                                   id="nama_komponen" 
                                   name="nama_komponen" 
                                   value="{{ old('nama_komponen') }}" 
                                   placeholder="Masukkan nama komponen gaji"
                                   required>
                            @error('nama_komponen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">
                                <i class="fas fa-layer-group me-2"></i>Kategori
                            </label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach (\App\Models\KomponenGaji::getKategoriOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">
                                <i class="fas fa-user-tie me-2"></i>Jabatan
                            </label>
                            <select class="form-select @error('jabatan') is-invalid @enderror" 
                                    id="jabatan" 
                                    name="jabatan" 
                                    required>
                                <option value="">Pilih Jabatan</option>
                                @foreach (\App\Models\KomponenGaji::getJabatanKomponenOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('jabatan') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nominal -->
                        <div class="col-md-6 mb-3">
                            <label for="nominal" class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Nominal
                            </label>
                            <input type="number" 
                                   class="form-control @error('nominal') is-invalid @enderror" 
                                   id="nominal" 
                                   name="nominal" 
                                   value="{{ old('nominal') }}" 
                                   placeholder="Masukkan nominal"
                                   min="0"
                                   step="0.01"
                                   required>
                            @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div class="col-md-6 mb-3">
                            <label for="satuan" class="form-label">
                                <i class="fas fa-calculator me-2"></i>Satuan
                            </label>
                            <select class="form-select @error('satuan') is-invalid @enderror" 
                                    id="satuan" 
                                    name="satuan" 
                                    required>
                                <option value="">Pilih Satuan</option>
                                @foreach (\App\Models\KomponenGaji::getSatuanOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('satuan') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('satuan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-12 mb-4">
                            <label for="deskripsi" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Deskripsi
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      placeholder="Masukkan deskripsi komponen gaji (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('komponen-gaji.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        // Auto-format nominal input as currency
        document.getElementById('nominal').addEventListener('input', function(e) {
            let value = e.target.value;
            // Remove any non-digit characters except decimal point
            value = value.replace(/[^\d.]/g, '');
            e.target.value = value;
        });

        // Dynamic nominal format based on satuan selection
        document.getElementById('satuan').addEventListener('change', function(e) {
            const nominalInput = document.getElementById('nominal');
            const nominalLabel = document.querySelector('label[for="nominal"]');
            
            if (e.target.value === 'Persen') {
                nominalInput.setAttribute('max', '100');
                nominalInput.setAttribute('step', '0.01');
                nominalInput.setAttribute('placeholder', 'Masukkan persentase (0-100)');
                nominalLabel.innerHTML = '<i class="fas fa-percentage me-2"></i>Nominal (%)';
            } else if (e.target.value === 'Unit') {
                nominalInput.setAttribute('max', '');
                nominalInput.setAttribute('step', '1');
                nominalInput.setAttribute('placeholder', 'Masukkan jumlah unit');
                nominalLabel.innerHTML = '<i class="fas fa-hashtag me-2"></i>Nominal (Unit)';
            } else {
                nominalInput.setAttribute('max', '');
                nominalInput.setAttribute('step', '0.01');
                nominalInput.setAttribute('placeholder', 'Masukkan nominal dalam rupiah');
                nominalLabel.innerHTML = '<i class="fas fa-money-bill-wave me-2"></i>Nominal (Rp)';
            }
        });
    </script>
</body>

</html>