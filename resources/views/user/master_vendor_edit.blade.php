@extends('layouts.admin')

@section('title', 'Edit Vendor')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
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
                                        <label class="form-label">Nama PIC <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputNamaPIC" value="Budi Santoso"
                                            name="nama_pic" required>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('formEditVendor');
            const inputNamaVendor = document.getElementById('inputNamaVendor');
            const inputNamaPIC = document.getElementById('inputNamaPIC');
            const btnBlacklist = document.getElementById('btnBlacklist');

            // Blacklist Button Logic
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
                            // Success Notification
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Vendor berhasil ditambahkan ke blacklist.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                // Optional: Redirect or update UI
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
                        confirmButtonColor: '#ffc107', // Warning color
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