@extends('layouts.admin')

@section('title', 'Detail Work Permit (Corsec View)')

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
        $reqStatus = request('status') ?? 'Waiting Corsec';

        $status = $reqStatus;

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
        $isVendorBlacklisted = false; // Corsec might see this differently, assuming false for flow
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
        ];
    @endphp

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Detail Work Permit (Corsec View)</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ $status == 'Waiting Corsec' ? route('corsec.work-permit-masuk') : route('corsec.work-permit-history') }}"
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
                        <table id="tableEmployees"
                            class="table table-bordered table-striped table-hover align-middle w-100">
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
                                                {{ $emp['name'] }}
                                            </div>
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

            <!-- SECTION 3: APPROVAL ACTION (CORSEC SPECIFIC) -->
            @if($status == 'Waiting Corsec')
                <div class="card shadow-sm mb-4 border-warning">
                    <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning py-2">
                        <h6 class="fw-bold text-dark mb-0"><i class="bi bi-shield-lock-fill me-2"></i> Persetujuan Corporate
                            Secretary</h6>
                    </div>
                    <div class="card-body text-center p-3">
                        <p class="text-muted mb-3">Apakah Anda menyetujui Work Permit ini untuk diteruskan ke departemen HSE?
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button" class="btn btn-outline-danger px-4 fw-bold" id="btnReject">
                                <i class="bi bi-x-circle me-1"></i> Tolak
                            </button>
                            <button type="button" class="btn btn-success px-4 fw-bold shadow-sm" id="btnApprove">
                                <i class="bi bi-check-circle-fill me-1"></i> Setujui & Teruskan
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tanda Tangan -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pen-fill"></i> E-Approval Signature</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-2 text-muted">Silakan tanda tangan pada area di bawah ini untuk memvalidasi persetujuan.
                    </p>
                    <div class="border rounded shadow-sm d-inline-block bg-light">
                        <canvas id="signatureCanvas" width="400" height="200" style="touch-action: none;"></canvas>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" id="btnClearSignature">
                        <i class="bi bi-eraser"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-success fw-bold px-4" id="btnConfirmSignature">
                        <i class="bi bi-check-lg"></i> Validasi & Setujui
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables & Plugin -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Init DataTables
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

            const btnApprove = document.getElementById('btnApprove');
            const btnReject = document.getElementById('btnReject');

            // Logika Canvas
            let canvas, ctx, isDrawing = false;
            const modalElement = document.getElementById('signatureModal');
            const signatureModal = new bootstrap.Modal(modalElement);

            function initCanvas() {
                canvas = document.getElementById('signatureCanvas');
                if (!canvas) return;
                ctx = canvas.getContext('2d');
                ctx.lineWidth = 2;
                ctx.lineCap = 'round';
                ctx.strokeStyle = '#000';

                // Event Mouse
                canvas.addEventListener('mousedown', startDrawing);
                canvas.addEventListener('mousemove', draw);
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mouseout', stopDrawing);

                // Event Sentuh
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
            function clearCanvas() {
                if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
            }

            // Inisialisasi canvas saat modal muncul
            modalElement.addEventListener('shown.bs.modal', function () {
                initCanvas();
                clearCanvas();
            });

            document.getElementById('btnClearSignature').addEventListener('click', clearCanvas);

            if (btnApprove) {
                btnApprove.addEventListener('click', function () {
                    signatureModal.show();
                });
            }

            document.getElementById('btnConfirmSignature').addEventListener('click', function () {
                signatureModal.hide();

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Dokumen telah ditandatangani dan disetujui.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = "{{ route('corsec.work-permit-masuk') }}";
                });
            });

            if (btnReject) {
                btnReject.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Tolak Work Permit',
                        text: "Silakan masukkan alasan penolakan:",
                        input: 'textarea',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'Tolak',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire('Ditolak!', 'Work Permit telah dikembalikan ke User.', 'info')
                                .then(() => window.location.href = "{{ route('corsec.work-permit-masuk') }}");
                        }
                    });
                });
            }
        });
    </script>
@endpush