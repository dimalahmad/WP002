@extends('layouts.admin')

@section('title', 'Riwayat Blacklist Vendor')

@push('styles')
    <!-- DataTables CSS for History Table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-danger">Riwayat Blacklist Vendor</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.blacklist-vendor') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Data Vendor Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Data Vendor (Blacklisted)</h3>
                        </div>
                        <div class="card-body">
                            <!-- Nama Vendor -->
                            <div class="mb-3">
                                <label class="form-label">Nama Vendor</label>
                                <input type="text" class="form-control" value="PT. Blacklist Abadi" readonly>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" rows="3"
                                    readonly>Jl. Masalah No. 99, Cilegon, Banten</textarea>
                            </div>

                            <!-- Nama PIC & No Handphone -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama PIC</label>
                                    <input type="text" class="form-control" value="Budi Masalah" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">No. Handphone</label>
                                    <input type="text" class="form-control" value="0866-6666-6666" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="button" class="btn btn-success" id="btnUnblacklist">
                                <i class="bi bi-check-circle"></i> Buka Blacklist
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History / Log Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Riwayat Catatan & Perubahan</h3>
                        </div>
                        <div class="card-body">
                            <table id="tableHistoryBlacklistVendor" class="table table-bordered table-striped w-100">
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
                                        <td>01/01/2026 09:30</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-danger">Blacklist</span></td>
                                        <td>Vendor dimasukkan ke blacklist karena pelanggaran kontrak berat.</td>
                                    </tr>
                                    <tr>
                                        <td>15/12/2025 10:00</td>
                                        <td>Admin</td>
                                        <td><span class="badge bg-warning">Update</span></td>
                                        <td>Update data vendor sebelum blacklist.</td>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#tableHistoryBlacklistVendor').DataTable({
                "responsive": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "pageLength": 5
            });

            // Unblacklist Button Logic
            const btnUnblacklist = document.getElementById('btnUnblacklist');
            if (btnUnblacklist) {
                btnUnblacklist.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Konfirmasi Buka Blacklist',
                        text: 'Apakah anda yakin ingin membuka blacklist vendor ini?',
                        icon: 'warning',
                        html: `
                                <p class="text-muted mb-2 text-start">Silakan masukkan alasan buka blacklist:</p>
                                <textarea id="swal-input-reason" class="form-control" rows="3" placeholder="Contoh: Masa sanksi telah berakhir..."></textarea>
                            `,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Buka Blacklist',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#198754', // Green for success/restore
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
                                text: 'Blacklist vendor berhasil dibuka.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Optional: Redirect or update UI
                                window.location.href = "{{ route('user.blacklist-vendor') }}";
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush