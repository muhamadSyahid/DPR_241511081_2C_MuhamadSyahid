<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Komponen Penggajian - {{ $anggota->full_name }}</title>
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

        .current-component-card {
            background: rgba(255, 235, 59, 0.1);
            border: 2px solid #ffc107;
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .new-component-card {
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
                <i class="fas fa-edit fa-2x mb-2"></i>
                <h1 class="h2 fw-bold mb-0">Edit Komponen Penggajian</h1>
                <p class="mb-0 opacity-75 small">{{ $anggota->full_name }}</p>
            </div>

            <div class="p-3">
                <!-- Back Button -->
                <div class="mb-3">
                    <a href="{{ route('penggajian.show', $anggota->id_anggota) }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Detail
                    </a>
                </div>

                <!-- Anggota Information -->
                <div class="card mb-3">
                    <div class="card-body p-2">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <strong>ID:</strong> {{ $anggota->id_anggota }}
                            </div>
                            <div class="col-md-4">
                                <strong>Jabatan:</strong> <span class="badge bg-info">{{ $anggota->jabatan }}</span>
                            </div>
                            <div class="col-md-4 text-end">
                                <span class="badge bg-{{ $anggota->status_pernikahan == 'Kawin' ? 'success' : 'secondary' }}">{{ $anggota->status_pernikahan }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Component Display -->
                <div class="current-component-card">
                    <h5 class="fw-bold mb-2">
                        <i class="fas fa-money-bill text-warning me-2"></i>
                        Komponen Saat Ini
                    </h5>
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-1">{{ $currentKomponenGaji->nama_komponen }}</h6>
                            <div class="d-flex gap-2 mb-1">
                                <span class="badge bg-info badge-sm">{{ $currentKomponenGaji->kategori }}</span>
                                <span class="badge bg-secondary badge-sm">{{ $currentKomponenGaji->jabatan }}</span>
                                <span class="badge bg-warning text-dark badge-sm">{{ $currentKomponenGaji->satuan }}</span>
                            </div>
                            @if ($currentKomponenGaji->deskripsi)
                                <small class="text-muted">{{ $currentKomponenGaji->deskripsi }}</small>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="h5 text-warning mb-0">{{ $currentKomponenGaji->formatted_nominal }}</div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <div class="new-component-card">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-exchange-alt text-success me-2"></i>
                        Ganti dengan Komponen Baru
                    </h5>

                    <form action="{{ route('penggajian.update', [$anggota->id_anggota, $currentKomponenGaji->id_komponen_gaji]) }}" method="POST">
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

                        <!-- Component Selection -->
                        <div class="mb-3">
                            <label for="id_komponen_gaji" class="form-label fw-bold">
                                <i class="fas fa-list me-1"></i>Pilih Komponen Baru
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
                                                {{ $component->nama_komponen }} ({{ $component->jabatan }}) - {{ $component->formatted_nominal }}
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
                                Hanya komponen yang sesuai dengan jabatan <strong>{{ $anggota->jabatan }}</strong> dan belum dipilih yang ditampilkan
                            </div>
                        </div>

                        <!-- Component Preview -->
                        <div id="componentPreview" class="card d-none mb-3">
                            <div class="card-body p-2">
                                <h6 class="mb-2">
                                    <i class="fas fa-eye me-1"></i>Preview Komponen
                                </h6>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-flex gap-2 mb-1">
                                            <span id="previewKategori" class="badge bg-info badge-sm"></span>
                                            <span id="previewJabatan" class="badge bg-secondary badge-sm"></span>
                                            <span id="previewSatuan" class="badge bg-warning text-dark badge-sm"></span>
                                        </div>
                                        <small id="previewDeskripsi" class="text-muted"></small>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div id="previewNominal" class="h6 text-success mb-0"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('penggajian.show', $anggota->id_anggota) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-save me-1"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Warning Note -->
                <div class="alert alert-warning mt-3" role="alert">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Perhatian!
                    </h6>
                    <ul class="mb-0 small">
                        <li>Mengubah komponen akan mengganti komponen lama dengan yang baru</li>
                        <li>Take Home Pay akan otomatis dihitung ulang</li>
                        <li>Tunjangan kondisional (istri/suami) akan tetap berlaku jika memenuhi syarat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <script>
        document.getElementById('id_komponen_gaji').addEventListener('change', function() {
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
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('id_komponen_gaji');
            if (select.value) {
                select.dispatchEvent(new Event('change'));
            }
        });
    </script>
</body>

</html>