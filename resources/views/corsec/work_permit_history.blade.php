@extends('layouts.admin')

@section('title', 'History Work Permit (Corsec)')

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
                    <h3 class="mb-0 fw-bold">History Work Permit (Corsec)</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('corsec.work-permit-masuk') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Arsip Work Permit (Waiting HSE/Active/Expired)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="Filter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button type="button" class="btn btn-tool" title="Export">
                            <i class="bi bi-cloud-download"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableHistoryCorsec" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nomer WP</th>
                                <th>Nama Vendor</th>
                                <th>STA</th>
                                <th>Area</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Berakhir</th>
                                <th>Jumlah Pekerja</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $vendors = [
                                    'PT. Teknologi Maju',
                                    'PT. Baja Steel',
                                    'CV. Maju Jaya',
                                    'PT. Cilegon Eng',
                                    'CV. Baratech',
                                    'PT. Global Supply',
                                    'PT. Sarana Utama',
                                    'CV. Teknik Mandiri'
                                ];
                                $staTypes = ['Jasa Murni', 'Jasa Rutin', 'KP/Magang'];
                                $areas = ['Area Pabrik 1', 'Area Pabrik 2', 'Area Kantor Pusat', 'Area Gudang', 'Area Dermaga'];
                                // Corsec History shows what they have already processed
                                // Waiting HSE (monitoring), Active, Expired
                                $statuses = ['Waiting HSE', 'Active', 'Expired'];

                                $workPermits = [];
                                for ($i = 0; $i < 20; $i++) {
                                    $workPermits[] = [
                                        'no_wp' => 'WP-2026-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                                        'vendor' => $vendors[array_rand($vendors)],
                                        'sta' => $staTypes[array_rand($staTypes)],
                                        'area' => $areas[array_rand($areas)],
                                        'start_date' => date('d/m/Y', strtotime('-' . rand(10, 50) . ' days')),
                                        'end_date' => date('d/m/Y', strtotime('+' . rand(5, 30) . ' days')),
                                        'workers_count' => rand(5, 50),
                                        'status' => $statuses[array_rand($statuses)],
                                    ];
                                }
                            @endphp

                            @foreach($workPermits as $index => $wp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $wp['no_wp'] }}</td>
                                    <td>{{ $wp['vendor'] }}</td>
                                    <td>
                                        @if($wp['sta'] == 'Jasa Murni')
                                            <span class="badge bg-info">{{ $wp['sta'] }}</span>
                                        @elseif($wp['sta'] == 'Jasa Rutin')
                                            <span class="badge bg-primary">{{ $wp['sta'] }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ $wp['sta'] }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $wp['area'] }}</td>
                                    <td>{{ $wp['start_date'] }}</td>
                                    <td>{{ $wp['end_date'] }}</td>
                                    <td class="text-center">{{ $wp['workers_count'] }}</td>
                                    <td class="text-center">
                                        @if($wp['status'] == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($wp['status'] == 'Waiting HSE')
                                            <span class="badge bg-info text-dark">Waiting HSE</span>
                                        @else
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Action Buttons Group -->
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('corsec.work-permit.detail', ['id' => $index + 200]) }}?status={{ $wp['status'] }}"
                                                class="btn btn-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
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
            $('#tableHistoryCorsec').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 10,
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