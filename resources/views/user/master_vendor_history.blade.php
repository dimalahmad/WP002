@extends('layouts.admin')

@section('title', 'Riwayat Vendor')

@push('styles')
    <!-- CSS DataTables untuk Tabel Riwayat -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Riwayat Data Vendor</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.master-vendor.edit') }}" class="btn btn-warning text-white me-2">
                        <i class="bi bi-pencil-square"></i> Edit Data
                    </a>
                    <a href="{{ route('user.master-vendor') }}" class="btn btn-secondary">
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
                            <i class="bi bi-briefcase-fill fs-3 me-3"></i>
                            <div>
                                <h5 class="fw-bold mb-0">Status Keaktifan: <span class="badge bg-success ms-2">ACTIVE</span>
                                </h5>
                                <small class="mb-0">Kontrak berlaku hingga: <strong>14 Januari 2025</strong></small>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Sisa Waktu</small>
                            <span class="fw-bold fs-5">11 Bulan 23 Hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Data Vendor -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 4px solid #007bff !important;">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title fw-bold text-dark mb-0"><i class="bi bi-building me-2 text-primary"></i>
                                Data Vendor (Current)</h5>
                        </div>
                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase w-25 small"
                                                style="letter-spacing: 0.5px;">Nama Vendor</td>
                                            <td class="fw-bold text-dark fs-5">PT. Teknologi Indonesia</td>
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
                                                Jl. Raya Industri No. 123, Jakarta, Indonesia
                                            </td>
                                        </tr>
                                        <tr> <!-- Pembatas Halus -->
                                            <td colspan="2">
                                                <hr class="my-0 text-muted" style="opacity: 0.1">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">Area Layanan</td>
                                            <td class="text-dark">Maintenance & Konsultan IT</td>
                                            <!-- Dummy static data to make it look full -->
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">PIC Utama</td>
                                            <td class="fw-bold text-dark">Budi Santoso</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted fw-bold text-uppercase small"
                                                style="letter-spacing: 0.5px;">Kontak PIC</td>
                                            <td class="fw-bold text-primary"><i class="bi bi-whatsapp me-1"></i>
                                                0812-3456-7890</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Riwayat Kontrak (DEMO) -->
            <div class="row mb-4">
                <div class="col-md-12">
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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-light">
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Menampilkan 3 dari 12 total
                                kontrak.</small>
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
                            <table id="tableHistoryVendor" class="table table-bordered table-striped w-100">
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
                                        <td>10/02/2026 08:30</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-warning">Update</span></td>
                                        <td>Status Vendor berubah dari 'Hold' menjadi 'Active'.</td>
                                    </tr>
                                    <tr>
                                        <td>15/01/2026 09:30</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-warning">Update</span></td>
                                        <td>Perubahan Nama PIC dari 'Andi' menjadi 'Budi Santoso'.</td>
                                    </tr>
                                    <tr>
                                        <td>10/01/2026 14:20</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-success">Create</span></td>
                                        <td>Vendor baru ditambahkan. Vendor prioritas untuk pengadaan IT.</td>
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
            $('#tableHistoryVendor').DataTable({
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