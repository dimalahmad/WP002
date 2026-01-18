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
    @php
        // STATE DEMO: "Clean" (Bersih) tapi dengan riwayat yang kaya
        $isBlacklisted = false; 
    @endphp
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
            <!-- NAVIGASI TAB DIHAPUS - DIGANTI DENGAN TAMPILAN FULL PAGE -->

            <div class="row">
                <!-- KONTEN TAB 1: PROFIL & EDIT (SEKARANG DITAMPILKAN LANGSUNG) -->
                <div class="col-12 mb-4">
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
                                            <input class="form-control" type="file" id="scanKtp" name="scan_ktp"
                                                accept="image/*">
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
                                            <label class="form-label">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
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
                                                <input type="date" class="form-control" name="tanggal_lahir"
                                                    value="1990-05-20">
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

                <!-- KONTEN TAB 2: RIWAYAT PEKERJAAN (SEKARANG DITAMPILKAN LANGSUNG) -->
                <div class="col-12 mb-4">


                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Penugasan Work Permit</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>No. WP</th>
                                            <th>Vendor</th>
                                            <th>Posisi / Peran</th>
                                            <th>Area Kerja</th>
                                            <th>Periode</th>
                                            <th>Durasi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dummy History 1: Office (Current) -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none">WP-2024-001</a></td>
                                            <td>PT. Teknologi Maju</td>
                                            <td>Teknisi Jaringan</td>
                                            <td>Office (Gedung Utama)</td>
                                            <td>14 Jan 2024 - 14 Jan 2025</td>
                                            <td>1 Tahun</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                        </tr>
                                        <!-- Dummy History 2: Manufacturing -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2023-089</a>
                                            </td>
                                            <td>PT. Rekayasa Industri</td>
                                            <td>Operator Produksi</td>
                                            <td>Manufacturing (Pabrik Baja)</td>
                                            <td>01 Jan 2023 - 31 Des 2023</td>
                                            <td>1 Tahun</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                        <!-- Dummy History 3: QC -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2022-015</a>
                                            </td>
                                            <td>PT. Quality Control Prima</td>
                                            <td>Staff QC</td>
                                            <td>Quality Control Lab</td>
                                            <td>01 Jan 2022 - 31 Des 2022</td>
                                            <td>1 Tahun</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                        <!-- Dummy History 4: Helper -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2021-112</a>
                                            </td>
                                            <td>PT. Bangun Jaya</td>
                                            <td>Helper Mekanik</td>
                                            <td>Workshop Area</td>
                                            <td>01 Jun 2021 - 31 Des 2021</td>
                                            <td>6 Bulan</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                        <!-- Dummy History 5: General Worker -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2020-055</a>
                                            </td>
                                            <td>PT. Sumber Daya</td>
                                            <td>General Worker</td>
                                            <td>Gudang Logistik</td>
                                            <td>01 Jan 2020 - 31 Des 2020</td>
                                            <td>1 Tahun</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Data ini digenerate otomatis
                                berdasarkan Work Permit yang pernah diikuti.</small>
                        </div>
                    </div>
                </div>

                <!-- KONTEN TAB 3: RIWAYAT PELANGGARAN (SEKARANG DITAMPILKAN LANGSUNG) -->
                <div class="col-12 mb-4">


                    <div class="card card-outline card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Catatan & Perubahan</h3>
                        </div>
                        <div class="card-body">
                            @if($isBlacklisted)
                                <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill fs-3 me-3"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Status: BLACKLISTED</h5>
                                        <small>Karyawan ini sedang dalam masa hukuman/blacklist. Tidak diperkenankan masuk
                                            area.</small>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill fs-3 me-3"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Tidak Ada Pelanggaran Aktif</h5>
                                        <small>Saat ini karyawan ini bersih dari catatan blacklist aktif.</small>
                                    </div>
                                </div>
                            @endif

                            <h5 class="fw-bold mt-4 mb-3">Arsip Pelanggaran</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Keterangan</th>
                                            <th>Sanksi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($isBlacklisted)
                                            <tr class="table-danger">
                                                <td>15 Jan 2024</td>
                                                <td><span class="badge bg-danger">Berat</span></td>
                                                <td>Tertangkap merokok di area Flammable Storage.</td>
                                                <td>Blacklist 5 Tahun</td>
                                                <td><span class="badge bg-danger">Aktif</span></td>
                                            </tr>
                                            <tr>
                                                <td>10 Des 2022</td>
                                                <td><span class="badge bg-warning text-dark">Sedang</span></td>
                                                <td>Tidak menggunakan APD lengkap saat bekerja di ketinggian.</td>
                                                <td>SP 2</td>
                                                <td><span class="badge bg-secondary">Selesai</span></td>
                                            </tr>
                                        @else
                                            <!-- Demo: User Bersih, tapi punya riwayat masa lalu -->
                                            <tr>
                                                <td>10 Feb 2021</td>
                                                <td><span class="badge bg-success">Ringan</span></td>
                                                <td>Lupa membawa ID Card saat memasuki area.</td>
                                                <td>Teguran Lisan</td>
                                                <td><span class="badge bg-secondary">Selesai</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-2 bg-light small">
                                                    <em>Tidak ada catatan pelanggaran lainnya.</em>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Logika SweetAlert2 ---
            const form = document.getElementById('formEditOS');
            const inputNIK = document.getElementById('inputNIK');
            const inputNama = document.getElementById('inputNama');
            const btnBlacklist = document.getElementById('btnBlacklist');

            // Logika Tombol Blacklist
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
                    e.preventDefault(); // Mencegah pengiriman default

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