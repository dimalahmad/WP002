@extends('layouts.admin')

@section('title', 'Detail Work Permit (Corsec)')

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

        /* Peningkatan gaya form read-only */
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
        // Tentukan status dari query param (prioritas) atau default ke Waiting Corsec untuk akses langsung
        $status = request('status') ?? 'Waiting Corsec';

        $statusBadgeClass = match ($status) {
            'Waiting Corsec' => 'bg-warning text-dark',
            'Waiting HSE' => 'bg-info text-dark',
            'Active' => 'bg-success',
            'Expired' => 'bg-danger', // Diubah ke Merah untuk Expired
            default => 'bg-primary'
        };

        // Data Dummy
        $vendor = 'PT. Teknologi Maju';
        $area = 'Area Kantor Pusat';
        $sta = 'Jasa Rutin';
        $no_jo = 'JO-2023-001';
        $uraian = 'Pemeliharaan perangkat jaringan dan server di Gedung Utama.';
        $startDate = date('Y-m-d');
        $startTime = '08:00';
        $endDate = date('Y-m-d', strtotime('+3 days'));
        $endTime = '17:00';

        // Data Pegawai Dummy
        $employees = [
            ['name' => 'Andi Saputra', 'nik' => '1234567890123456', 'gender' => 'Laki-laki', 'blood' => 'O'],
            ['name' => 'Budi Santoso', 'nik' => '9876543210987654', 'gender' => 'Laki-laki', 'blood' => 'A'],
            ['name' => 'Citra Dewi', 'nik' => '4567891230123456', 'gender' => 'Perempuan', 'blood' => 'B'],
        ];
    @endphp

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Detail Work Permit (Corsec View)</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <!-- Tentukan Link Tombol Kembali berdasarkan Status -->
                    <a href="{{ $status == 'Waiting Corsec' ? route('corsec.work-permit-masuk') : route('corsec.work-permit-history') }}"
                        class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- Pita Status (Placeholder untuk pemberitahuan di masa depan) -->
            <!-- <div class="row mt-3"></div> -->
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- LINIMASA PELACAKAN -->
            <div class="card card-outline card-primary mb-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title fw-bold">Status Tracking</h5>
                </div>
                <div class="card-body pt-3 pb-2">
                    <div class="position-relative mb-2">
                        <div class="progress"
                            style="height: 4px; position: absolute; top: 25px; left: 5%; right: 5%; z-index: 1;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status == 'Expired' ? '100%' : ($status == 'Active' ? '80%' : ($status == 'Scheduled' ? '60%' : ($status == 'Waiting HSE' ? '40%' : ($status == 'Waiting Corsec' ? '20%' : '0%')))) }};"
                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                            <!-- Langkah 1: Draft/Diajukan -->
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

                            <!-- Langkah 3: Review HSE -->
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

                            <!-- Langkah 4: Safety Induction -->
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

                            <!-- Langkah 5: Aktif (Tetap Hijau jika Expired) -->
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

                            <!-- Langkah 6: Expired (Tahap Baru) -->
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
                                <!-- No. Dokumen WP -->
                                <div class="mb-3">
                                    <label class="form-label">Nomer Work Permit</label>
                                    <input type="text" class="form-control fw-bold" value="WP-2024-001" disabled>
                                </div>

                                <!-- Nama Vendor -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Vendor/Instansi/Universitas</label>
                                    <input type="text" class="form-control" name="nama_vendor" value="{{ $vendor }}"
                                        disabled>
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

                    <!-- Kolom Kanan: Pegawai OS & Aksi -->
                    <div class="col-md-5">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Pegawai OS ({{ count($employees) }})</h3>
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

                                            <div class="ms-auto ps-2">
                                                @if(in_array($status, ['Active', 'Expired']))
                                                    <!-- Hanya Aktif (Disetujui oleh HSE) atau Expired yang mendapatkan Tombol Cetak -->
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
                        </div>

                        <!-- Kartu Aksi untuk Corsec -->
                        @if($status == 'Waiting Corsec')
                            <div class="card card-warning card-outline mt-3">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Persetujuan Corsec</h3>
                                </div>
                                <div class="card-body text-center">
                                    <p class="text-muted">Apakah Anda menyetujui Work Permit ini untuk diteruskan ke HSE?</p>
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-success" id="btnApprove">
                                            <i class="bi bi-check-circle"></i> Setujui & Teruskan ke HSE
                                        </button>
                                        <button type="button" class="btn btn-danger" id="btnReject">
                                            <i class="bi bi-x-circle"></i> Tolak Work Permit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif


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
                    <div id="printableIdCard"
                        class="d-inline-block text-start border border-dark border-2 position-relative shadow-sm"
                        style="width: 8.5cm; height: 5.4cm; background: #fff; overflow: hidden; padding: 0;">
                        <!-- Pembungkus Konten -->
                        <div class="d-flex flex-column h-100">
                            <!-- Header: Logo & Judul -->
                            <div
                                class="d-flex align-items-center justify-content-center pt-2 pb-1 border-bottom border-dark">
                                <img src="https://via.placeholder.com/150x50?text=LOGO+PERUSAHAAN" alt="Logo"
                                    style="height: 35px; margin-right: 10px;">
                                <div class="text-center" style="line-height: 1.1;">
                                    <span class="d-block fw-bold text-uppercase"
                                        style="font-size: 10pt; letter-spacing: 0.5px;">KARTU TANDA PENGENAL</span>
                                    <span class="d-block fw-bold text-uppercase" style="font-size: 9pt;">PRAKTEK KERJA /
                                        MAGANG</span>
                                </div>
                            </div>

                            <!-- Body: Foto & Info -->
                            <div class="d-flex flex-grow-1 p-2">
                                <!-- Area Foto -->
                                <div class="me-3 d-flex flex-column align-items-center justify-content-center"
                                    style="width: 25%;">
                                    <div class="bg-light border border-secondary d-flex align-items-center justify-content-center mb-1"
                                        style="width: 100%; height: 90px;">
                                        <i class="bi bi-person-fill text-muted" style="font-size: 3rem;"></i>
                                        <!-- Foto asli akan menjadi <img src="..." class="w-100 h-100 object-fit-cover"> -->
                                    </div>
                                    <div id="qrcodePlaceholder" style="width: 50px; height: 50px; background-color: #000;">
                                    </div>
                                </div>

                                <!-- Tabel Info (Tanpa Batas) -->
                                <div class="flex-grow-1" style="font-size: 9pt;">
                                    <table class="table table-borderless table-sm mb-0 align-middle">
                                        <tbody>
                                            <tr>
                                                <td class="p-0 pb-1 text-nowrap" style="width: 35%;">Nama</td>
                                                <td class="p-0 pb-1 text-center" style="width: 5%;">:</td>
                                                <td class="p-0 pb-1 fw-bold text-uppercase" id="cardName"></td>
                                            </tr>
                                            <tr>
                                                <td class="p-0 pb-1 text-nowrap" style="width: 40%;" id="labelInstitution">
                                                    Nama (Sekolah/Vendor)</td>
                                                <td class="p-0 pb-1 text-center" style="width: 5%;">:</td>
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
    <!-- Modal Tanda Tangan -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true">
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnApprove = document.getElementById('btnApprove');
            const btnReject = document.getElementById('btnReject');

            // Logika Canvas
            let canvas, ctx, isDrawing = false;

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

                // Event Sentuh (untuk dukungan seluler dasar)
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

            function startDrawing(e) {
                isDrawing = true;
                draw(e);
            }

            function draw(e) {
                if (!isDrawing) return;
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                ctx.lineTo(x, y);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(x, y);
            }

            function stopDrawing() {
                isDrawing = false;
                ctx.beginPath();
            }

            function clearCanvas() {
                if (ctx) ctx.clearRect(0, 0, canvas.width, canvas.height);
            }

            if (btnApprove) {
                btnApprove.addEventListener('click', function () {
                    // Buka Modal
                    const modal = new bootstrap.Modal(document.getElementById('signatureModal'));
                    modal.show();

                    // Inisialisasi canvas setelah modal ditampilkan untuk mendapatkan dimensi yang benar
                    setTimeout(initCanvas, 500);
                });
            }

            // Tangani Konfirmasi Tanda Tangan
            document.getElementById('btnConfirmSignature').addEventListener('click', function () {
                // Di sini biasanya Anda akan mengonversi canvas ke gambar: canvas.toDataURL()
                // Untuk demo, lanjutkan saja
                const modalEl = document.getElementById('signatureModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Dokumen telah ditandatangani dan disetujui.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = "{{ route('corsec.work-permit-masuk') }}";
                });
            });

            // Tangani Hapus
            document.getElementById('btnClearSignature').addEventListener('click', clearCanvas);

            if (btnReject) {
                btnReject.addEventListener('click', function () {
                    Swal.fire({
                        title: 'Tolak Work Permit',
                        text: "Silakan masukkan alasan penolakan:",
                        input: 'textarea',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
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

        function showIdCard(name, nik, gender) {
            document.getElementById('cardName').innerText = name;
            document.getElementById('cardNik').innerText = nik;

            // Logika untuk menentukan Institusi dan Jenis ID
            // Untuk demo, jika NIK dimulai dengan '9', itu Vendor (NIK), kalau tidak Sekolah (NIS)
            const isVendor = nik.startsWith('9');
            document.getElementById('cardInstitution').innerText = isVendor ? 'PT. TEKNOLOGI MAJU' : 'SMK NEGERI 1 CONTOH';

            // Perbarui Label
            document.getElementById('labelInstitution').innerText = isVendor ? 'Nama Vendor' : 'Nama Sekolah';
            document.getElementById('labelIdNumber').innerText = isVendor ? 'NIK' : 'NIS';

            // Implementasi Pembuatan Kode QR (menggunakan perpustakaan placeholder atau API)
            // Untuk saat ini kami menggunakan Google Charts API untuk demo mudah
            const qrContainer = document.getElementById('qrcodePlaceholder');
            qrContainer.innerHTML = `<img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${nik}" style="width:100%; height:100%;">`;

            const modal = new bootstrap.Modal(document.getElementById('idCardModal'));
            modal.show();
        }

        function printDiv(divId) {
            const printContents = document.getElementById(divId).outerHTML;
            const originalContents = document.body.innerHTML;

            const printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Print ID Card</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">');
            printWindow.document.write('<style>body{display:flex; justify-content:center; align-items:center; height:100vh; margin:0;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            // Tunggu gaya dimuat
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 1000);
        }
    </script>


@endpush