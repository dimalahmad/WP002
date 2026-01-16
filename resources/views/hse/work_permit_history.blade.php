@extends('layouts.admin')

@section('title', 'History Work Permit (HSE)')

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
                    <h3 class="mb-0 fw-bold">History Work Permit</h3>
                    <p class="text-muted mb-0">Riwayat Work Permit yang telah diproses HSE</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('hse.work-permit-hse') }}" class="btn btn-secondary">
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
                    <h3 class="card-title">Log History</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" title="Filter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tableHistoryHSE" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                <th>No. Dokumen WP</th>
                                <th>No. Izin Kerja Berbahaya</th>
                                <th>Nama Pemohon</th>
                                <th>Perusahaan</th>
                                <th>Jenis Pekerjaan (Safety)</th>
                                <th>Tanggal</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Data Riwayat Dummy
                                $history = [
                                    [
                                        'id' => 201,
                                        'doc_no' => 'WP-2023-099',
                                        'applicant' => 'Joko Widodo',
                                        'company' => 'PT. Adhi Karya',
                                        'safety_type' => 'Pekerjaan Listrik',
                                        'date' => '2023-12-25',
                                        'status' => 'Active'
                                    ],
                                    [
                                        'id' => 202,
                                        'doc_no' => 'WP-2023-098',
                                        'applicant' => 'Susilo Bambang',
                                        'company' => 'PT. Waskita',
                                        'safety_type' => 'Kerja Panas',
                                        'date' => '2023-12-24',
                                        'status' => 'Inactive'
                                    ],
                                    [
                                        'id' => 203,
                                        'doc_no' => 'WP-2023-098',
                                        'applicant' => 'Susilo Bambang',
                                        'company' => 'PT. Waskita',
                                        'safety_type' => 'Bekerja di Ketinggian',
                                        'date' => '2023-12-24',
                                        'status' => 'Active'
                                    ]
                                ];
                            @endphp

                            @foreach($history as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $item['doc_no'] }}</td>
                                    <td class="fw-bold text-primary">
                                        @php
                                            $code = match ($item['safety_type']) {
                                                'Kerja Panas' => 'KP',
                                                'Bekerja di Ketinggian' => 'K',
                                                'Pekerjaan Listrik' => 'L',
                                                'Memasuki Ruang Terbatas' => 'RT',
                                                default => 'GEN'
                                            };
                                            echo $item['doc_no'] . '/' . $code . '/01';
                                        @endphp
                                    </td>
                                    <td>{{ $item['applicant'] }}</td>
                                    <td>{{ $item['company'] }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-shield-check me-1"></i> {{ $item['safety_type'] }}
                                        </span>
                                    </td>
                                    <td>{{ $item['date'] }}</td>
                                    <td class="text-center">
                                        @if($item['status'] == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hse.work_permit.detail', ['id' => $item['id'], 'type' => $item['safety_type'], 'status' => $item['status']]) }}"
                                            class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
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
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tableHistoryHSE').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pageLength": 10
            });
        });
    </script>
@endpush