@extends('layouts.admin')

@section('title', 'Tambah Vendor Baru')

@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Tambah Vendor Baru</h3>
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
            <form id="formTambahVendor" action="#" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Data Vendor</h3>
                            </div>
                            <div class="card-body">
                                <!-- Nama Vendor -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Vendor <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="inputNamaVendor"
                                        placeholder="Masukkan Nama Vendor" name="nama_vendor" required>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan Alamat Lengkap"
                                        name="alamat"></textarea>
                                </div>

                                <!-- Nama PIC & No Handphone -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama PIC <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="inputNamaPIC"
                                            placeholder="Masukkan Nama PIC" name="nama_pic" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">No. Handphone</label>
                                        <input type="text" class="form-control" placeholder="Contoh: 08123456789"
                                            name="no_hp">
                                    </div>
                                </div>

                                <!-- Catatan -->
                                <div class="mb-3">
                                    <label class="form-label">Catatan</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan Catatan Tambahan"
                                        name="catatan"></textarea>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('formTambahVendor');
            const inputNamaVendor = document.getElementById('inputNamaVendor');
            const inputNamaPIC = document.getElementById('inputNamaPIC');

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const namaVendor = inputNamaVendor ? inputNamaVendor.value.trim() : '';
                    const namaPIC = inputNamaPIC ? inputNamaPIC.value.trim() : '';

                    // 1. Validation Check (Empty)
                    if (!namaVendor || !namaPIC) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Data Vendor tidak bisa ditambahkan karena Nama Vendor atau Nama PIC kosong.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    // 2. Confirmation Dialog
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Untuk menyimpan data vendor ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // 3. Success Simulation
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Vendor berhasil ditambahkan.',
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