@extends('layouts.admin')

@section('title', 'Detail Work Permit (HSE View)')

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

        /* Peningkatan gaya formulir baca-saja */
        .form-control:disabled,
        .form-control[readonly] {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .form-select:disabled {
            background-color: #f8f9fa;
        }
        
        /* Checklist Styling */
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
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
        // Determine status and type
        $status = request('status') ?? 'Waiting HSE';
        $type = request('type') ?? 'Kerja Panas';
        $schedule = request('schedule') ?? null;

        $statusBadgeClass = match ($status) {
            'Waiting Corsec' => 'bg-warning text-dark',
            'Waiting HSE' => 'bg-info text-dark',
            'Scheduled' => 'bg-primary',
            'Active' => 'bg-success',
            'Inactive' => 'bg-secondary',
            default => 'bg-primary'
        };

        // Dummy Data (Matching Corsec View basically)
        $vendor = 'PT. Maju Jaya';
        $area = 'Area Pabrik Gedung A';
        $sta = 'Jasa Rutin';
        $no_jo = 'JO-2023-001';
        $uraian = 'Perbaikan pipa steam bocor di area produksi.';
        
        // Dates
        $startDate = date('d F Y');
        $startTime = '08:00';
        $endDate = date('d F Y', strtotime('+3 days'));
        $endTime = '17:00';
        $startDateTime = $startDate . ' ' . $startTime;
        $endDateTime = $endDate . ' ' . $endTime;

        // Dummy Karyawan
        $employees = [
            ['name' => 'Ahmad Fulan', 'nik' => '1234567890123456', 'gender' => 'Laki-laki', 'blood' => 'O', 'is_blacklisted' => false, 'start' => $startDateTime, 'end' => $endDateTime],
            ['name' => 'Jhon Doe', 'nik' => '9876543210987654', 'gender' => 'Laki-laki', 'blood' => 'A', 'is_blacklisted' => false, 'start' => $startDateTime, 'end' => $endDateTime],
        ];
    @endphp

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Detail Work Permit: {{ $type }}</h3>
                    <p class="text-muted mb-0">Review Detail Pekerjaan HSE</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ $status == 'Waiting HSE' || $status == 'Scheduled' ? route('hse.work-permit-hse') : route('hse.work_permit_history') }}"
                        class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
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
                        <div class="progress"
                            style="height: 4px; position: absolute; top: 25px; left: 5%; right: 5%; z-index: 1;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status == 'Expired' ? '100%' : ($status == 'Active' ? '100%' : ($status == 'Scheduled' ? '80%' : ($status == 'Waiting HSE' ? '40%' : ($status == 'Waiting Corsec' ? '20%' : '0%')))) }};"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                           <!-- Step 1: Draft/Diajukan -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Waiting Corsec', 'Waiting HSE', 'Scheduled', 'Active', 'Expired']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-file-earmark-plus fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Penerbitan<br>Work Permit</span>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">14 Jan 08:00</small>
                            </div>

                            <!-- Step 2: Verifikasi Corsec -->
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

                            <!-- Step 3: Review HSE -->
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

                            <!-- Step 4: Safety Induction -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['Active', 'Expired', 'Scheduled']) ? 'bg-success' : ($status == 'Scheduled' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Safety Induction<br>& Cetak ID</span>
                                @if(in_array($status, ['Active', 'Expired', 'Scheduled']))
                                    <small class="text-muted d-block"
                                        style="font-size: 0.75rem;">{{ $status == 'Scheduled' ? 'Menunggu' : 'Selesai' }}</small>
                                @endif
                            </div>

                            <!-- Step 5: Full Access -->
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

                            <!-- Step 6: Selesai -->
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

            <!-- SECTION 1: HEAD DATA (READ ONLY) -->
            <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0 ps-2">Data Head Work Permit</h5>
                </div>
                <div class="card-body pt-0">
                    <!-- Row 1: Vendor & Key Info -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <label class="text-muted small text-uppercase fw-bold letter-spacing-1 mb-1">Nama Vendor / Instansi</label>
                            <div class="p-3 bg-light rounded border-start border-3 border-success">
                                <h5 class="fw-bold mb-0 text-dark">{{ $vendor }}</h5>
                                <div class="mt-1 text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Terverifikasi</div>
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
                            <label class="text-muted small text-uppercase fw-bold mb-1">Nomer JO (Jasa Rutin)</label>
                            <div class="fw-bold text-dark fs-5">{{ $no_jo }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Area Kerja</label>
                            <div class="fw-bold text-dark"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $area }}</div>
                        </div>
                        <div class="col-md-3">
                            <label class="text-muted small text-uppercase fw-bold mb-1">STA</label>
                            <div class="fw-bold text-dark"><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">{{ $sta }}</span></div>
                        </div>
                    </div>

                    <!-- Row 3: Description -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Uraian Pekerjaan</label>
                            <div class="p-3 bg-light rounded text-secondary h-100 border-dashed">
                                {{ $uraian }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small text-uppercase fw-bold mb-1">Jadwal Pekerjaan Utama</label>
                            <div class="bg-white border rounded p-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted small">Mulai:</span>
                                    <span class="fw-bold text-primary">{{ $startDateTime }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted small">Selesai:</span>
                                    <span class="fw-bold text-primary">{{ $endDateTime }}</span>
                                </div>
                            </div>
                             <div class="mt-3">
                                <label class="text-muted small text-uppercase fw-bold mb-1">No. Izin Kerja Berbahaya (HSE)</label>
                                @php
                                    $shortCode = match ($type) {
                                        'Kerja Panas' => 'KP',
                                        'Bekerja di Ketinggian' => 'K',
                                        'Pekerjaan Listrik' => 'L',
                                        'Memasuki Ruang Terbatas' => 'RT',
                                        default => 'GEN'
                                    };
                                    $ikbNumber = "WP-2024-001/" . $shortCode . "/01";
                                @endphp
                                <div class="p-2 bg-primary bg-opacity-10 text-primary fw-bold text-center rounded border border-primary">
                                    {{ $ikbNumber }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: CHECKLIST KELENGKAPAN K3 (HSE SPECIFIC - INTERACTIVE) -->
            <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0 ps-2"><i class="bi bi-clipboard-check text-primary me-2"></i> Checklist Kelengkapan K3</h5>
                    <small class="text-muted ps-2">{{ $type }}</small>
                </div>
                <div class="card-body p-4 bg-light bg-opacity-50">
                     @php
                        // Tentukan persyaratan khusus berdasarkan Jenis Pekerjaan
                        $requirements = [
                            'Kerja Panas' => [
                                'apd' => ['Safety Helmet', 'Safety Shoes', 'Kaca Mata Safety', 'Kedok Las', 'Sarung Tangan Kulit', 'Baju Tahan Panas'],
                                'pengaman' => ['APAR', 'Safety Line', 'Isolasi Area', 'Ijin Kerja Panas', 'Fire Blanket']
                            ],
                            'Bekerja di Ketinggian' => [
                                'apd' => ['Safety Helmet', 'Safety Shoes', 'Body Harness', 'Sarung Tangan'],
                                'pengaman' => ['Safety Line', 'Scaffolding Tag', 'Barikade Area']
                            ],
                            'Pekerjaan Listrik' => [
                                'apd' => ['Safety Helmet', 'Safety Shoes Elektrik', 'Sarung Tangan Karet', 'Face Shield'],
                                'pengaman' => ['LOTO (Lock Out Tag Out)', 'Isolasi Power', 'Grounding', 'Safety Line']
                            ],
                            'default' => [
                                'apd' => ['Safety Helmet', 'Safety Shoes'],
                                'pengaman' => ['Safety Line']
                            ]
                        ];
                        $currentReqs = $requirements[$type] ?? $requirements['default'];
                        $apds = $currentReqs['apd'];
                        $pengamans = $currentReqs['pengaman'];

                        $checkedApds = ($status != 'Waiting HSE') ? $apds : [];
                        $checkedPengamans = ($status != 'Waiting HSE') ? $pengamans : [];
                    @endphp

                    <div class="row">
                        <!-- APD Column -->
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold text-uppercase small text-secondary mb-3">Alat Pelindung Diri (APD)</h6>
                            <div class="d-flex flex-column gap-2 p-3 bg-white rounded border">
                                @foreach($apds as $apd)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="apd_{{ Str::slug($apd) }}" {{ in_array($apd, $checkedApds) ? 'checked' : '' }} {{ $status != 'Waiting HSE' ? 'disabled' : '' }}>
                                        <label class="form-check-label fw-bold" for="apd_{{ Str::slug($apd) }}">{{ $apd }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Pengaman Column -->
                        <div class="col-md-6">
                            <h6 class="fw-bold text-uppercase small text-secondary mb-3">Pengamanan Lokasi</h6>
                            <div class="d-flex flex-column gap-2 p-3 bg-white rounded border">
                                @foreach($pengamans as $pengaman)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="pengaman_{{ Str::slug($pengaman) }}" {{ in_array($pengaman, $checkedPengamans) ? 'checked' : '' }} {{ $status != 'Waiting HSE' ? 'disabled' : '' }}>
                                        <label class="form-check-label fw-bold" for="pengaman_{{ Str::slug($pengaman) }}">{{ $pengaman }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: EMPLOYEES TABLE -->
            <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                <div class="card-header bg-transparent border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
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

            <!-- SECTION 4: APPROVAL / ACTION (BOTTOM) -->
            @if($status == 'Waiting HSE' || $status == 'Scheduled' || $status == 'Active')
            <div class="card shadow-sm mb-4 border-primary">
                <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary py-2">
                    <h6 class="fw-bold text-primary mb-0">
                        @if($status == 'Waiting HSE')
                            <i class="bi bi-calendar-plus-fill me-2"></i> Penjadwalan Safety Induction
                        @elseif($status == 'Scheduled')
                            <i class="bi bi-file-earmark-check-fill me-2"></i> Validasi Dokumen Induction
                        @else
                            <i class="bi bi-info-circle-fill me-2"></i> Dokumen Safety Induction
                        @endif
                    </h6>
                </div>
                <div class="card-body p-3">
                     @if($status == 'Waiting HSE')
                        <div class="row align-items-end g-2">
                            <div class="col-md-8">
                                <label class="form-label fw-bold small mb-1">Tentukan Jadwal Induction <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" id="inputSchedule" value="{{ now()->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') }}">
                                <small class="text-muted" style="font-size: 0.75rem;">Pilih tanggal dan jam pelaksanaan safety induction untuk vendor ini.</small>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn btn-outline-danger me-1 fw-bold" onclick="rejectWP()">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </button>
                                <button type="button" class="btn btn-success fw-bold" onclick="approveAndSchedule()">
                                    <i class="bi bi-check-circle-fill me-1"></i> Setujui & Jadwalkan
                                </button>
                            </div>
                        </div>
                    @elseif($status == 'Scheduled')
                        <div class="alert alert-info py-2 d-flex align-items-center mb-3">
                            <i class="bi bi-calendar-event fs-5 me-2"></i>
                            <div>
                                <small class="text-muted d-block">Jadwal Terpilih:</small>
                                <span class="fw-bold">{{ date('d F Y, H:i', strtotime($schedule)) }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="safetyInductionFile" class="form-label fw-bold small mb-1">Upload Bukti Dokumen (PDF/JPG) <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="safetyInductionFile" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted" style="font-size: 0.75rem;">Upload formulir kehadiran atau sertifikat induction yang telah ditandatangani.</small>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary fw-bold" onclick="finishInduction()">
                                <i class="bi bi-save-fill me-1"></i> Selesaikan & Aktifkan Izin
                            </button>
                        </div>
                    @else
                        <!-- ACTIVATED VIEW -->
                        <div class="row">
                             <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Jadwal Pelaksanaan</label>
                                <div class="fw-bold">{{ $schedule ? date('d F Y, H:i', strtotime($schedule)) : '14 Jan 2024, 09:00' }}</div>
                             </div>
                             <div class="col-md-6">
                                <div class="card bg-white border">
                                    <div class="card-body d-flex align-items-center p-2">
                                         <i class="bi bi-file-earmark-pdf fs-3 text-danger me-2"></i>
                                         <div class="lh-1">
                                            <div class="fw-bold small mb-0">Bukti_Safety_Induction.pdf</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">Divalidasi pada {{ date('d M Y') }}</small>
                                         </div>
                                         <button class="btn btn-sm btn-outline-primary ms-auto"><i class="bi bi-download"></i></button>
                                    </div>
                                </div>
                             </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Signature Modal -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="sigModalTitle"><i class="bi bi-pen-fill"></i> Validation Signature
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-2 text-muted">Bubuhkan paraf/tanda tangan HSE Officer sebagai bukti validasi.</p>
                    <div class="border rounded shadow-sm d-inline-block bg-light">
                        <canvas id="signatureCanvas" width="400" height="200" style="touch-action: none;"></canvas>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" id="btnClearSignature">
                        <i class="bi bi-eraser"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-success fw-bold px-4" id="btnConfirmSignature">
                        <i class="bi bi-check-lg"></i> Validasi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
             $('#tableEmployees').DataTable({
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

        // Logika Canvas
        let canvas, ctx, isDrawing = false;
        let activeAction = ''; // 'schedule' atau 'finish'
        const modalElement = document.getElementById('signatureModal');
        const signatureModal = new bootstrap.Modal(modalElement);

        function initCanvas() {
            canvas = document.getElementById('signatureCanvas');
            if (!canvas) return;
            ctx = canvas.getContext('2d');
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';

            // Event
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDrawing);
            canvas.addEventListener('mouseout', stopDrawing);

            // Sentuhan (Touch)
            canvas.addEventListener('touchstart', (e) => {
                e.preventDefault();
                const touch = e.touches[0];
                startDrawing({ clientX: touch.clientX, clientY: touch.clientY });
            });
            canvas.addEventListener('touchmove', (e) => {
                e.preventDefault();
                const touch = e.touches[0];
                draw({ clientX: touch.clientX, clientY: touch.clientY });
            });
            canvas.addEventListener('touchend', stopDrawing);
        }

        function startDrawing(e) { isDrawing = true; draw(e); }
        function draw(e) {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            ctx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
        }
        function stopDrawing() { isDrawing = false; ctx.beginPath(); }
        function clearCanvas() { if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height); }

        modalElement.addEventListener('shown.bs.modal', function () {
            initCanvas();
            clearCanvas();
        });

        document.getElementById('btnClearSignature').addEventListener('click', clearCanvas);

        function approveAndSchedule() {
            // Validasi Input Jadwal
            const scheduleInput = document.getElementById('inputSchedule');
            if (scheduleInput && !scheduleInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jadwal Belum Dipilih',
                    text: 'Harap tentukan tanggal dan jam Safety Induction terlebih dahulu.',
                });
                return;
            }

            activeAction = 'schedule';
            openSignatureModal('Konfirmasi Penjadwalan');
        }

        function finishInduction() {
            // Validasi Upload File
            const fileInput = document.getElementById('safetyInductionFile');
            if (fileInput && fileInput.files.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Dokumen Belum Diupload',
                    text: 'Harap upload bukti Safety Induction Manual untuk mengaktifkan izin.',
                });
                return;
            }

            activeAction = 'finish';
            openSignatureModal('Validasi Akhir & Aktivasi');
        }

        function openSignatureModal(title) {
            document.getElementById('sigModalTitle').innerText = title;
            signatureModal.show();
        }

        document.getElementById('btnConfirmSignature').addEventListener('click', function () {
            signatureModal.hide();

            if (activeAction === 'schedule') {
                Swal.fire('Berhasil!', 'Jadwal Safety Induction telah ditetapkan & Divalidasi.', 'success').then(() => {
                    window.location.href = "{{ route('hse.work-permit-hse') }}";
                });
            } else if (activeAction === 'finish') {
                Swal.fire('Selesai!', 'Safety Induction tervalidasi. Izin Kerja AKTIF.', 'success').then(() => {
                    window.location.href = "{{ route('hse.work_permit_history') }}";
                });
            }
        });

        function rejectWP() {
            Swal.fire({
                title: 'Tolak Izin Kerja?',
                text: "Berikan alasan penolakan:",
                input: 'textarea',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!')
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Ditolak!', 'Work Permit telah ditolak.', 'error').then(() => {
                        window.location.href = "{{ route('hse.work-permit-hse') }}";
                    });
                }
            });
        }
    </script>
@endpush