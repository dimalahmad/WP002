@extends('layouts.admin')

@section('title', 'Work Permit Masuk (HSE)')

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
                    <h3 class="mb-0 fw-bold">Work Permit Masuk</h3>
                    <p class="text-muted mb-0">Daftar Work Permit yang menunggu review HSE</p>
                </div>
                <div class="col-sm-6 text-end">
                    <!-- Tombol Riwayat -->
                    <a href="{{ route('hse.work_permit_history') }}" class="btn btn-secondary">
                        <i class="bi bi-clock-history"></i> History
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">List Work Permit Masuk</h3>
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
                    <table id="tableWPHSE" class="table table-bordered table-hover align-middle w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" class="text-center">No</th>
                                <th>No. Dokumen WP</th>
                                <th>No. Izin Kerja Berbahaya</th>
                                <th>Nama Pemohon</th>
                                <th>Perusahaan</th>
                                <th>Jenis Pekerjaan (Safety Induction)</th>
                                <th>Tanggal Pengajuan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Simulasi Data Dummy
                                $wps = [
                                    [
                                        'id' => 101,
                                        'doc_no' => 'WP-2024-001',
                                        'applicant' => 'Budi Santoso',
                                        'company' => 'PT. Maju Jaya',
                                        // WP ini memiliki BEBERAPA jenis induksi
                                        'safety_types' => ['Kerja Panas', 'Bekerja di Ketinggian'],
                                        'date' => '2024-01-14',
                                        'status' => 'Waiting HSE'
                                    ],
                                    [
                                        'id' => 102,
                                        'doc_no' => 'WP-2024-002',
                                        'applicant' => 'Siti Aminah',
                                        'company' => 'PT. Baja Indonesia',
                                        'safety_types' => ['Pekerjaan Listrik'],
                                        'date' => '2024-01-15',
                                        'status' => 'Waiting HSE'
                                    ],
                                ];

                                $counter = 1;
                            @endphp

                            @foreach($wps as $wp)
                                @if($wp['status'] == 'Waiting HSE')
                                    @foreach($wp['safety_types'] as $type)
                                        <tr>
                                            <td class="text-center">{{ $counter++ }}</td>
                                            <td class="fw-bold">{{ $wp['doc_no'] }}</td>
                                            <td class="fw-bold text-primary">
                                                @php
                                                    $code = match ($type) {
                                                        'Kerja Panas' => 'KP',
                                                        'Bekerja di Ketinggian' => 'K',
                                                        'Pekerjaan Listrik' => 'L',
                                                        'Memasuki Ruang Terbatas' => 'RT',
                                                        default => 'GEN'
                                                    };
                                                    echo $wp['doc_no'] . '/' . $code . '/01';
                                                @endphp
                                            </td>
                                            <td>{{ $wp['applicant'] }}</td>
                                            <td>{{ $wp['company'] }}</td>
                                            <td>
                                                <span class="badge bg-info text-dark">
                                                    <i class="bi bi-exclamation-triangle me-1"></i> {{ $type }}
                                                </span>
                                            </td>
                                            <td>{{ $wp['date'] }}</td>
                                            <td class="text-center">
                                                <span class="badge bg-warning text-dark">Menunggu Review</span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('hse.work_permit.detail', ['id' => $wp['id'], 'type' => $type, 'status' => 'Waiting HSE']) }}"
                                                    class="btn btn-primary btn-sm" title="Lihat Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
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
                    $('#tableWPHSE').DataTable({
                        "responsive": true,
                        "lengthChange": true,
                        "autoWidth": false,
                        "pageLength": 10,
                        "pagingType": "simple_numbers",
                        "ordering": true, // Enable ordering as requested
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