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
                    <a href="{{ route('user.master-os') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Bagian Data OS -->
            <div class="row mb-4">
                <!-- Kolom Kiri: Uploads -->
                <div class="col-md-4">
                    <!-- Foto Wajah -->
                    <div class="card card-success card-outline mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Foto Wajah</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-person-circle display-1 text-success"></i>
                            </div>
                            <div class="form-group">
                                <label class="form-label d-none">Upload Foto</label>
                                <button class="btn btn-outline-success btn-sm" disabled>
                                    <i class="bi bi-eye"></i> Lihat Foto
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Scan KTP -->
                    <div class="card card-success card-outline mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Scan KTP</h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-card-image display-4 text-success"></i>
                            </div>
                            <div class="form-group">
                                <label class="form-label d-none">Upload KTP</label>
                                <button class="btn btn-outline-success btn-sm" disabled>
                                    <i class="bi bi-eye"></i> Lihat KTP
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Data Pribadi -->
                <div class="col-md-8">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Data Pribadi (Sesuai KTP)</h3>
                        </div>
                        <div class="card-body">
                            <!-- NIK -->
                            <div class="mb-3">
                                <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                                <input type="number" class="form-control" value="3674012005900001" readonly>
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" value="Andi Saputra" readonly>
                            </div>

                            <!-- TTL -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" value="Cilegon" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" value="1990-05-20" readonly>
                                </div>
                            </div>

                            <!-- Jenis Kelamin & Goldar -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <input type="text" class="form-control" value="Laki-laki" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Golongan Darah</label>
                                    <input type="text" class="form-control" value="O" readonly>
                                </div>
                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" rows="2"
                                    readonly>Jl. Sultan Ageng Tirtayasa No. 10</textarea>
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
                                    <input type="text" class="form-control" value="001/002" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kode Pos</label>
                                    <input type="text" class="form-control" value="42426" readonly>
                                </div>
                            </div>

                            <!-- No HP Only -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label">No. Handphone</label>
                                    <input type="text" class="form-control" value="081234567890" readonly>
                                </div>
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