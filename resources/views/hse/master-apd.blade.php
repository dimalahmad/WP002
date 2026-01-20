@extends('layouts.admin')

@section('title', 'Master APD')

@push('styles')
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select {
            padding-right: 2rem !important;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Master APD</h3>
                    <p class="text-muted mb-0">Database APD yang dipakai</p>
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-primary" id="btnTambahAPD">
                        <i class="bi bi-plus-lg"></i> Tambah APD Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">List Data APD</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="Filter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button type="button" class="btn btn-tool" title="Export">
                            <i class="bi bi-cloud-download"></i> Export
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableMasterAPD" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                <th>Nama APD</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($apds as $index => $apd)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $apd->name }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm text-white btn-edit-apd" 
                                            data-id="{{ $apd->id }}" data-name="{{ $apd->name }}" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data APD.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit APD -->
    <div class="modal fade" id="modalAPD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalAPDLabel">Tambah APD Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAPD" action="{{ route('hse.master-apd.store') }}" method="POST">
                        @csrf
                        <div id="method-container"></div>
                        <input type="hidden" name="type" value="apd">
                        <div class="mb-3">
                            <label for="inputNamaAPD" class="form-label">Nama APD</label>
                            <input type="text" class="form-control" id="inputNamaAPD" name="name"
                                placeholder="Contoh: Safety Helmet" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSaveAPD">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // DataTables
            $('#tableMasterAPD').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 10,
                // ... rest of datatable config
            });

            // Logika Modal
            const modalElement = document.getElementById('modalAPD');
            const modal = new bootstrap.Modal(modalElement);
            const modalLabel = document.getElementById('modalAPDLabel');
            const inputNama = document.getElementById('inputNamaAPD');
            let isEditMode = false;
            const formAPD = document.getElementById('formAPD');
            const methodContainer = document.getElementById('method-container');

            // Base Routes
            const storeRoute = "{{ route('hse.master-apd.store') }}";
            const updateRouteTemplate = "{{ route('hse.master-apd.update', ':id') }}";

            // Tangani Tombol Tambah
            $('#btnTambahAPD').click(function () {
                isEditMode = false;
                modalLabel.innerText = 'Tambah APD Baru';
                $('.modal-header').removeClass('bg-warning').addClass('bg-primary');
                $('.btn-close').addClass('btn-close-white');
                
                inputNama.value = '';
                formAPD.action = storeRoute;
                methodContainer.innerHTML = '';
                
                modal.show();
            });

            // Tangani Tombol Edit
            $(document).on('click', '.btn-edit-apd', function () {
                isEditMode = true;
                const id = $(this).data('id');
                const currentName = $(this).data('name');
                
                modalLabel.innerText = 'Edit Data APD';
                $('.modal-header').removeClass('bg-primary').addClass('bg-warning');
                $('.btn-close').removeClass('btn-close-white');

                inputNama.value = currentName;
                formAPD.action = updateRouteTemplate.replace(':id', id);
                methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';

                modal.show();
            });

            // Tangani Simpan
            $('#btnSaveAPD').click(function () {
                const nameCheck = inputNama.value.trim();

                if (!nameCheck) {
                    Swal.fire('Gagal', 'Nama APD tidak boleh kosong!', 'error');
                    return;
                }

                // Alert Konfirmasi
                Swal.fire({
                    title: isEditMode ? 'Simpan Perubahan?' : 'Tambah APD Baru?',
                    text: isEditMode ? "Data APD akan diperbarui." : "Pastikan data APD sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formAPD').submit();
                    }
                });
            });
        });
    </script>
@endpush