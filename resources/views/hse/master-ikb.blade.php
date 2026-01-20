@extends('layouts.admin')

@section('title', 'Master Jenis Pekerjaan Berbahaya')

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
                    <h3 class="mb-0 fw-bold">Master Jenis Pekerjaan Berbahaya</h3>
                    <p class="text-muted mb-0">Database Jenis Pekerjaan Berbahaya yang dipakai</p>
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-primary" id="btnTambahIKB">
                        <i class="bi bi-plus-lg"></i> Tambah Data Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">List Data Jenis Pekerjaan Berbahaya</h3>
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
                    <table id="tableMasterIKB" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                <th>Nama Jenis Pekerjaan Berbahaya</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ikbs as $index => $ikb)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $ikb->name }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('hse.master-ikb.edit', $ikb->id) }}"
                                            class="btn btn-warning btn-sm text-white" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data jenis pekerjaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
            $('#tableMasterIKB').DataTable({
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

            // Handle Add Button
            $('#btnTambahIKB').click(function () {
                window.location.href = "{{ route('hse.master-ikb.create') }}";
            });
        });
    </script>
@endpush