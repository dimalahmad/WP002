@extends('layouts.admin')

@section('title', 'Tambah Work Permit')

@push('styles')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
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
                <div class="row">
                    <!-- Kolom Kiri: Data Head Work Permit -->
                    <div class="col-md-7">
                        <div class="card card-primary card-outline h-100">
                            <div class="card-header">
                                <h3 class="card-title">Data Head Work Permit</h3>
                            </div>
                            <div class="card-body">
                                <!-- Nama Vendor -->
                                <div class="mb-3">
                                    <label class="form-label">Nama Vendor/Instansi/Universitas</label>
                                    <input type="text" class="form-control" name="nama_vendor" placeholder="Masukkan Input"
                                        required>
                                </div>

                                <!-- Area & STA -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Area</label>
                                        <select class="form-select select2" name="area" id="selectArea">
                                            <option></option>
                                            <option value="Area Pabrik 1">Area Pabrik 1</option>
                                            <option value="Area Pabrik 2">Area Pabrik 2</option>
                                            <option value="Area Kantor Pusat">Area Kantor Pusat</option>
                                            <option value="Area Gudang">Area Gudang</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">STA</label>
                                        <select class="form-select" name="sta" id="selectSTA">
                                            <option selected disabled>Pilih STA</option>
                                            <option value="Jasa Murni">Jasa Murni</option>
                                            <option value="Jasa Rutin">Jasa Rutin</option>
                                            <option value="KP/Magang">KP/Magang</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nomer JO -->
                                <div class="mb-3">
                                    <label class="form-label">Nomer JO (Bila Jasa Rutin)</label>
                                    <input type="text" class="form-control" name="nomer_jo" placeholder="Masukkan Input">
                                </div>

                                <!-- Jenis Pekerjaan (Safety Induction) -->
                                <div class="mb-3">
                                    <label class="form-label d-block">Jenis Pekerjaan untuk Safety Induction</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                    value="Panas" id="checkPanas">
                                                <label class="form-check-label" for="checkPanas">Pekerjaan Panas
                                                    (Las/Gerinda)</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                    value="Ruang Terbatas" id="checkConfined">
                                                <label class="form-check-label" for="checkConfined">Memasuki Ruang
                                                    Terbatas</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                    value="Penggalian" id="checkGali">
                                                <label class="form-check-label" for="checkGali">Pekerjaan Penggalian</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                    value="Ketinggian" id="checkTinggi">
                                                <label class="form-check-label" for="checkTinggi">Bekerja di
                                                    Ketinggian</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="jenis_pekerjaan[]"
                                                    value="Listrik" id="checkListrik">
                                                <label class="form-check-label" for="checkListrik">Pekerjaan Listrik</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Uraian Pekerjaan -->
                                <div class="mb-3">
                                    <label class="form-label">Uraian Pekerjaan</label>
                                    <textarea class="form-control" name="uraian_pekerjaan" rows="4"
                                        placeholder="Masukkan input"></textarea>
                                </div>

                                <!-- Waktu Mulai -->
                                <div class="row mb-3">
                                    <label class="form-label">Waktu Mulai</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tanggal_mulai">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="jam_mulai">
                                    </div>
                                </div>

                                <!-- Waktu Berakhir -->
                                <div class="row mb-3">
                                    <label class="form-label">Waktu Berakhir</label>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control" name="tanggal_berakhir">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" class="form-control" name="jam_berakhir">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Pegawai OS -->
                    <div class="col-md-5">
                        <div class="card card-primary card-outline h-100">
                            <div class="card-header">
                                <h3 class="card-title">Pegawai OS (<span id="empCount">0</span>)</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                        <i class="bi bi-dash-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="inputEmployeeName"
                                        placeholder="Masukkan Nama Pegawai">
                                    <button class="btn btn-outline-secondary" type="button" id="btnSimulateEmployee"
                                        title="Isi Otomatis">
                                        <i class="bi bi-magic"></i>
                                    </button>
                                    <button class="btn btn-primary" type="button" id="btnAddEmployee">
                                        Tambah
                                    </button>
                                </div>

                                <!-- Wadah untuk Daftar Pegawai -->
                                <div id="employeeListContainer" style="max-height: 500px; overflow-y: auto;">
                                    <!-- Item dinamis akan ditambahkan di sini -->
                                    <div class="text-center text-muted py-5" id="emptyState">
                                        <i class="bi bi-people display-4"></i>
                                        <p class="mt-2">Belum ada pegawai ditambahkan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

    <script>
        $(document).ready(function () {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            // Manajemen Daftar Pegawai
            let employeeCount = 0;
            const empCountSpan = document.getElementById('empCount');
            const emptyState = document.getElementById('emptyState');
            const container = document.getElementById('employeeListContainer');
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

                addEmployeeCard(name, nik, genders[Math.floor(Math.random() * 2)], bloods[Math.floor(Math.random() * 4)]);
            }

            if (btnSimulate) {
                btnSimulate.addEventListener('click', function () {
                    addRandomEmployee();
                });
            }

            btnAdd.addEventListener('click', function () {
                let name = inputName.value.trim();

                if (!name) {
                    addRandomEmployee();
                    return;
                }

                // SIMULASI: Cek Blacklist berdasarkan Nama
                // Di produksi, ini akan memeriksa NIK terhadap database
                if (name.toLowerCase().includes('blacklist') || name.toLowerCase() === 'badu') {
                    Swal.fire({
                        icon: 'error',
                        title: 'AKSES DITOLAK (BLACKLIST)',
                        html: `
                                        <div class="text-start">
                                            <p class="mb-1"><strong>NIK:</strong> 999999999999 (Terdaftar di Blacklist)</p>
                                            <p class="mb-1"><strong>Nama:</strong> ${name}</p>
                                            <p class="mb-0 text-danger"><strong>Alasan:</strong> Pelanggaran Berat K3 (Merokok di Area Gas) pada 2023.</p>
                                        </div>
                                    `,
                        footer: '<a href="#">Lihat Detail Pelanggaran</a>'
                    });
                    inputName.value = ''; // Bersihkan input
                    return; // Hentikan eksekusi
                }

                // Simulasi mendapatkan detail acak
                const genders = ['Laki-laki', 'Perempuan'];
                const bloods = ['A', 'B', 'AB', 'O'];
                const nik = Math.floor(Math.random() * 8999999999999999) + 1000000000000000;

                addEmployeeCard(name, nik, genders[Math.floor(Math.random() * 2)], bloods[Math.floor(Math.random() * 4)]);

                inputName.value = '';
            });

            function addEmployeeCard(name, nik, gender, blood) {
                // Hapus status kosong jika terlihat
                if (emptyState.style.display !== 'none') {
                    emptyState.style.display = 'none';
                }

                employeeCount++;
                updateCount();

                const id = 'emp-' + Date.now();
                const html = `
                                                        <div class="employee-card d-flex align-items-center" id="${id}">
                                                            <div class="me-3">
                                                                <div class="avatar-circle">
                                                                    <i class="bi bi-person"></i>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <h6 class="mb-0 fw-bold">${name}</h6>
                                                                <small class="text-muted d-block">${nik}</small>
                                                                <div class="mt-1">
                                                                    <span class="badge border text-dark">${gender}</span>
                                                                    <span class="badge border text-dark">Gol. Darah ${blood}</span>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-emp" onclick="removeEmployee('${id}')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    `;

                container.insertAdjacentHTML('beforeend', html);
            }

            window.removeEmployee = function (id) {
                const element = document.getElementById(id);
                if (element) {
                    element.remove();
                    employeeCount--;
                    updateCount();

                    if (employeeCount === 0) {
                        emptyState.style.display = 'block';
                    }
                }
            };

            function updateCount() {
                empCountSpan.innerText = employeeCount;
            }

            // Submit Formulir dengan SweetAlert
            $('#formCreateWP').submit(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Pastikan data yang diinput sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Berhasil!',
                            'Data Work Permit berhasil disimpan.',
                            'success'
                        ).then(() => {
                            window.location.href = "{{ route('user.work-permit') }}";
                        });
                    }
                });
            });
        });
    </script>
@endpush