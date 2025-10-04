<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Penggajian - Sistem Penggajian DPR</title>
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

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
        }

        .step-indicator {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .step-active {
            background: rgba(40, 167, 69, 0.1);
            border: 2px solid #28a745;
        }

        .step-inactive {
            background: rgba(108, 117, 125, 0.1);
            border: 2px solid #6c757d;
        }

        .anggota-card {
            background: rgba(23, 162, 184, 0.1);
            border: 2px solid #17a2b8;
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .component-selection {
            background: rgba(40, 167, 69, 0.1);
            border: 2px solid #28a745;
            border-radius: 15px;
            padding: 1rem;
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
                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                <h1 class="h2 fw-bold mb-0">Tambah Penggajian</h1>
                <p class="mb-0 opacity-75 small">Tambah Komponen Gaji untuk Anggota DPR</p>
            </div>

            <div class="p-3">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                </div>

                <!-- Step Indicators -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="step-indicator {{ !$selectedAnggotaId ? 'step-active' : 'step-inactive' }}">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-user-circle fa-2x {{ !$selectedAnggotaId ? 'text-success' : 'text-muted' }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Langkah 1</h6>
                                    <small class="text-muted">Pilih Anggota DPR</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="step-indicator {{ $selectedAnggotaId ? 'step-active' : 'step-inactive' }}">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-money-bill-wave fa-2x {{ $selectedAnggotaId ? 'text-success' : 'text-muted' }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Langkah 2</h6>
                                    <small class="text-muted">Pilih Komponen Gaji</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (!$selectedAnggotaId)
                    <!-- Step 1: Select Anggota -->
                    <div class="anggota-card">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-users text-info me-2"></i>
                            Pilih Anggota DPR
                        </h5>

                        <form action="{{ route('penggajian.create') }}" method="GET">
                            <div class="mb-3">
                                <label for="anggota_id" class="form-label fw-bold">
                                    <i class="fas fa-search me-1"></i>Cari dan Pilih Anggota
                                </label>
                                <select class="form-select" id="anggota_id" name="anggota_id" required>
                                    <option value="">-- Pilih Anggota DPR --</option>
                                    @foreach ($anggotaList as $anggota)
                                        <option value="{{ $anggota->id_anggota }}"
                                                data-jabatan="{{ $anggota->jabatan }}"
                                                data-status="{{ $anggota->status_pernikahan }}">
                                            {{ $anggota->id_anggota }} - {{ $anggota->full_name }} ({{ $anggota->jabatan }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Pilih anggota yang akan ditambahkan komponen gajinya
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-1"></i>Lanjut ke Pemilihan Komponen
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Information Box -->
                    <div class="alert alert-info" role="alert">
                        <h6 class="alert-heading">
                            <i class="fas fa-lightbulb me-1"></i>
                            Informasi
                        </h6>
                        <ul class="mb-0 small">
                            <li>Pilih anggota DPR yang akan ditambahkan komponen gajinya</li>
                            <li>Setelah memilih anggota, Anda dapat memilih komponen gaji yang sesuai</li>
                            <li>Komponen gaji akan disesuaikan dengan jabatan anggota</li>
                            <li>Tunjangan kondisional (istri/suami) otomatis diperhitungkan</li>
                        </ul>
                    </div>

                @else
                    <!-- Step 2: Select Component -->
                    <div class="anggota-card">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-user-check text-info me-2"></i>
                            Anggota Terpilih
                        </h5>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h6 class="mb-1">{{ $selectedAnggota->full_name }}</h6>
                                <div class="d-flex gap-2 mb-1">
                                    <span class="badge bg-primary">ID: {{ $selectedAnggota->id_anggota }}</span>
                                    <span class="badge bg-info">{{ $selectedAnggota->jabatan }}</span>
                                    <span class="badge bg-{{ $selectedAnggota->status_pernikahan == 'Kawin' ? 'success' : 'secondary' }}">{{ $selectedAnggota->status_pernikahan }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('penggajian.create') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-edit me-1"></i>Ganti Anggota
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($availableComponents->count() > 0)
                        <div class="component-selection">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-money-bill-wave text-success me-2"></i>
                                Pilih Komponen Gaji
                            </h5>

                            <form action="{{ route('penggajian.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_anggota" value="{{ $selectedAnggotaId }}">

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

                                <div class="mb-3">
                                    <label for="id_komponen_gaji" class="form-label fw-bold">
                                        <i class="fas fa-list me-1"></i>Komponen Gaji Tersedia
                                    </label>
                                    <select class="form-select @error('id_komponen_gaji') is-invalid @enderror" 
                                            id="id_komponen_gaji" 
                                            name="id_komponen_gaji" 
                                            required>
                                        <option value="">-- Pilih Komponen Gaji --</option>
                                        @foreach ($availableComponents->groupBy('kategori') as $kategori => $components)
                                            <optgroup label="{{ $kategori }}">
                                                @foreach ($components as $component)
                                                    <option value="{{ $component->id_komponen_gaji }}" 
                                                            data-kategori="{{ $component->kategori }}"
                                                            data-jabatan="{{ $component->jabatan }}"
                                                            data-satuan="{{ $component->satuan }}"
                                                            data-nominal="{{ $component->nominal }}"
                                                            data-formatted="{{ $component->formatted_nominal }}"
                                                            data-deskripsi="{{ $component->deskripsi }}"
                                                            {{ old('id_komponen_gaji') == $component->id_komponen_gaji ? 'selected' : '' }}>
                                                        {{ $component->nama_komponen }} - {{ $component->formatted_nominal }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('id_komponen_gaji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Komponen yang ditampilkan sudah disesuaikan dengan jabatan <strong>{{ $selectedAnggota->jabatan }}</strong>
                                    </div>
                                </div>

                                <!-- Component Preview -->
                                <div id="componentPreview" class="card d-none mb-3">
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <i class="fas fa-eye me-1"></i>Preview Komponen
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-flex gap-2 mb-2">
                                                    <span id="previewKategori" class="badge bg-info"></span>
                                                    <span id="previewJabatan" class="badge bg-secondary"></span>
                                                    <span id="previewSatuan" class="badge bg-warning text-dark"></span>
                                                </div>
                                                <p id="previewDeskripsi" class="card-text small text-muted mb-0"></p>
                                            </div>
                                            <div class="col-md-4 text-end">
                                                <div id="previewNominal" class="h5 text-success mb-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('penggajian.create') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Simpan Penggajian
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Information Box -->
                        <div class="alert alert-success mt-3" role="alert">
                            <h6 class="alert-heading">
                                <i class="fas fa-check-circle me-1"></i>
                                Informasi Tambahan
                            </h6>
                            <ul class="mb-0 small">
                                <li><strong>Total komponen tersedia:</strong> {{ $availableComponents->count() }} komponen</li>
                                <li><strong>Tunjangan Istri/Suami:</strong> {{ $selectedAnggota->status_pernikahan == 'Kawin' ? 'Akan otomatis ditambahkan' : 'Tidak berlaku' }}</li>
                                <li><strong>Take Home Pay:</strong> Akan dihitung otomatis setelah penyimpanan</li>
                            </ul>
                        </div>

                    @else
                        <div class="alert alert-warning text-center" role="alert">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <h5>Tidak Ada Komponen Tersedia</h5>
                            <p class="mb-3">
                                Tidak ada komponen gaji yang tersedia untuk anggota <strong>{{ $selectedAnggota->full_name }}</strong> 
                                dengan jabatan <strong>{{ $selectedAnggota->jabatan }}</strong>.
                            </p>
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('penggajian.create') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Pilih Anggota Lain
                                </a>
                                <a href="{{ route('komponen-gaji.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Tambah Komponen Gaji
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        // Component preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const componentSelect = document.getElementById('id_komponen_gaji');
            if (componentSelect) {
                componentSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const preview = document.getElementById('componentPreview');
                    
                    if (this.value && selectedOption.dataset.kategori) {
                        // Show preview
                        preview.classList.remove('d-none');
                        
                        // Update preview content
                        document.getElementById('previewKategori').textContent = selectedOption.dataset.kategori;
                        document.getElementById('previewJabatan').textContent = selectedOption.dataset.jabatan;
                        document.getElementById('previewSatuan').textContent = selectedOption.dataset.satuan;
                        document.getElementById('previewNominal').textContent = selectedOption.dataset.formatted;
                        document.getElementById('previewDeskripsi').textContent = selectedOption.dataset.deskripsi || 'Tidak ada deskripsi';
                    } else {
                        // Hide preview
                        preview.classList.add('d-none');
                    }
                });

                // Trigger preview on page load if there's a selected value
                if (componentSelect.value) {
                    componentSelect.dispatchEvent(new Event('change'));
                }
            }
        });

        // Anggota selection preview
        document.addEventListener('DOMContentLoaded', function() {
            const anggotaSelect = document.getElementById('anggota_id');
            if (anggotaSelect) {
                anggotaSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    // You can add preview functionality here if needed
                });
            }
        });
    </script>
</body>

</html>