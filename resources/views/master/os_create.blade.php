@extends('layouts.admin')

@section('title', 'Tambah OS Baru')

@push('styles')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Tambah OS Baru</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.master-os') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form id="formTambahOS" action="#" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Left Column: Uploads -->
                    <div class="col-md-4">
                        <!-- Foto Wajah -->
                        <div class="card card-primary card-outline mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Foto Wajah</h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-person-circle display-1 text-secondary"></i>
                                </div>
                                <div class="form-group">
                                    <label for="fotoWajah" class="form-label d-none">Upload Foto</label>
                                    <input class="form-control" type="file" id="fotoWajah" name="foto_wajah"
                                        accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <!-- Scan KTP -->
                        <div class="card card-warning card-outline mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Scan KTP</h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-card-image display-4 text-secondary"></i>
                                </div>
                                <div class="form-group">
                                    <label for="scanKtp" class="form-label d-none">Upload KTP</label>
                                    <input class="form-control" type="file" id="scanKtp" name="scan_ktp" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG (Max 2MB)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Personal Data -->
                    <div class="col-md-8">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Data Pribadi (Sesuai KTP)</h3>
                            </div>
                            <div class="card-body">
                                <!-- NIK -->
                                <div class="mb-3">
                                    <label class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="inputNIK" placeholder="Contoh: 1234567890123456"
                                        name="nik" required>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputNama" placeholder="Masukkan Nama Lengkap"
                                        name="nama_lengkap" required>
                                </div>

                                <!-- TTL -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir"
                                            name="tempat_lahir">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir">
                                    </div>
                                </div>

                                <!-- Jenis Kelamin & Goldar -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin">
                                            <option selected disabled>Pilih Jenis Kelamin</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Golongan Darah</label>
                                        <select class="form-select" name="golongan_darah">
                                            <option selected disabled>Pilih Golongan Darah</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O">O</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" rows="2" placeholder="Masukkan Alamat Lengkap"
                                        name="alamat"></textarea>
                                </div>

                                <!-- Provinsi & Kota -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Provinsi</label>
                                        <select class="form-select" name="provinsi" id="provinsi">
                                            <option selected disabled>Pilih Provinsi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kabupaten/Kota</label>
                                        <select class="form-select" name="kabupaten" id="kabupaten">
                                            <option selected disabled>Pilih Kabupaten/Kota</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kecamatan & Desa -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Kecamatan</label>
                                        <select class="form-select" name="kecamatan" id="kecamatan">
                                            <option selected disabled>Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kel/Desa</label>
                                        <select class="form-select" name="desa" id="desa">
                                            <option selected disabled>Pilih Kel/Desa</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- RT/RW & Kode Pos -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">RT / RW</label>
                                        <input type="text" class="form-control" placeholder="Contoh: 001/002" name="rt_rw">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" placeholder="Contoh: 12345" name="kode_pos">
                                    </div>
                                </div>

                                <!-- Agama & Status -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Agama</label>
                                        <select class="form-select" name="agama">
                                            <option selected disabled>Pilih Agama</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                            <option value="Konghucu">Konghucu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Status Perkawinan</label>
                                        <select class="form-select" name="status_perkawinan">
                                            <option selected disabled>Pilih Status</option>
                                            <option value="Belum Menikah">Belum Menikah</option>
                                            <option value="Menikah">Menikah</option>
                                            <option value="Cerai Hidup">Cerai Hidup</option>
                                            <option value="Cerai Mati">Cerai Mati</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- No HP Only -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">No. Handphone</label>
                                        <input type="text" class="form-control" placeholder="Contoh: 08123456789"
                                            name="no_hp">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

            // Helper function to load options
            function loadOptions(url, selectElement, placeholder, valueKey = 'id', textKey = 'name') {
                selectElement.innerHTML = `<option selected disabled>Loading...</option>`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        selectElement.innerHTML = `<option selected disabled>${placeholder}</option>`;
                        data.forEach(item => {
                            const option = document.createElement('option');
                            option.value = item[valueKey];
                            option.textContent = item[textKey];
                            option.dataset.id = item.id;
                            selectElement.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        selectElement.innerHTML = `<option selected disabled>Gagal memuat data</option>`;
                    });
            }

            // 1. Load Provinsi
            loadOptions('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', provinsiSelect, 'Pilih Provinsi');

            // 2. On Provinsi Change -> Load Kabupaten
            provinsiSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const provinsiId = selectedOption.dataset.id || this.value;

                kabupatenSelect.innerHTML = '<option selected disabled>Pilih Kabupaten/Kota</option>';
                kecamatanSelect.innerHTML = '<option selected disabled>Pilih Kecamatan</option>';
                desaSelect.innerHTML = '<option selected disabled>Pilih Kel/Desa</option>';

                if (provinsiId) {
                    loadOptions(
                        `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsiId}.json`,
                        kabupatenSelect, 'Pilih Kabupaten/Kota');
                }
            });

            // 3. On Kabupaten Change -> Load Kecamatan
            kabupatenSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const kabupatenId = selectedOption.dataset.id || this.value;

                kecamatanSelect.innerHTML = '<option selected disabled>Pilih Kecamatan</option>';
                desaSelect.innerHTML = '<option selected disabled>Pilih Kel/Desa</option>';

                if (kabupatenId) {
                    loadOptions(
                        `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupatenId}.json`,
                        kecamatanSelect, 'Pilih Kecamatan');
                }
            });

            // 4. On Kecamatan Change -> Load Desa
            kecamatanSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const kecamatanId = selectedOption.dataset.id || this.value;

                desaSelect.innerHTML = '<option selected disabled>Pilih Kel/Desa</option>';

                if (kecamatanId) {
                    loadOptions(
                        `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`,
                        desaSelect, 'Pilih Kel/Desa');
                }
            });


            // --- SweetAlert2 Logic ---
            const form = document.getElementById('formTambahOS');
            const inputNIK = document.getElementById('inputNIK');
            const inputNama = document.getElementById('inputNama');

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Prevent default submission

                    const nik = inputNIK ? inputNIK.value.trim() : '';
                    const nama = inputNama ? inputNama.value.trim() : '';

                    // 1. Validation Check (Empty)
                    if (!nik || !nama) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Karyawan tidak bisa ditambahkan karena Data Kosong atau Tidak Lengkap.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    // 2. Validation Check (Simulated Existing NIK)
                    // If NIK is "12345678", we simulate an error
                    if (nik === '12345678') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Karyawan tidak bisa ditambahkan karena NIK sudah terdaftar.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    // 3. Confirmation Dialog
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Untuk menyimpan data ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // 4. Success Simulation
                            // form.submit(); // Uncomment for real submission

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Karyawan berhasil ditambahkan.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Optional: Reset
                                form.reset();
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush