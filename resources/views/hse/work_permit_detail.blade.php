@extends('layouts.admin')

@section('title', 'Detail Work Permit (HSE)')

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

        /* Checklist Styling */
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
@endpush

@section('content')
    @php
        // DATA DINAMIS DARI CONTROLLER ($wp)
        // Pastikan variabel $wp dikirim dari HseController -> method detail()
        $status = $wp->status;
        $workType = $wp->work_type;

        // Helper untuk status badge diakses via accessor model atau logic manual
        $statusBadgeClass = match ($status) {
            'waiting_corsec' => 'bg-warning text-dark',
            'waiting_hse' => 'bg-info text-dark',
            'scheduled' => 'bg-primary',
            'active' => 'bg-success',
            'rejected' => 'bg-danger',
            'expired' => 'bg-danger',
            default => 'bg-secondary'
        };

        $statusLabel = match ($status) {
            'waiting_corsec' => 'Verifikasi Corsec',
            'waiting_hse' => 'Review HSE',
            'scheduled' => 'Jadwal Induction',
            'active' => 'Aktif',
            'rejected' => 'Ditolak',
            'expired' => 'Kadaluarsa',
            default => 'Draft/Selesai'
        };
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
                    <h5 class="card-title fw-bold">Status Tracking: <span
                            class="badge {{ $statusBadgeClass }}">{{ $statusLabel }}</span></h5>
                </div>
                <div class="card-body pt-3 pb-2">
                    <div class="position-relative mb-2">
                        <div class="progress"
                            style="height: 4px; position: absolute; top: 25px; left: 5%; right: 5%; z-index: 1;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status == 'expired' ? '100%' : ($status == 'active' ? '100%' : ($status == 'scheduled' ? '80%' : ($status == 'waiting_hse' ? '40%' : ($status == 'waiting_corsec' ? '20%' : '0%')))) }};"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                            <!-- Step 1: Draft/Diajukan -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['waiting_corsec', 'waiting_hse', 'scheduled', 'active', 'expired', 'finished']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-file-earmark-plus fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Penerbitan<br>Work Permit</span>
                                <small class="text-muted d-block"
                                    style="font-size: 0.75rem;">{{ $wp->created_at->format('d M H:i') }}</small>
                            </div>

                            <!-- Step 2: Verifikasi Corsec -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['waiting_hse', 'scheduled', 'active', 'expired', 'finished']) ? 'bg-success' : ($status == 'waiting_corsec' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-building-check fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Verifikasi Corsec</span>
                            </div>

                            <!-- Step 3: Review HSE -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['scheduled', 'active', 'expired', 'finished']) ? 'bg-success' : ($status == 'waiting_hse' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-search fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Review HSE</span>
                            </div>

                            <!-- Step 4: Safety Induction -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['active', 'expired', 'finished']) ? 'bg-success' : ($status == 'scheduled' ? 'bg-primary' : 'bg-secondary') }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-person-badge fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Safety Induction<br>& Cetak ID</span>
                                @if(in_array($status, ['active', 'expired', 'finished']))
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Wait Check</small>
                                @endif
                                @if($status == 'scheduled')
                                    <small class="d-block text-warning fw-bold" style="font-size: 0.7rem;">Izin Masuk
                                        Aktif</small>
                                @endif
                            </div>

                            <!-- Step 5: Aktif (Tetap Hijau jika Kedaluwarsa) -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['active', 'expired', 'finished']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-flag fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Full Access</span>
                            </div>

                            <!-- Step 6: Kedaluwarsa (Tahap Baru) -->
                            <div class="text-center bg-white px-2">
                                <div class="rounded-circle {{ in_array($status, ['expired', 'finished']) ? 'bg-success' : 'bg-secondary' }} text-white d-flex align-items-center justify-content-center mx-auto border border-3 border-white shadow-sm"
                                    style="width: 50px; height: 50px;">
                                    <i class="bi bi-check-circle-fill fs-4"></i>
                                </div>
                                <span class="d-block mt-2 fw-bold small">Selesai/Expired</span>
                                @if($status == 'expired')
                                    <small class="text-muted d-block"
                                        style="font-size: 0.75rem;">{{ $wp->end_date->format('d M Y') }}</small>
                                    <small class="d-block text-primary fw-bold" style="font-size: 0.7rem;">Selesai</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <form id="hseActionForm" method="POST">
                @csrf
                <div class="row">
                    <!-- Left Column: Data Head Work Permit -->
                    <div class="col-md-7">
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Work Permit #WP-2024-001</h3>
                            </div>
                            <div class="card-body">
                                <!-- No. Dokumen WP -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nomer Work Permit (User)</label>
                                        <input type="text" class="form-control" value="{{ $wp->doc_no }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-primary fw-bold">No. Izin Kerja Berbahaya
                                            (HSE)</label>
                                        <input type="text" class="form-control fw-bold text-primary border-primary"
                                            value="{{ $wp->doc_no }}/HSE/01" disabled>
                                    </div>
                                </div>

                                <!-- Nama Vendor -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Vendor/Instansi/Universitas</label>
                                    <input type="text" class="form-control" value="{{ $wp->vendor->name }}" disabled>
                                </div>

                                <!-- Area & STA -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Area</label>
                                        <input type="text" class="form-control" value="{{ $wp->location }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">STA</label>
                                        <input type="text" class="form-control" value="Jasa Rutin" disabled>
                                    </div>
                                </div>

                                <!-- Nomer JO -->
                                <div class="mb-3">
                                    <label class="form-label">Nomer JO (Bila Jasa Rutin)</label>
                                    <input type="text" class="form-control" name="nomer_jo" value="{{ $no_jo }}" disabled>
                                </div>

                                <!-- Jenis Pekerjaan (Safety Induction) - Highlight Current Type -->
                                <div class="mb-3">
                                    <label class="form-label d-block">Jenis Pekerjaan untuk Safety Induction</label>
                                    <input type="text" class="form-control fw-bold text-primary" value="{{ $type }}"
                                        disabled>
                                </div>

                                <!-- Uraian Pekerjaan -->
                                <div class="mb-3">
                                    <label class="form-label">Uraian Pekerjaan</label>
                                    <textarea class="form-control" rows="4" disabled>{{ $wp->work_description }}</textarea>
                                </div>

                                <!-- Waktu Mulai & Akhir -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Waktu Mulai</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                value="{{ $wp->start_date->format('Y-m-d') }}" disabled>
                                            <input type="time" class="form-control" value="08:00" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Waktu Berakhir</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control"
                                                value="{{ $wp->end_date->format('Y-m-d') }}" disabled>
                                            <input type="time" class="form-control" value="17:00" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- MANUAL CHECKLIST SECTION FOR HSE -->
                                <hr>
                                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-check2-square"></i> Checklist
                                    Kelengkapan K3 (Sesuai Pekerjaan: {{ $type }})</h5>

                                <div class="row">
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
                                            'Memasuki Ruang Terbatas' => [
                                                'apd' => ['Safety Helmet', 'Safety Shoes', 'Masker/Respirator', 'Body Harness', 'Tripod & Winch'],
                                                'pengaman' => ['Gas Detector', 'Blower/Exhaust Fan', 'Standby Man', 'Lampu Explosion Proof']
                                            ],
                                            // Default fallback
                                            'default' => [
                                                'apd' => ['Safety Helmet', 'Safety Shoes'],
                                                'pengaman' => ['Safety Line']
                                            ]
                                        ];

                                        // Get specific lists or fallback
                                        $currentReqs = $requirements[$type] ?? $requirements['default'];
                                        $apds = $currentReqs['apd'];
                                        $pengamans = $currentReqs['pengaman'];

                                        // Pre-check logic (if inactive, assume all were checked for data display)
                                        $checkedApds = ($status != 'Waiting HSE') ? $apds : [];
                                        $checkedPengamans = ($status != 'Waiting HSE') ? $pengamans : [];
                                    @endphp

                                    <!-- APD Column -->
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2">Alat Pelindung Diri (APD)</h6>
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($apds as $apd)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="apd_{{ Str::slug($apd) }}" {{ in_array($apd, $checkedApds) ? 'checked' : '' }} {{ $status != 'Waiting HSE' ? 'disabled' : '' }}>
                                                    <label class="form-check-label"
                                                        for="apd_{{ Str::slug($apd) }}">{{ $apd }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Pengaman Column -->
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2">Pengamanan Lokasi</h6>
                                        <div class="d-flex flex-column gap-2">
                                            @foreach($pengamans as $pengaman)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="pengaman_{{ Str::slug($pengaman) }}" {{ in_array($pengaman, $checkedPengamans) ? 'checked' : '' }} {{ $status != 'Waiting HSE' ? 'disabled' : '' }}>
                                                    <label class="form-check-label"
                                                        for="pengaman_{{ Str::slug($pengaman) }}">{{ $pengaman }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Pegawai OS -->
                    <div class="col-md-5">

                        <!-- ACTION CARD (Dynamic based on Status) -->
                        <div class="card card-primary card-outline mb-4">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">
                                    @if($status == 'waiting_hse')
                                        <i class="bi bi-calendar-plus me-1"></i> Penjadwalan Safety Induction
                                    @elseif($status == 'scheduled')
                                        <i class="bi bi-file-earmark-check me-1"></i> Validasi Safety Induction
                                    @else
                                        <i class="bi bi-info-circle me-1"></i> Data Safety Induction
                                    @endif
                                </h3>
                            </div>
                            <div class="card-body">
                                <form id="hseActionForm" method="POST">
                                    @csrf
                                @if($status == 'waiting_hse')
                                    <!-- STEP 1: Scheduling -->
                                    <div class="mb-3">
                                        <label class="form-label">Tentukan Jadwal Induction <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" name="induction_schedule"
                                            id="inputSchedule">
                                        <small class="text-muted">Pilih tanggal dan jam pelaksanaan safety induction.</small>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-success fw-bold" onclick="approveAndSchedule()">
                                            <i class="bi bi-check-circle"></i> Setujui & Jadwalkan
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="rejectWP()">
                                            <i class="bi bi-x-circle"></i> Tolak Pengajuan
                                        </button>
                                    </div>

                                @elseif($status == 'scheduled')
                                    <!-- STEP 2: Upload Evidence -->
                                    <div class="mb-3">
                                        <label class="form-label">Jadwal Terpilih</label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $wp->induction_schedule ? $wp->induction_schedule->format('d M Y, H:i') : '-' }}"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="safetyInductionFile" class="form-label">Upload Bukti Dokumen <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="file" id="safetyInductionFile" name="evidence"
                                            accept=".pdf,.jpg,.jpeg,.png">
                                        <small class="text-muted">Formulir kehadiran atau sertifikat induction.</small>
                                    </div>
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-primary fw-bold" onclick="finishInduction()">
                                            <i class="bi bi-save"></i> Selesaikan & Aktifkan Izin
                                        </button>
                                    </div>

                                @else
                                    <!-- STEP 3: View Mode -->
                                    <div class="mb-3">
                                        <label class="form-label">Jadwal Pelaksanaan</label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $wp->induction_schedule ? $wp->induction_schedule->format('d M Y, H:i') : '-' }}"
                                            readonly>
                                    </div>
                                    @if($wp->induction_evidence_path)
                                        <div class="alert alert-light border d-flex align-items-center mb-0">
                                            <i class="bi bi-file-earmark-pdf fs-3 text-danger me-3"></i>
                                            <div>
                                                <h6 class="fw-bold mb-0">Bukti_Induction.pdf</h6>
                                                <small class="text-muted">Divalidasi: {{ $wp->updated_at->format('d M Y') }}</small>
                                            </div>
                                            <a href="#" class="btn btn-sm btn-outline-primary ms-auto"><i
                                                    class="bi bi-download"></i></a>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <small>Belum ada bukti yang diupload.</small>
                                        </div>
                                    @endif
                                @endif
                                </form>
                            </div>
                        </div>

                        <!-- Card Pegawai OS -->
                        <div class="card card-info card-outline mb-4">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Pegawai OS ({{ count($employees) }})</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="max-height: 400px; overflow-y: auto;">
                                    @foreach($employees as $emp)
                                        <div class="employee-card d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="avatar-circle">
                                                    <i class="bi bi-person"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 fw-bold">{{ $emp['name'] }}</h6>
                                                <small class="text-muted d-block">{{ $emp['nik'] }}</small>
                                                <div class="mt-1">
                                                    <span class="badge border text-dark">{{ $emp['gender'] }}</span>
                                                    <span class="badge border text-dark">Gol. Darah {{ $emp['blood'] }}</span>
                                                </div>
                                            </div>


                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>



                        <!-- Card Riwayat Aktivitas (History Log) - New -->
                        <div class="card card-secondary card-outline">
                            <div class="card-header">
                                <h3 class="card-title fw-bold">Riwayat Aktivitas</h3>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush">
                                    @if($status == 'Waiting HSE')
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 text-primary fw-bold">Pengajuan Work Permit</h6>
                                                <small class="text-muted">Hari ini</small>
                                            </div>
                                            <p class="mb-1 small">Diajukan oleh Corsec dan menunggu review HSE.</p>
                                        </div>
                                    @else
                                        <!-- Mockup Log untuk Tampilan Aktif/Riwayat -->
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 fw-bold text-primary">Status Terkini:
                                                    {{ ucfirst(str_replace('_', ' ', $wp->status)) }}</h6>
                                                <small class="text-muted">{{ $wp->updated_at->format('d M H:i') }}</small>
                                            </div>
                                            <p class="mb-1 small">Update status terakhir.</p>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 fw-bold text-secondary">Pengajuan Dibuat</h6>
                                                <small class="text-muted">{{ $wp->created_at->format('d M H:i') }}</small>
                                            </div>
                                            <p class="mb-1 small">Diajukan oleh {{ $wp->vendor->name ?? 'User' }}.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Signature Modal -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true">
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Logika Canvas
        let canvas, ctx, isDrawing = false;
        let activeAction = ''; // 'schedule' atau 'finish'

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
        // Helper: Clear Canvas
        function clearCanvas() { if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height); }

        // --- HSE ACTIONS ---

        function approveAndSchedule() {
            // Validasi Input Jadwal
            const scheduleInput = document.getElementById('inputSchedule');
            if (!scheduleInput || !scheduleInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Jadwal Belum Dipilih',
                    text: 'Harap tentukan tanggal dan jam Safety Induction terlebih dahulu.',
                });
                return;
            }

            // Konfirmasi lalu Submit
            Swal.fire({
                title: 'Setujui & Jadwalkan?',
                text: "User akan mendapat notifikasi jadwal induction.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                confirmButtonText: 'Ya, Jadwalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('hseActionForm');
                    form.action = "{{ route('hse.work_permit.schedule', $wp->id) }}";
                    form.submit();
                }
            });
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

            Swal.fire({
                title: 'Validasi Selesai?',
                text: "Work Permit akan diaktifkan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                confirmButtonText: 'Ya, Aktifkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('hseActionForm');
                    form.action = "{{ route('hse.work_permit.validate', $wp->id) }}";
                    form.enctype = "multipart/form-data"; // Penting untuk upload file
                    form.submit();
                }
            });
        }

        function rejectWP() {
            Swal.fire({
                title: 'Tolak Izin Kerja?',
                text: "Berikan alasan penolakan:",
                input: 'textarea',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tolak',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Alasan penolakan wajib diisi!')
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('hseActionForm');

                    // Tambahkan input hidden untuk alasan
                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'reject_reason';
                    reasonInput.value = result.value;
                    form.appendChild(reasonInput);

                    form.action = "{{ route('hse.work_permit.reject', $wp->id) }}";
                    form.submit();
                }
            });
        }

    </script>


@endpush