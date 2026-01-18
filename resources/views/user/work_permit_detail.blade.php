@extends('layouts.admin')

@section('title', 'Detail Work Permit')

@push('styles')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
            'Expired' => 'bg-danger', // Diubah menjadi Merah untuk Kedaluwarsa
            default => 'bg-primary'
        };

        // Dummy Data
        // Dummy Data - SIMULASI VENDOR BLACKLIST
        // Simulasikan Vendor sebagai "Suspect" atau memiliki riwayat blacklist untuk demo
        $vendor = 'PT. Teknologi Maju';
        $isVendorBlacklisted = true; // Ubah ke true untuk menguji VISUALISASI BLACKLIST DEMO
        $vendorLabelHtml = $isVendorBlacklisted
            ? $vendor . ' <span class="badge bg-danger ms-2"><i class="bi bi-exclamation-triangle-fill"></i> BLACKLISTED</span>'
            : $vendor . ' <span class="badge bg-success ms-2" style="font-size: 0.6em;"><i class="bi bi-check-circle"></i> TERVERIFIKASI</span>';
        $area = 'Area Kantor Pusat';
        $sta = 'Jasa Rutin';
        $no_jo = 'JO-2023-001';
        $uraian = 'Pemeliharaan perangkat jaringan dan server di Gedung Utama.';
        $startDate = date('Y-m-d');
        $startTime = '08:00';
        $endDate = date('Y-m-d', strtotime('+3 days'));
        $endTime = '17:00';

        // Dummy Karyawan
        $employees = [
            ['name' => 'Andi Saputra', 'nik' => '1234567890123456', 'gender' => 'Laki-laki', 'blood' => 'O', 'is_blacklisted' => false],
            ['name' => 'Budi Santoso', 'nik' => '9876543210987654', 'gender' => 'Laki-laki', 'blood' => 'A', 'is_blacklisted' => false],
            ['name' => 'Citra Dewi', 'nik' => '4567891230123456', 'gender' => 'Perempuan', 'blood' => 'B', 'is_blacklisted' => false],
            ['name' => 'Dudung (Blacklist)', 'nik' => '9999999999999999', 'gender' => 'Laki-laki', 'blood' => 'AB', 'is_blacklisted' => true],
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
            <!-- Pita Status (Placeholder) -->
            <!-- <div class="row mt-3"></div> -->
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- TRACKING TIMELINE -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title fw-bold">Status Tracking</h5>
                </div>
                <div class="card-body pt-3 pb-2">
                    <div class="position-relative mb-2">
                        <!-- Latar Belakang Garis Progres -->
                        <div class="progress"
                            style="height: 4px; position: absolute; top: 25px; left: 5%; right: 5%; z-index: 1;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status == 'Expired' ? '100%' : ($status == 'Active' ? '80%' : ($status == 'Scheduled' ? '60%' : ($status == 'Waiting HSE' ? '40%' : ($status == 'Waiting Corsec' ? '20%' : '0%')))) }};"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- Langkah-langkah -->
                        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                            <!-- Langkah 1: Draf/Diajukan -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Waiting Corsec', 'Waiting HSE', 'Scheduled', 'Active', 'Expired']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-file-earmark-plus fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Penerbitan<br>Work Permit</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 08:00</small>
                                <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Oleh: Budi
                                    (User)</small>
                            </div>

                            <!-- Langkah 2: Verifikasi Corsec -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Waiting HSE', 'Scheduled', 'Active', 'Expired']) ? 'bg-success' : ($status == 'Waiting Corsec' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-building-check fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Verifikasi Corsec</span>
                                @if(in_array($status, ['Waiting HSE', 'Scheduled', 'Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 09:30</small>
                                    <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Oleh: Siti
                                        (Corsec)</small>
                                @endif
                            </div>

                            <!-- Langkah 3: Tinjauan HSE -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Scheduled', 'Active', 'Expired']) ? 'bg-success' : ($status == 'Waiting HSE' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-search fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Review HSE</span>
                                @if(in_array($status, ['Scheduled', 'Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 13:00</small>
                                    <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Oleh: Admin
                                        HSE</small>
                                @endif
                            </div>

                            <!-- Langkah 4: Induksi Keselamatan -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Active', 'Expired']) ? 'bg-success' : ($status == 'Scheduled' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Safety Induction</span>
                                @if(in_array($status, ['Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">15 Jan 09:00</small>
                                    <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Oleh: Admin
                                        HSE</small>
                                @endif
                            </div>

                            <!-- Langkah 5: Aktif (Tetap Hijau jika Kedaluwarsa) -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Active', 'Expired']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-flag fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Izin Aktif</span>
                                @if(in_array($status, ['Active', 'Expired']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">15 Jan 10:00</small>
                                    <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Valid by
                                        System</small>
                                @endif
                            </div>

                            <!-- Langkah 6: Kedaluwarsa (Tahap Baru) -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ $status == 'Expired' ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Izin Berakhir</span>
                                @if($status == 'Expired')
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">20 Jan 17:00</small>
                                    <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Selesai</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form>
                <div class="row">
                    <!-- Kolom Kiri: Data Head Work Permit -->
                    <div class="col-md-7">
                        <div class="card card-primary card-outline h-100">
                            <div class="card-header">
                                <h3 class="card-title">Data Head Work Permit</h3>
                            </div>
                            <div class="card-body">
                                <!-- Nomer Work Permit -->
                                <div class="mb-3">
                                    <label class="form-label">Nomer Work Permit</label>
                                    <input type="text" class="form-control fw-bold" value="WP-2024-001" disabled>
                                </div>

                                <!-- Nama Vendor -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Vendor/Instansi/Universitas</label>
                                    <div class="input-group">
                                        <div
                                            class="form-control bg-light d-flex align-items-center justify-content-between">
                                            <span>{!! $vendorLabelHtml !!}</span>
                                            @if($isVendorBlacklisted)
                                                <i class="bi bi-exclamation-octagon-fill text-danger fs-5"
                                                    data-bs-toggle="tooltip" title="Vendor ini dalam status Blacklist!"></i>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Area & STA -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Area</label>
                                        <select class="form-select" name="area" disabled>
                                            <option selected>{{ $area }}</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">STA</label>
                                        <select class="form-select" name="sta" disabled>
                                            <option selected>{{ $sta }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nomer JO -->
                                <div class="mb-3">
                                    <label class="form-label">Nomer JO (Bila Jasa Rutin)</label>
                                    <input type="text" class="form-control" name="nomer_jo" value="{{ $no_jo }}" disabled>
                                </div>

                                <!-- Jenis Pekerjaan (Safety Induction) -->
                                <div class="mb-3">
                                    <label class="form-label d-block">Jenis Pekerjaan untuk Safety Induction</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked disabled>
                                                <label class="form-check-label">Pekerjaan Listrik</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" disabled>
                                                <label class="form-check-label">Memasuki Ruang Terbatas</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" disabled>
                                                <label class="form-check-label">Bekerja di Ketinggian</label>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                                <!-- Uraian Pekerjaan -->
                                <div class="mb-3">
                                    <label class="form-label">Uraian Pekerjaan</label>
                                    <textarea class="form-control" rows="4" disabled>{{ $uraian }}</textarea>
                                </div>

                                <!-- Waktu Mulai -->
                                <div class="row mb-3">
                                    <label class="form-label">Waktu Mulai</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" value="{{ $startDate }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" value="{{ $startTime }}" disabled>
                                    </div>
                                </div>

                                <!-- Waktu Berakhir -->
                                <div class="row mb-3">
                                    <label class="form-label">Waktu Berakhir</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" value="{{ $endDate }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" value="{{ $endTime }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Pegawai OS -->
                    <div class="col-md-5">
                        <div class="card card-primary card-outline h-100">
                            <div class="card-header">
                                <h3 class="card-title">Pegawai OS ({{ count($employees) }})</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Loop Daftar Karyawan -->
                                <div style="max-height: 500px; overflow-y: auto;">
                                    @foreach($employees as $emp)
                                        <div
                                            class="employee-card d-flex align-items-center {{ $emp['is_blacklisted'] ? 'border-danger bg-danger bg-opacity-10' : '' }}">
                                            <div class="me-3">
                                                <div class="avatar-circle {{ $emp['is_blacklisted'] ? 'bg-danger' : '' }}">
                                                    <i
                                                        class="bi {{ $emp['is_blacklisted'] ? 'bi-slash-circle' : 'bi-person' }}"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6
                                                    class="mb-0 fw-bold {{ $emp['is_blacklisted'] ? 'text-decoration-line-through text-danger' : '' }}">
                                                    {{ $emp['name'] }}
                                                </h6>
                                                <small class="text-muted d-block">{{ $emp['nik'] }}</small>
                                                <div class="mt-1">
                                                    @if($emp['is_blacklisted'])
                                                        <span class="badge bg-danger">BLACKLISTED</span>
                                                    @else
                                                        <span class="badge border text-dark">{{ $emp['gender'] }}</span>
                                                        <span class="badge border text-dark">Gol. Darah {{ $emp['blood'] }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Logika Tombol Aksi -->
                                            <div class="ms-auto ps-2">
                                                @if($status == 'Active' && !$emp['is_blacklisted'])
                                                    <!-- Tampilkan Tombol ID Card -->
                                                    <button type="button" class="btn btn-sm btn-outline-dark"
                                                        onclick="showIdCard('{{ $emp['name'] }}', '{{ $emp['nik'] }}', '{{ $emp['gender'] }}')">
                                                        <i class="bi bi-person-badge"></i> ID Card
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Tidak ada Footer atau mungkin tombol Kembali/Edit jika diperlukan. Tampilan detail seringkali tidak memiliki tombol kirim. -->
                        </div>
                    </div>
                </div>
            </form>
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
                                    <span class="d-block fw-bold text-uppercase" style="font-size: 10pt;">PRAKTEK KERJA /
                                        MAGANG</span>
                                </div>
                            </div>

                            <!-- Badan: Foto & Info -->
                            <div class="d-flex align-items-center flex-grow-1 px-3">
                                <!-- Area Foto (Logika Persegi) -->
                                <div class="me-4 d-flex flex-column align-items-center justify-content-center"
                                    style="width: 30%;">
                                    <div class="bg-light border border-secondary d-flex align-items-center justify-content-center mb-2"
                                        style="width: 100%; aspect-ratio: 3/4; overflow: hidden;">
                                        <i class="bi bi-person-fill text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                    <div id="qrcodePlaceholder" style="width: 60px; height: 60px;"></div>
                                </div>

                                <!-- Tabel Info -->
                                <div class="flex-grow-1" style="font-size: 10pt;">
                                    <table class="table table-borderless table-sm mb-0 align-middle">
                                        <tbody>
                                            <tr>
                                                <td class="p-0 pb-1 text-nowrap" style="width: 40%;">Nama</td>
                                                <td class="p-0 pb-1 text-center" style="width: 5%;">:</td>
                                                <td class="p-0 pb-1 fw-bold text-uppercase" id="cardName"></td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pb-1 text-nowrap" style="width: 40%;" id="labelInstitution">
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
                                                <td class="p-0 pb-1 text-uppercase">{{ $area ?? 'Area Pabrik' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pb-1 text-nowrap">Periode</td>
                                                <td class="p-0 pb-1 text-center">:</td>
                                                <td class="p-0 pb-1 text-danger fw-bold">14 Jan 2026 s.d. 20 Jan 2026</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary px-4 fw-bold" onclick="printDiv('printableIdCard')">
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
                        <h2 style="margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase;">PT. Krakatau
                            Posco / Steel</h2>
                        <h3 style="margin: 5px 0 0; font-size: 14pt; font-weight: bold; text-decoration: underline;">SURAT
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
                        <td style="width: 33%; padding: 10px; border-right: 1px solid #000;">
                            <div>Diajukan Oleh:</div>
                            <div style="height: 60px;"></div>
                            <div style="font-weight: bold;">( {{ $vendor }} )</div>
                            <div>Vendor/User</div>
                        </td>
                        <td style="width: 33%; padding: 10px; border-right: 1px solid #000;">
                            <div>Diverifikasi Oleh:</div>
                            <div style="height: 60px;"></div>
                            <div style="font-weight: bold;">( Siti Corsec )</div>
                            <div>Corporate Secretary</div>
                        </td>
                        <td style="width: 33%; padding: 10px;">
                            <div>Disetujui Oleh:</div>
                            <div style="height: 60px;"></div>
                            <div style="font-weight: bold;">( Admin HSE )</div>
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
                <h1 style="font-size: 24pt; font-weight: bold; margin-bottom: 10px; color: #198754;">CERTIFICATE OF SAFETY
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
@endpush