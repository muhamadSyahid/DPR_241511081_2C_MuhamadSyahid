<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anggota DPR - Tambah Anggota</title>
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

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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
                <i class="fas fa-user-plus fa-3x mb-3"></i>
                <h1 class="display-6 fw-bold mb-0">Tambah Anggota DPR</h1>
                <p class="mb-0 opacity-75">Formulir penambahan data anggota baru</p>
            </div>

            <div class="p-4">
                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_depan" class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Nama Depan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_depan') is-invalid @enderror"
                                id="nama_depan" name="nama_depan" value="{{ old('nama_depan') }}"
                                placeholder="Masukkan nama depan" required>
                            @error('nama_depan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_belakang" class="form-label fw-bold">
                                <i class="fas fa-user me-2"></i>Nama Belakang <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_belakang') is-invalid @enderror"
                                id="nama_belakang" name="nama_belakang" value="{{ old('nama_belakang') }}"
                                placeholder="Masukkan nama belakang" required>
                            @error('nama_belakang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gelar_depan" class="form-label fw-bold">
                                <i class="fas fa-graduation-cap me-2"></i>Gelar Depan
                            </label>
                            <input type="text" class="form-control @error('gelar_depan') is-invalid @enderror"
                                id="gelar_depan" name="gelar_depan" value="{{ old('gelar_depan') }}"
                                placeholder="Contoh: Dr., Prof.">
                            @error('gelar_depan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gelar_belakang" class="form-label fw-bold">
                                <i class="fas fa-graduation-cap me-2"></i>Gelar Belakang
                            </label>
                            <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror"
                                id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang') }}"
                                placeholder="Contoh: S.H., M.Si.">
                            @error('gelar_belakang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label fw-bold">
                                <i class="fas fa-briefcase me-2"></i>Jabatan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan"
                                name="jabatan" required>
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatanOptions as $key => $value)
                                    <option value="{{ $key }}" {{ old('jabatan') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status_pernikahan" class="form-label fw-bold">
                                <i class="fas fa-heart me-2"></i>Status Pernikahan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status_pernikahan') is-invalid @enderror"
                                id="status_pernikahan" name="status_pernikahan" required>
                                <option value="">Pilih Status Pernikahan</option>
                                @foreach ($statusPernikahanOptions as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('status_pernikahan') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_pernikahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3 justify-content-end mt-4">
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
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
</body>

</html>
