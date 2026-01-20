@extends('layouts.admin')

@section('title', 'Master Work Permit')

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
                    <h3 class="mb-0 fw-bold">Master Work Permit</h3>
                </div>
                <div class="col-sm-6 text-end">

                    <a href="{{ route('user.work-permit.history') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-clock-history"></i> History
                    </a>
                    <a href="{{ route('user.work-permit.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Work Permit Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Database Seluruh Work Permit</h3>
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
                    <table id="tableWorkPermit" class="table table-bordered table-hover align-middle w-100">
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
                        <tbody>
                            @forelse($myWps as $index => $wp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $wp->doc_no }}</td>
                                    <td>{{ $wp->vendor->name ?? 'User' }}</td>
                                    <td>
                                        <span class="badge bg-primary">Jasa Rutin</span>
                                        <!-- Hardcode sementara atau ambil dari relasi -->
                                    </td>
                                    <td>{{ $wp->location }}</td>
                                    <td>{{ $wp->start_date->format('d/m/Y') }}</td>
                                    <td>{{ $wp->end_date->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $wp->employees->count() ?? 0 }}</td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = match ($wp->status) {
                                                'active' => 'bg-success',
                                                'scheduled' => 'bg-primary',
                                                'waiting_hse' => 'bg-info text-dark',
                                                'waiting_corsec' => 'bg-warning text-dark',
                                                'rejected' => 'bg-danger',
                                                'expired' => 'bg-secondary',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $wp->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <!-- Grup Tombol Aksi -->
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('user.work-permit.detail', $wp->id) }}" class="btn btn-primary"
                                                title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Belum ada pengajuan Work Permit.</td>
                                </tr>
                            @endforelse
                        </tbody>
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
            $('#tableWorkPermit').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 5, // Tampilkan paginasi dengan data yang cukup
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