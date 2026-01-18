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
                    <a href="{{ route('user.master-vendor') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Bagian Data Vendor -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Data Vendor (Current)</h3>
                        </div>
                        <div class="card-body">
                            <!-- Nama Vendor -->
                            <div class="mb-3">
                                <label class="form-label">Nama Vendor</label>
                                <input type="text" class="form-control" value="PT. Teknologi Indonesia" readonly>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3"
                                    readonly>Jl. Raya Industri No. 123, Jakarta, Indonesia</textarea>
                            </div>

                            <!-- Nama PIC & No Handphone -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama PIC</label>
                                    <input type="text" class="form-control" value="Budi Santoso" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone</label>
                                    <input type="text" class="form-control" value="0812-3456-7890" readonly>
                                </div>
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