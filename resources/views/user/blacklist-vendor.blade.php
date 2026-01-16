@extends('layouts.admin')

@section('title', 'Blacklist Vendor')

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
                    <h3 class="mb-0 fw-bold text-danger">Blacklist Vendor</h3>
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
            <div class="card card-outline card-danger shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Daftar Vendor Blacklist</h3>
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
                    <table id="tableBlacklistVendor" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama Vendor</th>
                                <th>Nama PIC</th>
                                <th>No. Handphone</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $blacklisted = [];
                                $vendorNames = [
                                    'PT. Blacklist Abadi',
                                    'CV. Bermasalah Terus',
                                    'PT. Vendor Sanksi',
                                    'CV. Gagal Kontrak',
                                    'PT. Data Palsu',
                                    'CV. Kinerja Buruk',
                                    'PT. Tidak Profesional',
                                    'CV. Langgar Aturan',
                                    'PT. Banned Permanen',
                                    'CV. Suspensi Sementara'
                                ];

                                for ($i = 0; $i < 10; $i++) {
                                    $blacklisted[] = [
                                        'vendor' => $vendorNames[$i] ?? 'Vendor Blacklist ' . ($i + 1),
                                        'pic' => 'PIC ' . ($i + 1),
                                        'phone' => '0866-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                                        'status' => 'Blacklist',
                                    ];
                                }
                            @endphp

                            @foreach($blacklisted as $index => $v)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $v['vendor'] }}</td>
                                    <td>{{ $v['pic'] }}</td>
                                    <td>{{ $v['phone'] }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">Blacklist</span>
                                    </td>
                                    <td class="text-center">
                                        <!-- Action Buttons Group -->
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('user.blacklist-vendor.history') }}" class="btn btn-success text-white" title="History"><i
                                                    class="bi bi-clock-history"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugins -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tableBlacklistVendor').DataTable({
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