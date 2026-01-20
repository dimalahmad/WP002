@extends('layouts.admin')

@section('title', 'Edit Detail Jenis Pekerjaan Berbahaya')

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
                    <h3 class="mb-0 fw-bold">Edit Detail Jenis Pekerjaan Berbahaya</h3>
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
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">Edit Jenis Pekerjaan Berbahaya</h3>
                </div>

                <form action="{{ route('hse.master-ikb.update', $ikb->id) }}" method="POST" id="formMasterIKB">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <!-- Nama Pekerjaan -->
                        <div class="mb-4">
                            <label for="namaPekerjaan" class="form-label fw-bold">Nama Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="namaPekerjaan" name="nama_pekerjaan"
                                placeholder="Masukkan Nama Pekerjaan" value="{{ old('nama_pekerjaan', $ikb->name) }}" required>
                        </div>

                        <div class="row">
                            <!-- Kolom Kiri: Alat Pelindung Diri (APD) -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-none border">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title fw-bold mb-0">Alat Pelindung Diri</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($apds as $apd)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="apd[]" value="{{ $apd->name }}"
                                                        id="apd_{{ $apd->id }}"
                                                        {{ in_array($apd->name, $ikb->recommended_apd ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="apd_{{ $apd->id }}">
                                                        {{ $apd->name }}
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
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($safeties as $safety)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="pengaman[]" value="{{ $safety->name }}"
                                                        id="safety_{{ $safety->id }}"
                                                        {{ in_array($safety->name, $ikb->recommended_safety ?? []) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="safety_{{ $safety->id }}">
                                                        {{ $safety->name }}
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
                        <button type="submit" class="btn btn-warning text-white" id="btnSimpan">
                            <i class="bi bi-save"></i> Simpan Perubahan
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
        document.getElementById('formMasterIKB').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Pastikan data sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
