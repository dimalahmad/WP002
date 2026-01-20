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
                        <tbody>
                            @forelse($historyWps as $index => $wp)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $wp->doc_no }}</td>
                                    <td class="fw-bold text-primary">
                                        @php
                                            $code = match ($wp->work_type) {
                                                'Kerja Panas' => 'KP',
                                                'Bekerja di Ketinggian' => 'K',
                                                'Pekerjaan Listrik' => 'L',
                                                'Memasuki Ruang Terbatas' => 'RT',
                                                default => 'GEN'
                                            };
                                            echo $wp->doc_no . '/' . $code . '/01';
                                        @endphp
                                    </td>
                                    <td>{{ $wp->vendor->pic_name ?? 'User' }}</td>
                                    <td>{{ $wp->vendor->name }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-shield-check me-1"></i> {{ $wp->work_type }}
                                        </span>
                                    </td>
                                    <td>{{ $wp->updated_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if($wp->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($wp->status == 'expired')
                                            <span class="badge bg-secondary">Expired</span>
                                        @elseif($wp->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($wp->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hse.work_permit.detail', $wp->id) }}"
                                            class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada riwayat Work Permit.</td>
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