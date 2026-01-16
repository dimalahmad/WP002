@extends('layouts.admin')

@section('title', 'Tambah Detail Jenis Pekerjaan Berbahaya Baru')

@push('styles')

    <style>
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Tambah Detail Jenis Pekerjaan Berbahaya Baru</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('hse.master-ikb') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Main Card -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Detail Jenis Pekerjaan Berbahaya</h3>
                </div>

                <form action="" method="POST" id="formMasterIKB">
                    <div class="card-body">
                        <!-- Nama Pekerjaan -->
                        <div class="mb-4">
                            <label for="namaPekerjaan" class="form-label fw-bold">Nama Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="namaPekerjaan" name="nama_pekerjaan"
                                placeholder="Masukkan Nama Pekerjaan" required>
                        </div>

                        <div class="row">
                            <!-- Kolom Kiri: Alat Pelindung Diri (APD) -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-none border">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title fw-bold mb-0">Alat Pelindung Diri</h5>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            // Daftar APD
                                            $apds = [
                                                'Helmet',
                                                'Safety Shoes',
                                                'Sarung Tangan',
                                                'Kaca Mata Safety',
                                                'Masker',
                                                'Pelindung Wajah',
                                                'Body Harnest',
                                                'Kedok Las',
                                                'Air Line Respirator',
                                                'Breathing Apparatus',
                                                'Baju Tahan Panas'
                                            ];
                                        @endphp
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($apds as $apd)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $apd }}"
                                                        id="apd_{{ Str::slug($apd) }}">
                                                    <label class="form-check-label" for="apd_{{ Str::slug($apd) }}">
                                                        {{ $apd }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom Kanan: Pengaman -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-none border">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title fw-bold mb-0">Pengamanan</h5>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            // Daftar Pengaman
                                            $pengamans = [
                                                'Isolasi Power Supply',
                                                'Hydr. System Off',
                                                'Bekas Gas Beracun',
                                                'Tag Out',
                                                'Log Out',
                                                'APAR',
                                                'Hydrant',
                                                'Safety Line',
                                                'Lampu Penerangan DC 50 Volt'
                                            ];
                                        @endphp
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($pengamans as $pengaman)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $pengaman }}"
                                                        id="pengaman_{{ Str::slug($pengaman) }}">
                                                    <label class="form-check-label" for="pengaman_{{ Str::slug($pengaman) }}">
                                                        {{ $pengaman }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary" id="btnSimpan">
                            <i class="bi bi-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Verifikasi Simpan Data
            const btnSimpan = document.getElementById('btnSimpan');
            const inputNamaPekerjaan = document.getElementById('namaPekerjaan');

            if (btnSimpan) {
                btnSimpan.addEventListener('click', function () {
                    const namaPekerjaan = inputNamaPekerjaan.value.trim();

                    // Validasi: Cek jika nama pekerjaan kosong
                    if (!namaPekerjaan) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Jenis Pekerjaan tidak bisa ditambahkan karena Data Kosong.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33',
                        });
                        return;
                    }

                    // Tampilkan Konfirmasi Simpan
                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Untuk menyimpan data ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Simpan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Simulasi Berhasil Simpan
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data Jenis Pekerjaan Berbahaya berhasil disimpan.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('hse.master-ikb') }}";
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush