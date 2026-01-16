@extends('layouts.admin')

@section('title', 'Edit OS')

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
                    <h3 class="mb-0 fw-bold">Edit OS</h3>
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
            <form id="formEditOS" action="#" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <!-- Left Column: Uploads -->
                    <div class="col-md-4">
                        <!-- Foto Wajah -->
                        <div class="card card-warning card-outline mb-3">
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
                                    <i class="bi bi-card-image display-4 text-warning"></i>
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
                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Data Pribadi (Sesuai KTP)</h3>
                            </div>
                            <div class="card-body">
                                <!-- NIK -->
                                <div class="mb-3">
                                    <label class="form-label">NIK (Nomor Induk Kependudukan) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="inputNIK" value="3674012005900001"
                                        readonly name="nik" required>
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputNama" value="Andi Saputra"
                                        name="nama_lengkap" required>
                                </div>

                                <!-- TTL -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" value="Cilegon" name="tempat_lahir">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="tanggal_lahir" value="1990-05-20">
                                    </div>
                                </div>

                                <!-- Jenis Kelamin & Goldar -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="jenis_kelamin">
                                            <option disabled>Pilih Jenis Kelamin</option>
                                            <option value="L" selected>Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Golongan Darah</label>
                                        <select class="form-select" name="golongan_darah">
                                            <option disabled>Pilih Golongan Darah</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="AB">AB</option>
                                            <option value="O" selected>O</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" rows="2"
                                        name="alamat">Jl. Sultan Ageng Tirtayasa No. 10</textarea>
                                </div>

                                <!-- Provinsi & Kota -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" value="Banten" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kabupaten/Kota</label>
                                        <input type="text" class="form-control" value="Cilegon" readonly>
                                    </div>
                                </div>

                                <!-- Kecamatan & Desa -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Kecamatan</label>
                                        <input type="text" class="form-control" value="Cibeber" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kel/Desa</label>
                                        <input type="text" class="form-control" value="Cibeber" readonly>
                                    </div>
                                </div>

                                <!-- RT/RW & Kode Pos -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">RT / RW</label>
                                        <input type="text" class="form-control" value="001/002" name="rt_rw">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" class="form-control" value="42426" name="kode_pos">
                                    </div>
                                </div>

                                <!-- No HP Only -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">No. Handphone</label>
                                        <input type="text" class="form-control" value="081234567890" name="no_hp">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="button" class="btn btn-danger me-2" id="btnBlacklist">
                                    <i class="bi bi-slash-circle"></i> Blacklist
                                </button>
                                <button type="submit" class="btn btn-warning text-white">
                                    <i class="bi bi-save"></i> Perbarui Data
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
            // --- SweetAlert2 Logic ---
            const form = document.getElementById('formEditOS');
            const inputNIK = document.getElementById('inputNIK');
            const inputNama = document.getElementById('inputNama');
            const btnBlacklist = document.getElementById('btnBlacklist');

            // Blacklist Button Logic
            if (btnBlacklist) {
                btnBlacklist.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Konfirmasi Blacklist',
                        text: 'Apakah anda yakin ingin memasukkan karyawan ini ke daftar blacklist?',
                        icon: 'warning',
                        html: `
                                <p class="text-muted mb-2 text-start">Silakan masukkan alasan blacklist:</p>
                                <textarea id="swal-input-reason" class="form-control" rows="3" placeholder="Contoh: Pelanggaran berat K3, dokumen palsu, dll..."></textarea>
                            `,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Blacklist',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        reverseButtons: true,
                        focusConfirm: false,
                        preConfirm: () => {
                            const reason = document.getElementById('swal-input-reason').value;
                            if (!reason) {
                                Swal.showValidationMessage('Alasan tidak boleh kosong');
                            }
                            return reason;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Success Notification
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Karyawan berhasil ditambahkan ke blacklist.', // Using slightly clearer wording while keeping "berhasil ditambahkan" intent
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Optional: Redirect or update UI
                                window.location.href = "{{ route('user.master-os') }}";
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // No action needed specifically for cancel, standard behavior
                        }
                    });
                });
            }

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // Prevent default submission

                    const nik = inputNIK ? inputNIK.value.trim() : '';
                    const nama = inputNama ? inputNama.value.trim() : '';

                    if (!nik || !nama) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Karyawan tidak bisa diperbarui karena Data Kosong atau Tidak Lengkap.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Untuk memperbarui data ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc107',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Perbarui',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data Karyawan berhasil diperbarui.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Optional logic
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush