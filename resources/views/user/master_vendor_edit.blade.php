@extends('layouts.admin')

@section('title', 'Edit Vendor')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <h3 class="mb-0 fw-bold">Edit Vendor</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.master-vendor') }}" class="btn btn-secondary">
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
                <!-- KONTEN TAB 1: PROFIL PERUSAHAAN (SEKARANG DITAMPILKAN LANGSUNG) -->
                <div class="col-12 mb-4">
                    <form id="formEditVendor" action="#" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-warning card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Vendor</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Nama Vendor -->
                                        <div class="mb-3">
                                            <label class="form-label">Nama Vendor <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="inputNamaVendor"
                                                value="PT. Teknologi Indonesia" name="nama_vendor" required>
                                        </div>

                                        <!-- Alamat Lengkap -->
                                        <div class="mb-3">
                                            <label class="form-label">Alamat Lengkap</label>
                                            <textarea class="form-control" rows="3"
                                                name="alamat">Jl. Raya Industri No. 123, Jakarta, Indonesia</textarea>
                                        </div>

                                        <!-- Nama PIC & No Handphone -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama PIC <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="inputNamaPIC"
                                                    value="Budi Santoso" name="nama_pic" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">No. Handphone</label>
                                                <input type="text" class="form-control" value="0812-3456-7890" name="no_hp">
                                            </div>
                                        </div>

                                        <!-- Catatan -->
                                        <div class="mb-3">
                                            <label class="form-label">Catatan</label>
                                            <textarea class="form-control" rows="3"
                                                name="catatan">Vendor prioritas untuk pengadaan IT.</textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
                                        <a href="{{ route('user.master-vendor.history') }}" class="btn btn-secondary me-2">
                                            <i class="bi bi-x-circle"></i> Batal
                                        </a>
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

                <!-- KONTEN TAB 2: RIWAYAT KONTRAK (SEKARANG DITAMPILKAN LANGSUNG) -->
                <div class="col-12 mb-4">


                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Kontrak (Work Permit)</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>No. WP</th>
                                            <th>Pekerjaan</th>
                                            <th>Lokasi</th>
                                            <th>Jumlah Pekerja</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dummy WP 1 -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none">WP-2024-001</a></td>
                                            <td>Maintenance Server Utama</td>
                                            <td>Data Center (Pusat)</td>
                                            <td><span class="badge bg-info text-dark">5 Orang</span></td>
                                            <td>14 Jan 2024 - 14 Jan 2025</td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                        </tr>
                                        <!-- Dummy WP 2 -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2023-044</a>
                                            </td>
                                            <td>Instalasi CCTV Baru</td>
                                            <td>Area Pabrik B</td>
                                            <td><span class="badge bg-info text-dark">3 Orang</span></td>
                                            <td>10 Agu 2023 - 20 Agu 2023</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                        <!-- Dummy WP 3 -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2022-101</a>
                                            </td>
                                            <td>Upgrade Jaringan Fiber Optic</td>
                                            <td>Kawasan Industri</td>
                                            <td><span class="badge bg-info text-dark">8 Orang</span></td>
                                            <td>01 Mar 2022 - 30 Apr 2022</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                        <!-- Dummy WP 4 -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none text-muted">WP-2021-005</a>
                                            </td>
                                            <td>Maintenance Rutin PC</td>
                                            <td>Office (Semua Lantai)</td>
                                            <td><span class="badge bg-info text-dark">2 Orang</span></td>
                                            <td>01 Jan 2021 - 31 Des 2021</td>
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                                    <i class="bi bi-exclamation-octagon-fill fs-3 me-3"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Status: BLACKLISTED</h5>
                                        <small>Vendor ini telah di-blacklist karena pelanggaran kontrak berat.</small>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
                                    <i class="bi bi-shield-check fs-3 me-3"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Vendor Terpercaya</h5>
                                        <small>Vendor ini memiliki reputasi baik dan tidak ada kasus blacklist aktif.</small>
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Sanksi</th>
                                            <th>Oleh</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($isBlacklisted)
                                            <tr class="table-danger">
                                                <td>20 Jan 2024</td>
                                                <td><span class="badge bg-danger">Berat</span></td>
                                                <td>Pemalsuan Dokumen Sertifikasi Tenaga Kerja.</td>
                                                <td>Admin HSE</td>
                                                <td><span class="badge bg-danger">Aktif</span></td>
                                            </tr>
                                            <tr>
                                                <td>05 Agu 2022</td>
                                                <td><span class="badge bg-warning text-dark">Sedang</span></td>
                                                <td>Keterlambatan pengerjaan proyek > 20%.</td>
                                                <td>Project Manager</td>
                                                <td><span class="badge bg-secondary">Selesai</span></td>
                                            </tr>
                                        @else
                                            <!-- Demo: Vendor Bersih, tapi punya riwayat masa lalu -->
                                            <tr>
                                                <td>15 Sep 2022</td>
                                                <td><span class="badge bg-warning text-dark">Sedang</span></td>
                                                <td>Keterlambatan submit dokumen laporan bulanan.</td>
                                                <td>Admin HSE</td>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('formEditVendor');
            const inputNamaVendor = document.getElementById('inputNamaVendor');
            const inputNamaPIC = document.getElementById('inputNamaPIC');
            const btnBlacklist = document.getElementById('btnBlacklist');

            // Logika Tombol Blacklist
            if (btnBlacklist) {
                btnBlacklist.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Konfirmasi Blacklist',
                        text: 'Apakah anda yakin ingin memasukkan vendor ini ke daftar blacklist?',
                        icon: 'warning',
                        html: `
                                                            <p class="text-muted mb-2 text-start">Silakan masukkan alasan blacklist:</p>
                                                            <textarea id="swal-input-reason" class="form-control" rows="3" placeholder="Contoh: Kinerja buruk, pelanggaran kontrak, dokumen palsu, dll..."></textarea>
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
                            // Notifikasi Sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Vendor berhasil ditambahkan ke blacklist.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Opsional: Redirect atau perbarui antarmuka
                                window.location.href = "{{ route('user.master-vendor') }}";
                            });
                        }
                    });
                });
            }

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const namaVendor = inputNamaVendor ? inputNamaVendor.value.trim() : '';
                    const namaPIC = inputNamaPIC ? inputNamaPIC.value.trim() : '';

                    if (!namaVendor || !namaPIC) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data Vendor tidak bisa diperbarui karena Nama Vendor atau Nama PIC kosong.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Untuk memperbarui data vendor ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ffc107', // Warna peringatan
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Perbarui',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data Vendor berhasil diperbarui.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Optional: Redirect
                                // window.location.href = "{{ route('user.master-vendor') }}";
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush