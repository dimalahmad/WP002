@extends('layouts.admin')

@section('title', 'Riwayat OS')

@push('styles')
    <!-- CSS DataTables untuk Tabel Riwayat -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
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
                    <h3 class="mb-0 fw-bold">Riwayat Data OS</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.master-os.edit') }}" class="btn btn-warning text-white me-2">
                        <i class="bi bi-pencil-square"></i> Edit Data
                    </a>
                    <a href="{{ route('user.master-os') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Tanggal Berakhir & Status Alert -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info shadow-sm d-flex align-items-center justify-content-between px-4 py-3 border-0"
                        role="alert" style="background-color: #e3f2fd; color: #0d47a1;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check-fill fs-3 me-3"></i>
                            <div>
                                <h5 class="fw-bold mb-0">Status Keaktifan: <span class="badge bg-success ms-2">ACTIVE</span>
                                </h5>
                                <small class="mb-0">Masa berlaku akun hingga: <strong>20 Mei 2025</strong></small>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Sisa Waktu</small>
                            <span class="fw-bold fs-5">1 Tahun 4 Bulan 23 Hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Data OS -->
            <div class="row mb-4">
                <!-- Kolom Kiri: Uploads (Redesigned) -->
                <div class="col-md-4">
                    <!-- Foto Wajah (Langsung Tampil, Lebih Compact) -->
                    <div class="card shadow-sm border-0 mb-3 text-center overflow-hidden"
                        style="border-radius: 12px; border-top: 4px solid #007bff !important;">
                        <div class="card-body p-0">
                            <!-- Placeholder Image Replacement (Ganti src dengan path foto asli) -->
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                <i class="bi bi-person-fill text-secondary" style="font-size: 8rem;"></i>
                                <!-- <img src="{{ asset('path/to/photo.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover" alt="Foto Wajah"> -->
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 py-2">
                            <h6 class="fw-bold text-muted mb-0 small text-uppercase letter-spacing-1">Foto Wajah</h6>
                        </div>
                    </div>

                    <!-- Scan KTP (Compact & Pop-up) -->
                    <div class="card shadow-sm border-0 text-center"
                        style="border-radius: 12px; border-top: 4px solid #007bff !important;">
                        <div class="card-body p-3 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-3">
                                    <i class="bi bi-card-heading text-primary fs-3"></i>
                                </div>
                                <div class="text-start">
                                    <h6 class="fw-bold text-dark mb-0">Scan KTP</h6>
                                    <small class="text-muted">Dokumen Identitas</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                data-bs-toggle="modal" data-bs-target="#modalKTP">
                                <i class="bi bi-eye me-1"></i> Lihat
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk KTP -->
                <div class="modal fade" id="modalKTP" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Scan E-KTP</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center p-4">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height: 250px; border: 2px dashed #dee2e6;">
                                    <div class="text-muted">
                                        <i class="bi bi-file-earmark-image display-4 mb-2 d-block"></i>
                                        <span>Preview KTP Image Here</span>
                                    </div>
                                    <!-- Gunakan tag img di bawah ini untuk real app -->
                                    <!-- <img src="{{ asset('path/to/ktp.jpg') }}" class="img-fluid rounded shadow-sm" alt="Scan KTP"> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Data Pribadi -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 4px solid #007bff !important;">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title fw-bold text-dark mb-0"><i
                                    class="bi bi-person-lines-fill me-2 text-primary"></i> Data Pribadi (Sesuai KTP)</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase w-25 small"
                                                style="letter-spacing: 0.5px;">NIK</td>
                                            <td class="fw-bold text-dark fs-5">3674012005900001</td>
                                        </tr>
                                        <tr> <!-- Pembatas Halus -->
                                            <td colspan="2">
                                                <hr class="my-0 text-muted" style="opacity: 0.1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">Nama Lengkap</td>
                                            <td class="fw-bold text-dark">Andi Saputra</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">Tempat, Tgl Lahir</td>
                                            <td class="text-dark">Cilegon, 20 Mei 1990</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">Jenis Kelamin</td>
                                            <td class="text-dark">Laki-laki</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">Golongan Darah</td>
                                            <td class="text-dark">O</td>
                                        </tr>
                                        <tr> <!-- Pembatas Halus -->
                                            <td colspan="2">
                                                <hr class="my-0 text-muted" style="opacity: 0.1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small align-top py-3"
                                                style="letter-spacing: 0.5px;">Alamat Lengkap</td>
                                            <td class="text-dark py-3">
                                                Jl. Sultan Ageng Tirtayasa No. 10<br>
                                                <small class="text-muted">Desa Cibeber, Kec. Cibeber, Kota Cilegon, Banten -
                                                    42426</small>
                                            </td>
                                        </tr>
                                        <tr> <!-- Pembatas Halus -->
                                            <td colspan="2">
                                                <hr class="my-0 text-muted" style="opacity: 0.1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">No. Handphone</td>
                                            <td class="fw-bold text-primary"><i class="bi bi-whatsapp me-1"></i>
                                                081234567890</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Riwayat Penugasan (DEMO) -->
            <div class="row mb-4">
                <div class="col-md-12">
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
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Dummy History 1: Office (Saat Ini) -->
                                        <tr>
                                            <td><a href="#" class="fw-bold text-decoration-none">WP-2024-001</a></td>
                                            <td>PT. Teknologi Maju</td>
                                            <td>Teknisi Jaringan</td>
                                            <td>Office (Gedung Utama)</td>
                                            <td>14 Jan 2024 - 14 Jan 2025</td>
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
                                            <td><span class="badge bg-secondary">Selesai</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Data digenerate otomatis
                                berdasarkan riwayat WP.</small>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Bagian Riwayat / Log -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Catatan & Perubahan</h3>
                        </div>
                        <div class="card-body">
                            <table id="tableHistoryOS" class="table table-bordered table-striped w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 150px">Tanggal</th>
                                        <th style="width: 150px">User</th>
                                        <th>Aksi</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10/02/2024 08:15</td>
                                        <td>System</td>
                                        <td><span class="badge bg-danger">Blacklist</span></td>
                                        <td>Karyawan ditandai sebagai Blacklist karena Pelanggaran Berat K3.</td>
                                    </tr>
                                    <tr>
                                        <td>15/01/2026 09:30</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-warning">Update</span></td>
                                        <td>Perubahan No. Handphone dari '0812-0000-0000' menjadi '0812-3456-7890'.</td>
                                    </tr>
                                    <tr>
                                        <td>12/01/2026 13:00</td>
                                        <td>System</td>
                                        <td><span class="badge bg-info">Auto</span></td>
                                        <td>Status Work Permit WP-2024-001 menjadi Active.</td>
                                    </tr>
                                    <tr>
                                        <td>10/01/2026 14:20</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-success">Create</span></td>
                                        <td>Data karyawan OS baru ditambahkan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#tableHistoryOS').DataTable({
                "responsive": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "pageLength": 5
            });
        });
    </script>
@endpush