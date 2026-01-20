@extends('layouts.admin')

@section('title', 'Master OS')

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
                    <h3 class="mb-0 fw-bold">Master OS</h3>
                </div>
                <div class="col-sm-6 text-end">

                    <a href="{{ route('user.master-os.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah OS Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Database Seluruh Karyawan OS</h3>
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
                    <table id="tableMasterOS" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Golongan Darah</th>
                                <th>Tanggal Berakhir</th>
                                <th>No. Handphone</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $index => $emp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $emp->name }}</td>
                                    <td>{{ $emp->nik }}</td>
                                    <td>{{ $emp->gender }}</td>
                                    <td>{{ $emp->blood_type }}</td>
                                    <td>-</td> <!-- Tanggal Berakhir belum ada di DB -->
                                    <td>{{ $emp->address ?? '-' }}</td> <!-- Placeholder Phone diganti Address sementara -->
                                    <td class="text-center">
                                        @if($emp->is_blacklisted)
                                            <span class="badge bg-danger">Blacklisted</span>
                                        @else
                                            <span class="badge bg-success">Active</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Grup Tombol Aksi -->
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('user.master-os.history') }}" class="btn btn-primary"
                                                title="Detail"><i class="bi bi-eye"></i></a>
                                            <!-- Tombol Edit belum diimplementasi -->
                                            <!-- Edit button removed as per request -->
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data pegawai belum tersedia.</td>
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
    <!-- jQuery (Wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tableMasterOS').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 5,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "previous": "Previous",
                        "next": "Next"
                    }
                }
            });
        });
    </script>
@endpush