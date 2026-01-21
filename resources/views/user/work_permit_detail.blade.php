@extends('layouts.admin')

@section('title', 'Detail Work Permit')

@push('styles')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Font for Signatures (Optional for text fallback, but we use images here) -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        .employee-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Peningkatan gaya formulir baca-saja */
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .form-select:disabled {
            background-color: #f8f9fa;
        }
    </style>
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
    @php
        // Tentukan status dari parameter query (prioritas) atau logika dummy berdasarkan ID
        $id = request()->route('id') ?? 1;
        $reqStatus = request('status');

        if ($reqStatus && in_array($reqStatus, ['Waiting Corsec', 'Waiting HSE', 'Active', 'Expired'])) {
            $status = $reqStatus;
        } else {
            $statuses = ['Waiting Corsec', 'Waiting HSE', 'Active', 'Expired'];
            $statusIndex = ($id - 1) % 4;
            $status = $statuses[$statusIndex] ?? 'Active';
        }

        $statusBadgeClass = match ($status) {
            'Waiting Corsec' => 'bg-warning text-dark',
            'Waiting HSE' => 'bg-info text-dark',
            'Active' => 'bg-success',
            'Scheduled' => 'bg-warning text-dark',
            'Expired' => 'bg-danger',
            default => 'bg-primary'
        };

        // Dummy Data - SIMULASI VENDOR BLACKLIST
        $vendor = 'PT. Teknologi Maju';
        $applicantName = 'Budi Santoso';
        $isVendorBlacklisted = true;
        $vendorLabelHtml = $isVendorBlacklisted
            ? $vendor . ' <span class="badge bg-danger ms-2"><i class="bi bi-exclamation-triangle-fill"></i> BLACKLISTED</span>'
            : $vendor . ' <span class="badge bg-success ms-2"><i class="bi bi-check-circle"></i> TERVERIFIKASI</span>';
        $area = 'Area Kantor Pusat';
        $sta = 'Jasa Rutin';
        $no_jo = 'JO-2023-001';
        $uraian = 'Pemeliharaan perangkat jaringan dan server di Gedung Utama.';

        // Head Dates
        $startDate = date('d F Y');
        $startTime = '08:00';
        $endDate = date('d F Y', strtotime('+3 days'));
        $endTime = '17:00';

        $startDateTime = $startDate . ' ' . $startTime;
        $endDateTime = $endDate . ' ' . $endTime;

        // Dummy Karyawan with Dates
        $employees = [
            ['name' => 'Andi Saputra', 'nik' => '1234567890123456', 'gender' => 'Laki-laki', 'blood' => 'O', 'is_blacklisted' => false, 'start' => $startDateTime, 'end' => $endDateTime],
            ['name' => 'Budi Santoso', 'nik' => '9876543210987654', 'gender' => 'Laki-laki', 'blood' => 'A', 'is_blacklisted' => false, 'start' => $startDateTime, 'end' => $endDateTime],
            ['name' => 'Citra Dewi', 'nik' => '4567891230123456', 'gender' => 'Perempuan', 'blood' => 'B', 'is_blacklisted' => false, 'start' => $startDateTime, 'end' => $endDateTime],
            ['name' => 'Dudung (Blacklist)', 'nik' => '9999999999999999', 'gender' => 'Laki-laki', 'blood' => 'AB', 'is_blacklisted' => true, 'start' => $startDateTime, 'end' => $endDateTime],
        ];
    @endphp

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Detail Work Permit</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-printer-fill me-1"></i> Cetak Dokumen
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button class="dropdown-item" onclick="printDocument('wp')"><i
                                        class="bi bi-file-earmark-text me-2"></i>Work Permit (User)</button></li>
                            <li>
                                @if(in_array($status, ['Active', 'Expired']))
                                    <button class="dropdown-item" onclick="printDocument('hse')"><i
                                            class="bi bi-shield-check me-2"></i>Bukti Safety Induction (HSE)</button>
                                @else
                                    <button class="dropdown-item disabled text-muted"><i class="bi bi-shield-x me-2"></i>Bukti
                                        Induction (Belum Tersedia)</button>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('user.work-permit') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- TRACKING TIMELINE (UNCHANGED) -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title fw-bold">Status Tracking</h5>
                </div>
                <div class="card-body pt-3 pb-2">
                    <div class="position-relative mb-2">
                        <div class="progress"
                            style="height: 4px; position: absolute; top: 25px; left: 5%; right: 5%; z-index: 1;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status == 'Expired' ? '100%' : ($status == 'Active' ? '100%' : ($status == 'Scheduled' ? '80%' : ($status == 'Waiting HSE' ? '40%' : ($status == 'Waiting Corsec' ? '20%' : '0%')))) }};"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Waiting Corsec', 'Waiting HSE', 'Scheduled', 'Active', 'Expired']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-file-earmark-plus fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Penerbitan<br>Work Permit</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 08:00</small>
                            </div>
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Waiting HSE', 'Scheduled', 'Active', 'Expired']) ? 'bg-success' : ($status == 'Waiting Corsec' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-building-check fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Verifikasi Corsec</span>
                                @if(in_array($status, ['Waiting HSE', 'Scheduled', 'Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 09:30</small>
                                @endif
                            </div>
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Scheduled', 'Active', 'Expired']) ? 'bg-success' : ($status == 'Waiting HSE' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-search fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Review HSE</span>
                                @if(in_array($status, ['Scheduled', 'Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 13:00</small>
                                @endif
                            </div>
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Active', 'Expired', 'Scheduled']) ? 'bg-success' : ($status == 'Scheduled' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Safety Induction</span>
                                @if(in_array($status, ['Active', 'Expired', 'Scheduled']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Selesai</small>
                                @endif
                            </div>

                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Active', 'Expired']) ? 'bg-success' : ($status == 'Scheduled' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-flag fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Full Access</span>
                                @if(in_array($status, ['Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">15 Jan 10:00</small>
                                @endif
                            </div>
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ $status == 'Expired' ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Selesai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL CONTENT: READ-ONLY -->

            <!-- SECTION 1: HEAD DATA (TOP - FULL WIDTH) -->
            <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0 ps-2">Data Head Work Permit</h5>
                </div>
                <div class="card-body pt-0">
                    <!-- Row 1: Vendor & Key Info -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small text-uppercase fw-bold letter-spacing-1 mb-1">Nama Vendor /
                                Instansi</label>
                            <div
                                class="p-3 bg-light rounded border-start border-3 {{ $isVendorBlacklisted ? 'border-danger' : 'border-success' }}">
                                <h5 class="fw-bold mb-0 text-dark">{{ $vendor }}</h5>
                                @if($isVendorBlacklisted)
                                    <div class="mt-1 text-danger small fw-bold"><i
                                            class="bi bi-exclamation-triangle-fill me-1"></i> VENDOR BLACKLISTED</div>
                                @else
                                    <div class="mt-1 text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i>
                                        Terverifikasi</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Details Grid -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Nomor Work Permit</label>
                            <div class="fw-bold text-dark fs-5">WP-2024-001</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Nomor JO (Jasa Rutin)</label>
                            <div class="fw-bold text-dark fs-5">{{ $no_jo }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Area Kerja</label>
                            <div class="fw-bold text-dark"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $area }}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">STA</label>
                            <div class="fw-bold text-dark"><span
                                    class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $sta }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Description & Hazards -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Uraian Pekerjaan</label>
                            <div class="p-3 bg-light rounded text-secondary h-100" style="border: 1px dashed #ced4da;">
                                {{ $uraian }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="text-muted small text-uppercase fw-bold mb-2">Jenis Pekerjaan (Safety
                                        Hazard)</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge border border-secondary text-secondary p-2"><i
                                                class="bi bi-check-lg"></i> Pekerjaan Listrik</span>
                                        <span class="badge border border-secondary text-secondary p-2"><i
                                                class="bi bi-check-lg"></i> Bekerja di Ketinggian</span>
                                        <span class="badge border border-light text-muted bg-light p-2 opacity-50">Ruang
                                            Terbatas</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small text-uppercase fw-bold mb-1">Jadwal Pekerjaan
                                        Utama</label>
                                    <div class="bg-white border rounded p-2">
                                        <div class="row">
                                            <div class="col-md-6 border-end">
                                                <span class="text-muted small d-block">Mulai:</span>
                                                <span class="fw-bold text-primary">{{ $startDateTime }}</span>
                                            </div>
                                            <div class="col-md-6">
                                                <span class="text-muted small d-block">Selesai:</span>
                                                <span class="fw-bold text-primary">{{ $endDateTime }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: EMPLOYEES TABLE (BOTTOM - FULL WIDTH) -->
            <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                <div
                    class="card-header bg-transparent border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0 ps-2">Daftar Personil ({{ count($employees) }})</h5>
                    <span class="badge bg-info text-dark">Total: {{ count($employees) }} Orang</span>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="tableEmployees" class="table table-bordered table-striped table-hover align-middle w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th width="20%">Nama Personil</th>
                                        <th width="15%">NIK</th>
                                        <th width="10%">Jenis Kelamin</th>
                                        <th width="10%" class="text-nowrap">Gol. Darah</th>
                                        <th width="15%">Mulai</th>
                                        <th width="15%">Selesai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employees as $index => $emp)
                                        <tr class="{{ $emp['is_blacklisted'] ? 'table-danger' : '' }}">
                                            <td class="text-center fw-bold text-secondary">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="fw-bold {{ $emp['is_blacklisted'] ? 'text-danger' : 'text-dark' }}">
                                                    {{ $emp['name'] }}</div>
                                                @if($emp['is_blacklisted'])
                                                    <span class="badge bg-danger">BLACKLISTED</span>
                                                @endif
                                            </td>
                                            <td class="font-monospace text-muted">{{ $emp['nik'] }}</td>
                                            <td class="text-muted">{{ $emp['gender'] }}</td>
                                            <td class="text-center text-muted fw-bold">{{ $emp['blood'] }}</td>
                                            <td class="text-muted">{{ $emp['start'] }}</td>
                                            <td class="text-muted">{{ $emp['end'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <!-- Modal Cetak ID Card -->
                <div class="modal fade" id="idCardModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center pt-0">
                                <!-- Disesuaikan dengan rasio ID Card 12cm x 8cm, kira-kira 453px x 302px untuk pratinjau layar -->
                                <div id="printableIdCard"
                                    class="d-inline-block text-start border border-dark border-2 position-relative shadow-sm"
                                    style="width: 12cm; height: 8cm; background: #fff; overflow: hidden; padding: 0;">
                                    <!-- Pembungkus Konten -->
                                    <div class="d-flex flex-column h-100 p-2">
                                        <!-- Header: Logo & Judul -->
                                        <div
                                            class="d-flex align-items-center justify-content-center pt-2 pb-2 border-bottom border-dark">
                                            <img src="https://via.placeholder.com/150x50?text=LOGO+PERUSAHAAN" alt="Logo"
                                                style="height: 40px; margin-right: 15px;">
                                            <div class="text-center" style="line-height: 1.1;">
                                                <span class="d-block fw-bold text-uppercase"
                                                    style="font-size: 11pt; letter-spacing: 0.5px;">KARTU TANDA PENGENAL</span>
                                                <span class="d-block fw-bold text-uppercase" style="font-size: 10pt;">PRAKTEK
                                                    KERJA /
                                                    MAGANG</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-grow-1 px-3 py-2">
                                            <!-- Kolom Kiri: Tabel Info -->
                                            <div class="flex-grow-1 pe-3 d-flex align-items-center" style="font-size: 10pt;">
                                                <table class="table table-borderless table-sm mb-0 align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <td class="p-0 pb-1 text-nowrap" style="width: 35%;">Nama</td>
                                                            <td class="p-0 pb-1 text-center" style="width: 5%;">:</td>
                                                            <td class="p-0 pb-1 fw-bold text-uppercase" id="cardName"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-0 pb-1 text-nowrap" style="width: 35%;"
                                                                id="labelInstitution">
                                                                Nama (Sekolah/Vendor)</td>
                                                            <td class="p-0 pb-1 text-center">:</td>
                                                            <td class="p-0 pb-1 text-uppercase" id="cardInstitution"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-0 pb-1 text-nowrap" id="labelIdNumber">(NIK/NIS)</td>
                                                            <td class="p-0 pb-1 text-center">:</td>
                                                            <td class="p-0 pb-1" id="cardNik"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-0 pb-1 text-nowrap">Area</td>
                                                            <td class="p-0 pb-1 text-center">:</td>
                                                            <td class="p-0 pb-1 text-uppercase">{{ $area ?? 'Area Pabrik' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="p-0 pb-1 text-nowrap">Periode</td>
                                                            <td class="p-0 pb-1 text-center">:</td>
                                                            <td class="p-0 pb-1 text-danger fw-bold">14 Jan 2026 s.d. 20 Jan
                                                                2026</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <!-- Kolom Kanan: Foto (Atas) & QR (Bawah) -->
                                            <div class="d-flex flex-column align-items-center justify-content-between"
                                                style="width: 30%;">
                                                <!-- Foto Wajah -->
                                                <div class="bg-light border border-secondary d-flex align-items-center justify-content-center mb-1"
                                                    style="width: 70%; aspect-ratio: 3/4; overflow: hidden;">
                                                    <i class="bi bi-person-fill text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                                <!-- QR Code (Lebih Besar) -->
                                                <div id="qrcodePlaceholder" style="width: 90px; height: 90px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="button" class="btn btn-primary px-4 fw-bold"
                                        onclick="printDiv('printableIdCard')">
                                        <i class="bi bi-printer-fill me-2"></i> Cetak ID Card
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- TEMPLATE CETAK TERSEMBUNYI: WORK PERMIT (A4) -->
                <div id="printableWorkPermit" class="d-none">
                    <div
                        style="width: 21cm; min-height: 29.7cm; padding: 2cm; background: white; font-family: 'Times New Roman', serif;">
                        <!-- Header -->
                        <table style="width: 100%; border-bottom: 2px solid black; margin-bottom: 20px;">
                            <tr>
                                <td style="width: 15%; text-align: center;">
                                    <img src="https://via.placeholder.com/80?text=LOGO" alt="Logo" style="height: 60px;">
                                </td>
                                <td style="width: 70%; text-align: center;">
                                    <h2 style="margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase;">PT.
                                        Krakatau
                                        Baja Konstruksi</h2>
                                    <h3
                                        style="margin: 5px 0 0; font-size: 14pt; font-weight: bold; text-decoration: underline;">
                                        SURAT
                                        IZIN KERJA (WORK PERMIT)</h3>
                                    <p style="margin: 5px 0 0; font-size: 10pt;">No. Dokumen: WP-2024-001</p>
                                </td>
                                <td style="width: 15%;"></td>
                            </tr>
                        </table>

                        <!-- Content -->
                        <div style="font-size: 12pt; line-height: 1.5;">
                            <p><strong>A. INFORMASI UMUM</strong></p>
                            <table style="width: 100%; margin-bottom: 15px;">
                                <tr>
                                    <td style="width: 30%;">Nama Vendor</td>
                                    <td style="width: 2%;">:</td>
                                    <td style="border-bottom: 1px dotted #000;">{{ $vendor }}</td>
                                </tr>
                                <tr>
                                    <td>Area Kerja</td>
                                    <td>:</td>
                                    <td style="border-bottom: 1px dotted #000;">{{ $area }}</td>
                                </tr>
                                <tr>
                                    <td>Periode</td>
                                    <td>:</td>
                                    <td style="border-bottom: 1px dotted #000;">14 Jan 2024 s.d 14 Jan 2025</td>
                                </tr>
                            </table>

                            <p><strong>B. DETAIL PEKERJAAN</strong></p>
                            <div style="border: 1px solid #000; padding: 10px; margin-bottom: 15px; min-height: 100px;">
                                {{ $uraian }}
                                <br><br>
                                <strong>Potensi Bahaya:</strong> Bekerja di ketinggian, Arus Listrik.
                            </div>

                            <p><strong>C. DAFTAR PERSONIL</strong></p>
                            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;" border="1">
                                <tr style="background-color: #eee;">
                                    <th style="padding: 5px; text-align: center;">No</th>
                                    <th style="padding: 5px; text-align: left;">Nama</th>
                                    <th style="padding: 5px; text-align: center;">NIK</th>
                                    <th style="padding: 5px; text-align: center;">Status</th>
                                </tr>
                                @foreach($employees as $index => $emp)
                                    @if(!$emp['is_blacklisted'])
                                        <tr>
                                            <td style="padding: 5px; text-align: center;">{{ $index + 1 }}</td>
                                            <td style="padding: 5px;">{{ $emp['name'] }}</td>
                                            <td style="padding: 5px; text-align: center;">{{ $emp['nik'] }}</td>
                                            <td style="padding: 5px; text-align: center;">OK</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>

                            <p><strong>D. PENGESAHAN</strong></p>
                            <table style="width: 100%; border: 1px solid #000; text-align: center;">
                                <tr>
                                    <!-- User Signature (Always Present as Initiator) -->
                                    <td style="width: 33%; padding: 10px; border-right: 1px solid #000; vertical-align: top;">
                                        <div>Diajukan Oleh:</div>
                                        <div style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                            <!-- Contoh Tanda Tangan User (Dummy Image/Canvas Data) -->
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/e/e4/Signature_sample.svg"
                                                alt="TTD User" style="height: 50px; width: auto;">
                                        </div>
                                        <div
                                            style="font-weight: bold; border-top: 1px solid #ccc; width: 80%; margin: 0 auto; padding-top: 5px;">
                                            ( {{ $applicantName }} )</div>
                                        <div>User / Pemohon</div>
                                    </td>

                                    <!-- Corsec Signature (Present if Status != Waiting Corsec) -->
                                    <td style="width: 33%; padding: 10px; border-right: 1px solid #000; vertical-align: top;">
                                        <div>Diverifikasi Oleh:</div>
                                        <div style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                            @if($status != 'Waiting Corsec')
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e4/Signature_sample.svg"
                                                    alt="TTD Corsec" style="height: 50px; width: auto; filter: hue-rotate(90deg);">
                                            @else
                                                <span style="color: #ccc; font-style: italic;">Menunggu Verifikasi</span>
                                            @endif
                                        </div>
                                        <div
                                            style="font-weight: bold; border-top: 1px solid #ccc; width: 80%; margin: 0 auto; padding-top: 5px;">
                                            ( Siti Corsec )</div>
                                        <div>Corporate Secretary</div>
                                    </td>

                                    <!-- HSE Signature (Present if Scheduled/Active/Expired) -->
                                    <td style="width: 33%; padding: 10px; vertical-align: top;">
                                        <div>Disetujui Oleh:</div>
                                        <div style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                            @if(in_array($status, ['Scheduled', 'Active', 'Expired']))
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e4/Signature_sample.svg"
                                                    alt="TTD HSE" style="height: 50px; width: auto; filter: hue-rotate(180deg);">
                                            @elseif($status == 'Waiting HSE')
                                                <span style="color: #ccc; font-style: italic;">Menunggu Persetujuan</span>
                                            @else
                                                <span style="color: #ccc; font-style: italic;">-</span>
                                            @endif
                                        </div>
                                        <div
                                            style="font-weight: bold; border-top: 1px solid #ccc; width: 80%; margin: 0 auto; padding-top: 5px;">
                                            ( Admin HSE )</div>
                                        <div>HSE Dept</div>
                                    </td>
                                </tr>
                            </table>
                            <div style="font-size: 9pt; margin-top: 20px; text-align: right;">
                                Dicetak pada: {{ date('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TEMPLATE CETAK TERSEMBUNYI: HSE INDUCTION (A4 Lanskap atau Potret) -->
                <div id="printableHSEPermit" class="d-none">
                    <div
                        style="width: 21cm; min-height: 29.7cm; padding: 2cm; background: white; font-family: Arial, sans-serif; border: 5px double #000;">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <h1 style="font-size: 24pt; font-weight: bold; margin-bottom: 10px; color: #198754;">CERTIFICATE OF
                                SAFETY
                                INDUCTION</h1>
                            <p style="font-size: 12pt;">No. Ref: SI-2024/WP-001</p>
                            <hr style="border: 2px solid #198754;">
                        </div>

                        <div style="font-size: 14pt; line-height: 1.6; text-align: center; margin-bottom: 30px;">
                            <p>Menerangkan bahwa personil dibawah ini:</p>
                            <p><strong>VENDOR: {{ strtoupper($vendor) }}</strong></p>
                            <p>Telah mengikuti dan lulus <strong>Safety Induction</strong> untuk pekerjaan:</p>
                            <p style="font-style: italic;">"{{ $uraian }}"</p>
                        </div>

                        <table style="width: 80%; margin: 0 auto 40px auto; border-collapse: collapse;" border="1">
                            <tr style="background-color: #e2e3e5;">
                                <th style="padding: 10px; text-align: center;">No</th>
                                <th style="padding: 10px; text-align: left;">Nama Personil</th>
                                <th style="padding: 10px; text-align: center;">NIK</th>
                            </tr>
                            <!-- Filter hanya yang tidak di-blacklist -->
                            @php $counter = 1; @endphp
                            @foreach($employees as $emp)
                                @if(!$emp['is_blacklisted'])
                                    <tr>
                                        <td style="padding: 8px; text-align: center;">{{ $counter++ }}</td>
                                        <td style="padding: 8px;">{{ $emp['name'] }}</td>
                                        <td style="padding: 8px; text-align: center;">{{ $emp['nik'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>

                        <div style="display: flex; justify-content: space-between; margin-top: 50px; padding: 0 50px;">
                            <div style="text-align: center;">
                                <p>Cilegon, {{ date('d F Y') }}</p>
                                <p>Personil Vendor,</p>
                                <br><br><br>
                                <p style="text-decoration:overline; font-weight: bold;">{{ strtoupper($vendor) }}</p>
                            </div>
                            <div style="text-align: center;">
                                <p>Mengetahui,</p>
                                <p>Safety Officer,</p>
                                <br><br><br>
                                <p style="text-decoration:overline; font-weight: bold;">ADMIN HSE</p>
                            </div>
                        </div>

                        <div style="margin-top: 50px; text-align: center; font-size: 10pt; color: gray;">
                            * Sertifikat ini berlaku selama masa Work Permit aktif.<br>
                            * Wajib dibawa saat berada di area kerja.
                        </div>
                    </div>
                </div>
@endsection

        @push('scripts')
                <script>
            function showIdCard(name, nik, gender) {
                            document.getElementById('cardName').innerText = name;
                            document.getElementById('cardNik').innerText = nik;

                            // Logika untuk menentukan Institusi dan Jenis ID
                            // Untuk demo, jika NIK dimulai dengan '9', itu Vendor (NIK), jika tidak Sekolah (NIS)
                            const isVendor = nik.startsWith('9');
                            document.getElementById('cardInstitution').innerText = isVendor ? 'PT. TEKNOLOGI MAJU' : 'SMK NEGERI 1 CONTOH';

                            // Perbarui Label
                            document.getElementById('labelInstitution').innerText = isVendor ? 'Nama Vendor' : 'Nama Sekolah';
                            document.getElementById('labelIdNumber').innerText = isVendor ? 'NIK' : 'NIS';

                            // Implementasi Generate QR Code (menggunakan library placeholder atau API)
                            // Untuk saat ini kita gunakan Google Charts API untuk demo mudah
                            const qrContainer = document.getElementById('qrcodePlaceholder');
                            qrContainer.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${nik}" style="width:100%; height:100%;">`;

                            const modal = new bootstrap.Modal(document.getElementById('idCardModal'));
                            modal.show();
                        }

                        // Fungsi Cetak Generik untuk ID Card, Work Permit, dan HSE Permit
                        function printDocument(type) {
                            let divId = '';
                            let title = '';

                            if (type === 'wp') {
                                divId = 'printableWorkPermit';
                                title = 'Cetak Work Permit';
                            } else if (type === 'hse') {
                                divId = 'printableHSEPermit';
                                title = 'Cetak Sertifikat Safety Induction';
                            } else {
                                return;
                            }

                            printDiv(divId, title);
                        }

                        function printDiv(divId, pageTitle = 'Print') {
                            const element = document.getElementById(divId);
                            if (!element) {
                                alert('Template not found!');
                                return;
                            }

                            // DETEKSI MODE KONTEN:
                            // Jika wrapper disembunyikan (d-none), kemungkinan itu adalah wadah untuk template A4 kita -> Gunakan innerHTML.
                            // Jika wrapper terlihat (ID Card di Modal), itu memegang border/dimensi -> Gunakan outerHTML.
                            const isHidden = element.classList.contains('d-none') || element.style.display === 'none';
                            const printContents = isHidden ? element.innerHTML : element.outerHTML;

                            const printWindow = window.open('', '', 'width=900,height=800');
                            printWindow.document.write('<html><head><title>' + pageTitle + '</title>');
                            // Sertakan Bootstrap untuk gaya dasar
                            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">');
                            printWindow.document.write('<style>@media print { body { -webkit-print-color-adjust: exact; } }</style>');
                            printWindow.document.write('</head><body>');
                            // Tambahkan padding untuk visual yang lebih baik di jendela, meskipun cetak biasanya mengabaikan padding body
                            printWindow.document.write('<div style="display:flex; justify-content:center; padding: 20px;">' + printContents + '</div>');
                            printWindow.document.write('</body></html>');
                            printWindow.document.close();

                            // Tunggu gaya/gambar dimuat
                            setTimeout(() => {
                                printWindow.print();
                                // printWindow.close(); // Opsional
                            }, 1000);
                        }
                    </script>

    <!-- jQuery (Wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tableEmployees').DataTable({
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