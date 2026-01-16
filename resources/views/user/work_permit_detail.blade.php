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

        /* Read-only form styling enhancement */
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
        // Determine status from query param (priority) or dummy logic based on ID
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
            'Expired' => 'bg-danger', // Changed to Red for Expired
            default => 'bg-primary'
        };

        // Dummy Data
        $vendor = 'PT. Teknologi Maju';
        $area = 'Area Kantor Pusat';
        $sta = 'Jasa Rutin';
        $no_jo = 'JO-2023-001';
        $uraian = 'Pemeliharaan perangkat jaringan dan server di Gedung Utama.';
        $startDate = date('Y-m-d');
        $startTime = '08:00';
        $endDate = date('Y-m-d', strtotime('+3 days'));
        $endTime = '17:00';

        // Dummy Employees
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
                    <h3 class="mb-0 fw-bold">Detail Work Permit</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.work-permit') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <!-- Status Ribbon (Placeholder) -->
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
                        <!-- Progress Line Background -->
                        <div class="progress"
                            style="height: 4px; position: absolute; top: 25px; left: 5%; right: 5%; z-index: 1;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $status == 'Expired' ? '100%' : ($status == 'Active' ? '80%' : ($status == 'Scheduled' ? '60%' : ($status == 'Waiting HSE' ? '40%' : ($status == 'Waiting Corsec' ? '20%' : '0%')))) }};"
                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- Steps -->
                        <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                            <!-- Step 1: Draft/Submitted -->
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

                            <!-- Step 2: Corsec Verification -->
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

                            <!-- Step 3: HSE Review -->
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

                            <!-- Step 4: Safety Induction -->
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

                            <!-- Step 5: Active (Stays Green if Expired) -->
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

                            <!-- Step 6: Expired (New Stage) -->
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
                    <!-- Left Column: Data Head Work Permit -->
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

                    <!-- Right Column: Pegawai OS -->
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
                                <!-- Employee List Loop -->
                                <div style="max-height: 500px; overflow-y: auto;">
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

                                            <!-- Action Buttons Logic -->
                                            <div class="ms-auto ps-2">
                                                @if($status == 'Active')
                                                    <!-- Show ID Card Button -->
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
                            <!-- No Footer or maybe a Back/Edit button if needed. Detailed view often has no submit. -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- ID Card Print Modal -->
    <div class="modal fade" id="idCardModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center pt-0">
                    <!-- Adjusted to 12cm x 8cm ID Card ratio, roughly 453px x 302px for screen preview -->
                    <div id="printableIdCard"
                        class="d-inline-block text-start border border-dark border-2 position-relative shadow-sm"
                        style="width: 12cm; height: 8cm; background: #fff; overflow: hidden; padding: 0;">
                        <!-- Content Wrapper -->
                        <div class="d-flex flex-column h-100 p-2">
                            <!-- Header: Logo & Title -->
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

                            <!-- Body: Photo & Info -->
                            <div class="d-flex align-items-center flex-grow-1 px-3">
                                <!-- Photo Area (Square logic) -->
                                <div class="me-4 d-flex flex-column align-items-center justify-content-center"
                                    style="width: 30%;">
                                    <div class="bg-light border border-secondary d-flex align-items-center justify-content-center mb-2"
                                        style="width: 100%; aspect-ratio: 3/4; overflow: hidden;">
                                        <i class="bi bi-person-fill text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                    <div id="qrcodePlaceholder" style="width: 60px; height: 60px;"></div>
                                </div>

                                <!-- Info Table -->
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
@endsection

@push('scripts')
    <script>
        function showIdCard(name, nik, gender) {
            document.getElementById('cardName').innerText = name;
            document.getElementById('cardNik').innerText = nik;

            // Logic to determine Institution and ID Type
            // For demo, if NIK starts with '9', it's Vendor (NIK), else School (NIS)
            const isVendor = nik.startsWith('9');
            document.getElementById('cardInstitution').innerText = isVendor ? 'PT. TEKNOLOGI MAJU' : 'SMK NEGERI 1 CONTOH';

            // Update Labels
            document.getElementById('labelInstitution').innerText = isVendor ? 'Nama Vendor' : 'Nama Sekolah';
            document.getElementById('labelIdNumber').innerText = isVendor ? 'NIK' : 'NIS';

            // Generate QR Code implementation (using a placeholder library or API)
            // For now we use Google Charts API for easy demo
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

            // Wait for styles to load
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 1000);
        }
    </script>
@endpush