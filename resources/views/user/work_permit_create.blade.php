@extends('layouts.admin')

@section('title', 'Tambah Work Permit')

@push('styles')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- jQuery UI CSS (for Autocomplete) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        /* Fix jQuery UI Autocomplete z-index */
        .ui-front {
            z-index: 9999 !important;
        }

        .ui-menu-item .ui-menu-item-wrapper {
            padding: 8px 12px;
        }

        .ui-menu-item .ui-menu-item-wrapper.ui-state-active {
            background: #0d6efd;
            color: white;
            border: 1px solid #0d6efd;
        }

        /* Gaya kustom untuk menyesuaikan mockup pengguna */
        .employee-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
            transition: all 0.3s ease;
        }

        .employee-card:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }

        .btn-delete-emp {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
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
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Tambah Work Permit Baru</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('user.work-permit') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form id="formCreateWP" action="#" method="POST">
                <!-- Data Head Work Permit -->
                <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                    <div class="card-header bg-transparent border-0 pt-4 pb-2">
                        <h5 class="fw-bold text-dark mb-0 ps-2">Data Head Work Permit</h5>
                    </div>
                    <div class="card-body pt-0">
                        <!-- Row 1: Vendor -->
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="text-muted small text-uppercase fw-bold letter-spacing-1 mb-1">Nama Vendor /
                                    Instansi / Universitas</label>
                                <input type="text" class="form-control fw-bold" name="nama_vendor" id="inputVendorName"
                                    placeholder="Masukkan atau Cari Nama Vendor..." required autocomplete="off">
                            </div>
                        </div>

                        <!-- Row 2: Info Grid -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Nomor JO (Jasa Rutin)</label>
                                <input type="text" class="form-control" name="nomer_jo" placeholder="Contoh: JO-202X-...">
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Area Kerja</label>
                                <select class="form-select select2" name="area" id="selectArea">
                                    <option></option>
                                    <option value="Area Pabrik 1">Area Pabrik 1</option>
                                    <option value="Area Pabrik 2">Area Pabrik 2</option>
                                    <option value="Area Kantor Pusat">Area Kantor Pusat</option>
                                    <option value="Area Gudang">Area Gudang</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small text-uppercase fw-bold mb-1">STA</label>
                                <select class="form-select" name="sta" id="selectSTA">
                                    <option selected disabled>Pilih STA</option>
                                    <option value="Jasa Murni">Jasa Murni</option>
                                    <option value="Jasa Rutin">Jasa Rutin</option>
                                    <option value="KP/Magang">KP/Magang</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 3: Description & Hazards/Schedule -->
                        <div class="row mb-4">
                            <!-- Left: Description -->
                            <div class="col-md-6">
                                <label class="text-muted small text-uppercase fw-bold mb-1">Uraian Pekerjaan</label>
                                <div class="h-100">
                                    <textarea class="form-control h-100" name="uraian_pekerjaan" rows="5"
                                        placeholder="Deskripsikan pekerjaan secara detail..."></textarea>
                                </div>
                            </div>
                            <!-- Right: Hazards & Schedule -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase fw-bold mb-2">Jenis Pekerjaan (Safety
                                        Hazard)</label>
                                    <div class="card card-body bg-light border-0 p-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                        value="Panas" id="checkPanas">
                                                    <label class="form-check-label small" for="checkPanas">Pekerjaan
                                                        Panas</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                        value="Ruang Terbatas" id="checkConfined">
                                                    <label class="form-check-label small" for="checkConfined">Ruang
                                                        Terbatas</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                        value="Ketinggian" id="checkTinggi">
                                                    <label class="form-check-label small" for="checkTinggi">Bekerja di
                                                        Ketinggian</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                        value="Listrik" id="checkListrik">
                                                    <label class="form-check-label small" for="checkListrik">Pekerjaan
                                                        Listrik</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                        value="Penggalian" id="checkGali">
                                                    <label class="form-check-label small" for="checkGali">Pekerjaan
                                                        Galian</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-muted small text-uppercase fw-bold mb-1">Jadwal Pekerjaan
                                        Utama</label>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="datetime-local" class="form-control" name="waktu_mulai"
                                                    id="waktuMulai">
                                                <label for="waktuMulai">Mulai</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="datetime-local" class="form-control" name="waktu_berakhir"
                                                    id="waktuBerakhir">
                                                <label for="waktuBerakhir">Selesai</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Personil -->
                <div class="card shadow-sm mb-4" style="border-top: 4px solid #0d6efd !important;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 pb-2 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0 ps-2">Daftar Personil (<span id="empCount">0</span>)</h5>
                        <!-- Fitur Search Ada di Body -->
                    </div>
                    <div class="card-body p-3">
                        <!-- Search & Add Section -->
                        <div class="bg-light p-3 rounded mb-3 border">
                            <label class="form-label fw-bold mb-2">Tambah Personil</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="inputEmployeeName"
                                    placeholder="Ketik Nama atau NIK Personil..." autocomplete="off">
                                <button class="btn btn-primary px-4 fw-bold" type="button" id="btnAddEmployee">
                                    <i class="bi bi-plus-lg me-1"></i> Tambah
                                </button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <small class="text-muted">Gunakan fitur ini untuk mencari data dari Master OS.</small>
                                <button class="btn btn-sm btn-link text-decoration-none p-0" type="button"
                                    id="btnSimulateEmployee">
                                    <i class="bi bi-magic me-1"></i> Simulasi Random
                                </button>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle w-100">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" width="5%">No</th>
                                        <th width="20%">Nama Personil</th>
                                        <th width="15%">NIK</th>
                                        <th width="10%">Jenis Kelamin</th>
                                        <th width="10%">Gol. Darah</th>
                                        <th width="15%">Mulai</th>
                                        <th width="15%">Selesai</th>
                                        <th class="text-center" width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeListContainer">
                                    <!-- Empty State Row -->
                                    <tr id="emptyStateRow">
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="bi bi-people display-4 d-block mb-3 opacity-50"></i>
                                            Belum ada personil yang ditambahkan.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="text-end mb-5">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="bi bi-save me-2"></i> Simpan & Ajukan Work Permit
                    </button>
                </div>

                <input type="hidden" name="signature" id="signatureInput">
            </form>
        </div>

    </div>

    <!-- Modal Tanda Tangan -->
    <div class="modal fade" id="signatureModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pen-fill"></i> Tanda Tangan Elektronik</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-2 text-muted">Silakan tanda tangan di bawah ini sebagai bukti pengajuan.</p>
                    <div class="border rounded shadow-sm d-inline-block bg-light">
                        <canvas id="signatureCanvas" width="400" height="200" style="touch-action: none;"></canvas>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" id="btnClearSignature">
                        <i class="bi bi-eraser"></i> Hapus
                    </button>
                    <button type="button" class="btn btn-primary fw-bold px-4" id="btnConfirmSignature">
                        <i class="bi bi-check-lg"></i> Simpan & Ajukan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery UI (Required for Autocomplete) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function () {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Set Default DateTime ke Waktu Sekarang (WIB/Local) untuk Head Work Permit
            const nowIso = new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 60000)).toISOString().slice(0, 16);
            $('#waktuMulai').val(nowIso);
            $('#waktuBerakhir').val(nowIso);

            // Manajemen Daftar Pegawai
            let employeeCount = 0;
            const empCountSpan = document.getElementById('empCount');
            const emptyStateRow = document.getElementById('emptyStateRow');
            const container = document.getElementById('employeeListContainer'); // Tbody
            const btnAdd = document.getElementById('btnAddEmployee');
            const inputName = document.getElementById('inputEmployeeName');

            const btnSimulate = document.getElementById('btnSimulateEmployee');

            function addRandomEmployee() {
                const demoNames = ['Andi Saputra', 'Budi Santoso', 'Citra Dewi', 'Dedi Kurniawan', 'Eka Putri', 'Fajar Nugraha', 'Gita Gutawa'];
                const name = demoNames[Math.floor(Math.random() * demoNames.length)];

                // Simulasi mendapatkan detail acak
                const genders = ['Laki-laki', 'Perempuan'];
                const bloods = ['A', 'B', 'AB', 'O'];
                const nik = Math.floor(Math.random() * 8999999999999999) + 1000000000000000;

                addEmployeeRow(name, nik, genders[Math.floor(Math.random() * 2)], bloods[Math.floor(Math.random() * 4)]);
            }

            if (btnSimulate) {
                btnSimulate.addEventListener('click', function () {
                    addRandomEmployee();
                });
            }

            // Data Dummy untuk Autocomplete (Sama seperti di Master Blacklist)
            var availableOS = [
                "Budi Santoso - 123456",
                "Andi Wijaya - 654321",
                "Citra Kirana - 112233",
                "Dewi Sartika - 998877",
                "Eko Prasetyo - 554433",
                "Fajar Nugraha - 223344",
                "Gita Gutawa - 778899",
                "Heri Potret - 665544",
                "Budi Doremi - 991188",
                "Budiman Sudjatmiko - 110022"
            ];

            // Init Autocomplete
            $("#inputEmployeeName").autocomplete({
                source: availableOS,
                minLength: 0,
                autoFocus: true
            });

            // Data Dummy untuk Vendor
            var availableVendors = [
                "PT. Teknologi Maju",
                "PT. Krakatau Steel",
                "CV. Budi Jaya",
                "PT. Konstruksi Utama",
                "Universitas Indonesia",
                "Politeknik Negeri Jakarta",
                "PT. Solusi Digital",
                "CV. Makmur Abadi",
                "PT. Cilegon Engineering",
                "Yayasn Pendidikan Krakatau"
            ];

            // Init Autocomplete Vendor
            $("#inputVendorName").autocomplete({
                source: availableVendors,
                minLength: 0,
                autoFocus: true
            });

            btnAdd.addEventListener('click', function () {
                let inputValue = inputName.value.trim();

                if (!inputValue) {
                    Swal.fire('Error', 'Harap cari dan pilih pegawai terlebih dahulu!', 'error');
                    return;
                }

                // Cek Blacklist Sederhana
                if (inputValue.toLowerCase().includes('blacklist') || inputValue.toLowerCase() === 'badu') {
                    Swal.fire({
                        icon: 'error',
                        title: 'AKSES DITOLAK (BLACKLIST)',
                        text: 'Pegawai ini terdaftar dalam blacklist.',
                    });
                    inputName.value = '';
                    return;
                }

                // Parsing Nama dan NIK
                let name = inputValue;
                let nik = Math.floor(Math.random() * 8999999999999999) + 1000000000000000; // Default random if not found

                if (inputValue.includes(" - ")) {
                    let parts = inputValue.split(" - ");
                    name = parts[0];
                    nik = parts[1]; // Use NIK from autocomplete
                }

                // Simulasi detail lain
                const genders = ['Laki-laki', 'Perempuan'];
                const bloods = ['A', 'B', 'AB', 'O'];

                addEmployeeRow(name, nik, genders[Math.floor(Math.random() * 2)], bloods[Math.floor(Math.random() * 4)]);

                inputName.value = '';
            });

            function addEmployeeRow(name, nik, gender, blood) {
                // Sembunyikan empty state row jika ada
                if (emptyStateRow && emptyStateRow.style.display !== 'none') {
                    emptyStateRow.style.display = 'none';
                }

                employeeCount++;
                updateCount();

                const id = 'emp-' + Date.now();
                // Get current local time (matches user timezone e.g., WIB)
                const localIso = new Date(new Date().getTime() - (new Date().getTimezoneOffset() * 60000)).toISOString().slice(0, 16);

                const tr = document.createElement('tr');
                tr.id = id;
                tr.className = 'employee-row';
                tr.innerHTML = `
                            <td class="text-center fw-bold text-secondary employee-number"></td>
                            <td>
                                <div class="fw-bold text-dark">${name}</div>
                                <input type="hidden" name="emp_names[]" value="${name}">
                                <input type="hidden" name="emp_niks[]" value="${nik}">
                                <input type="hidden" name="emp_genders[]" value="${gender}">
                                <input type="hidden" name="emp_bloods[]" value="${blood}">
                            </td>
                            <td class="font-monospace text-muted text-nowrap">${nik}</td>
                            <td>${gender}</td>
                            <td class="text-center">${blood}</td>
                            <td>
                                <input type="datetime-local" class="form-control form-control-sm" name="emp_start_date[]" value="${localIso}">
                            </td>
                            <td>
                                <input type="datetime-local" class="form-control form-control-sm" name="emp_end_date[]" value="${localIso}">
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="removeEmployee('${id}')" title="Hapus Personil">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </td>
                        `;

                container.appendChild(tr);
                renumberEmployees();
            }

            function renumberEmployees() {
                const rows = container.querySelectorAll('tr.employee-row');
                rows.forEach((row, index) => {
                    const numberEl = row.querySelector('.employee-number');
                    if (numberEl) {
                        numberEl.textContent = (index + 1);
                    }
                });
            }

            window.removeEmployee = function (id) {
                const element = document.getElementById(id);
                if (element) {
                    element.remove();
                    employeeCount--;
                    updateCount();
                    renumberEmployees();

                    const rows = container.querySelectorAll('tr.employee-row');
                    if (rows.length === 0) {
                        if (emptyStateRow) emptyStateRow.style.display = 'table-row';
                    }
                }
            };

            function updateCount() {
                empCountSpan.innerText = employeeCount;
            }

            // Logika Canvas Tanda Tangan
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

            document.getElementById('btnClearSignature').addEventListener('click', clearCanvas);

            // Inisialisasi canvas saat modal muncul
            modalElement.addEventListener('shown.bs.modal', function () {
                initCanvas();
                clearCanvas(); // Reset canvas setiap kali dibuka
            });

            // Intercept Submit
            $('#formCreateWP').submit(function (e) {
                e.preventDefault();

                // Validasi sederhana
                if ($('#inputEmployeeName').val() === '' && employeeCount === 0) {
                    Swal.fire('Peringatan', 'Mohon tambahkan setidaknya satu pegawai.', 'warning');
                    return;
                }

                // Tampilkan Modal Tanda Tangan
                signatureModal.show();
            });

            // Handle Konfirmasi Tanda Tangan
            document.getElementById('btnConfirmSignature').addEventListener('click', function () {
                // Konversi signature ke Base64
                const signatureData = canvas.toDataURL('image/png');

                // Validasi apakah canvas kosong (opsional, tapi disarankan)
                // Cara sederhana: cek panjang data atau pixel. Disini kita anggap valid jika user klik simpan.

                // Masukkan ke input hidden
                document.getElementById('signatureInput').value = signatureData;

                // Tutup Modal
                signatureModal.hide();

                // Tampilkan Loading/Success lalu submit (simulasi)
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Menyimpan data pengajuan...',
                    timer: 1500,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    Swal.fire(
                        'Berhasil!',
                        'Data Work Permit berhasil disimpan dan diajukan.',
                        'success'
                    ).then(() => {
                        window.location.href = "{{ route('user.work-permit') }}";
                    });
                });
            });
        });
    </script>
@endpush