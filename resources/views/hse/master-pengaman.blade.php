@extends('layouts.admin')

@section('title', 'Master Pengaman')

@push('styles')
    <!-- DataTables CSS -->
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
                    <h3 class="mb-0 fw-bold">Master Pengaman</h3>
                    <p class="text-muted mb-0">Database Pengaman yang dipakai</p>
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-primary" id="btnTambahPengaman">
                        <i class="bi bi-plus-lg"></i> Tambah Pengaman Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">List Data Pengaman</h3>
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
                    <table id="tableMasterPengaman" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                <th>Nama Pengaman</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pengamans = [
                                    'Isolasi power supply',
                                    'Hydr. system off',
                                    'Bekas gas beracun',
                                    'Tag out',
                                    'Log out',
                                    'APAR',
                                    'Hydrant',
                                    'Safety Line',
                                    'Lampu penerangan DC 50 Volt'
                                ];
                            @endphp

                            @foreach($pengamans as $index => $pengaman)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $pengaman }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm text-white btn-edit-pengaman"
                                            data-name="{{ $pengaman }}" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Pengaman -->
    <div class="modal fade" id="modalPengaman" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalPengamanLabel">Tambah Pengaman Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPengaman">
                        <div class="mb-3">
                            <label for="inputNamaPengaman" class="form-label">Nama Pengaman</label>
                            <input type="text" class="form-control" id="inputNamaPengaman" placeholder="Contoh: APAR"
                                required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSavePengaman">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // DataTables
            $('#tableMasterPengaman').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "paginate": { "previous": "Previous", "next": "Next" }
                },
                "columnDefs": [{ "orderable": false, "targets": 2 }]
            });

            // Modal Logic
            const modalElement = document.getElementById('modalPengaman');
            const modal = new bootstrap.Modal(modalElement);
            const modalLabel = document.getElementById('modalPengamanLabel');
            const inputNama = document.getElementById('inputNamaPengaman');
            let isEditMode = false;

            // Handle Add Button
            $('#btnTambahPengaman').click(function () {
                isEditMode = false;
                modalLabel.innerText = 'Tambah Pengaman Baru';
                // Reset Color to Primary
                $('.modal-header').removeClass('bg-warning').addClass('bg-primary');
                // Reset Close Button to white
                $('.btn-close').addClass('btn-close-white');

                inputNama.value = '';
                modal.show();
            });

            // Handle Edit Button (Event Delegation for Dynamic Tables)
            $('#tableMasterPengaman').on('click', '.btn-edit-pengaman', function () {
                isEditMode = true;
                const currentName = $(this).data('name');
                modalLabel.innerText = 'Edit Data Pengaman';
                // Set Color to Warning
                $('.modal-header').removeClass('bg-primary').addClass('bg-warning');
                // Reset Close Button to default
                $('.btn-close').removeClass('btn-close-white');

                inputNama.value = currentName;
                modal.show();
            });

            // Handle Save
            $('#btnSavePengaman').click(function () {
                const nameCheck = inputNama.value.trim();

                if (!nameCheck) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Nama Pengaman tidak boleh kosong!',
                    });
                    return;
                }

                // Confirm Alert
                Swal.fire({
                    title: isEditMode ? 'Simpan Perubahan?' : 'Tambah Pengaman Baru?',
                    text: isEditMode ? "Data Pengaman akan diperbarui." : "Pastikan data Pengaman sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Simulate Success
                        modal.hide();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: isEditMode ? 'Data Pengaman berhasil diperbarui.' : 'Data Pengaman berhasil ditambahkan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            // In real app, reload or update table here
                            // location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endpush