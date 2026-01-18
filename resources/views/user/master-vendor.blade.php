@extends('layouts.admin')

@section('title', 'Master Vendor')

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
                    <h3 class="mb-0 fw-bold">Master Vendor</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.blacklist-vendor') }}" class="btn btn-danger me-2">
                        <i class="bi bi-slash-circle"></i> Blacklist
                    </a>
                    <a href="{{ route('user.master-vendor.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Vendor Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Database Seluruh Vendor</h3>
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
                    <table id="tableMasterVendor" class="table table-bordered table-hover align-middle w-100">
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
                                $vendorNames = [
                                    'PT. Teknologi Indonesia',
                                    'PT. Baja Steel Indonesia',
                                    'CV. Maju Jaya Abadi',
                                    'PT. Cilegon Engineering',
                                    'CV. Baratech Service',
                                    'PT. Global Supply Chain',
                                    'PT. Sarana Konstruksi Utama',
                                    'CV. Teknik Mandiri',
                                    'PT. Delta Safety Solution',
                                    'CV. Berkah Cahaya',
                                    'PT. Inti Karya Semesta',
                                    'PT. Pilar Beton Perkasa',
                                    'CV. Elektronika Dasar',
                                    'PT. Mega Trans Logistik',
                                    'CV. Sumber Makmur',
                                    'PT. Buana Citra Konsultan',
                                    'CV. Mitra Sejahtera',
                                    'PT. Harapan Bangsa',
                                    'CV. Karya Duta',
                                    'PT. Universal Trading',
                                    'PT. Galangan Samudera',
                                    'CV. Arta Graha',
                                    'PT. Sentosa Abadi',
                                    'CV. Bintang Mas',
                                    'PT. Anugerah Teknik',
                                    'CV. Multi Sarana',
                                    'PT. Prima Daya Energy',
                                    'CV. Tunas Harapan',
                                    'PT. Wira Sakti',
                                    'CV. Kencana Alam'
                                ];

                                $vendors = [];
                                for ($i = 0; $i < 30; $i++) {
                                    $statusList = ['Active', 'Inactive'];

                                    $vendors[] = [
                                        'vendor' => $vendorNames[$i] ?? 'Vendor ' . ($i + 1),
                                        'pic' => 'PIC ' . explode(' ', $vendorNames[$i] ?? 'Vendor')[1],
                                        'phone' => '08' . rand(11, 19) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999),
                                        'status' => $statusList[array_rand($statusList)],
                                    ];
                                }
                            @endphp

                            @foreach($vendors as $index => $v)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $v['vendor'] }}</td>
                                    <td>{{ $v['pic'] }}</td>
                                    <td>{{ $v['phone'] }}</td>
                                    <td class="text-center">
                                        @if($v['status'] == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Grup Tombol Aksi -->
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('user.master-vendor.history') }}" class="btn btn-primary"
                                                title="Detail"><i class="bi bi-eye"></i></a>
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
    <!-- jQuery (Wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tableMasterVendor').DataTable({
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