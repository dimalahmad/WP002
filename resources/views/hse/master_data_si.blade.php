@extends('layouts.admin')

@section('title', 'Master Data SI')

@push('styles')
    <!-- CSS DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        .dataTables_wrapper .dataTables_length select {
            padding-right: 2rem !important;
        }
        .nav-tabs .nav-link {
            color: #495057;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: #0d6efd;
            border-top: 3px solid #0d6efd;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Master Data SI</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="custom-tabs-three-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-apd" data-bs-toggle="pill" href="#content-apd" role="tab"
                        aria-controls="content-apd" aria-selected="true">
                        <i class="bi bi-shield-check me-2"></i>Master APD
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-pengaman" data-bs-toggle="pill" href="#content-pengaman" role="tab"
                        aria-controls="content-pengaman" aria-selected="false">
                        <i class="bi bi-cone-striped me-2"></i>Master Pengaman
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-ikb" data-bs-toggle="pill" href="#content-ikb" role="tab"
                        aria-controls="content-ikb" aria-selected="false">
                        <i class="bi bi-exclamation-triangle me-2"></i>Jenis Pekerjaan Berbahaya
                    </a>
                </li>
            </ul>

            <div class="tab-content" id="custom-tabs-three-tabContent">

                <!-- TAB APD -->
                <div class="tab-pane fade show active" id="content-apd" role="tabpanel" aria-labelledby="tab-apd">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Database APD</h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btnTambahAPD">
                                    <i class="bi bi-plus-lg"></i> Tambah APD Baru
                                </button>
                                <button type="button" class="btn btn-tool" title="Filter"><i
                                        class="bi bi-funnel"></i></button>
                                <button type="button" class="btn btn-tool" title="Export"><i
                                        class="bi bi-cloud-download"></i></button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"><i
                                        class="bi bi-dash-lg"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableMasterAPD" class="table table-bordered table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 50px" class="text-center">No</th>
                                        <th>Nama APD</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $apds = [
                                            'Helmet',
                                            'Safety Shoes',
                                            'Sarung Tangan',
                                            'Kaca mata Safety',
                                            'Masker',
                                            'Pelindung Wajah',
                                            'Body Harnest',
                                            'Kedok Las',
                                            'Air Line Respirator',
                                            'Breathing Apparatus',
                                            'Baju Tahan Panas',
                                        ];
                                    @endphp
                                    @foreach ($apds as $index => $apd)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="fw-bold">{{ $apd }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm text-white btn-edit-apd"
                                                    data-name="{{ $apd }}" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB PENGAMAN -->
                <div class="tab-pane fade" id="content-pengaman" role="tabpanel" aria-labelledby="tab-pengaman">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Database Pengaman</h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btnTambahPengaman">
                                    <i class="bi bi-plus-lg"></i> Tambah Pengaman Baru
                                </button>
                                <button type="button" class="btn btn-tool" title="Filter"><i
                                        class="bi bi-funnel"></i></button>
                                <button type="button" class="btn btn-tool" title="Export"><i
                                        class="bi bi-cloud-download"></i></button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"><i
                                        class="bi bi-dash-lg"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableMasterPengaman" class="table table-bordered table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 50px" class="text-center">No</th>
                                        <th>Nama Pengaman</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $pengamans = [
                                            'Isolasi power supply',
                                            'Hydr. system off',
                                            'Bekas gas beracun',
                                            'Tag out',
                                            'Log out',
                                            'APAR',
                                            'Hydrant',
                                            'Safety Line',
                                            'Lampu penerangan DC 50 Volt',
                                        ];
                                    @endphp
                                    @foreach ($pengamans as $index => $pengaman)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="fw-bold">{{ $pengaman }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm text-white btn-edit-pengaman"
                                                    data-name="{{ $pengaman }}" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- TAB IKB -->
                <div class="tab-pane fade" id="content-ikb" role="tabpanel" aria-labelledby="tab-ikb">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Database Jenis Pekerjaan Berbahaya</h3>
                            <div class="card-tools">
                                <button class="btn btn-primary btn-sm" id="btnTambahIKB">
                                    <i class="bi bi-plus-lg"></i> Tambah Data Baru
                                </button>
                                <button type="button" class="btn btn-tool" title="Filter"><i
                                        class="bi bi-funnel"></i></button>
                                <button type="button" class="btn btn-tool" title="Export"><i
                                        class="bi bi-cloud-download"></i></button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"><i
                                        class="bi bi-dash-lg"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableMasterIKB" class="table table-bordered table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 50px" class="text-center">No</th>
                                        <th>Nama Jenis Pekerjaan Berbahaya</th>
                                        <th class="text-center" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $ikbList = [
                                            'Kerja Panas',
                                            'Memasuki Ruang Terbatas',
                                            'Pekerjaan Penggalian',
                                            'Bekerja di Ketinggian',
                                            'Pekerjaan Listrik',
                                        ];
                                    @endphp
                                    @foreach ($ikbList as $index => $ikb)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="fw-bold">{{ $ikb }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm text-white btn-edit-ikb"
                                                    data-name="{{ $ikb }}" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

    <!-- Modal Tambah/Edit APD -->
    <div class="modal fade" id="modalAPD" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalAPDLabel">Tambah APD Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAPD">
                        <div class="mb-3">
                            <label for="inputNamaAPD" class="form-label">Nama APD</label>
                            <input type="text" class="form-control" id="inputNamaAPD" placeholder="Contoh: Safety Helmet" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSaveAPD">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah/Edit Pengaman -->
    <div class="modal fade" id="modalPengaman" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalPengamanLabel">Tambah Pengaman Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPengaman">
                        <div class="mb-3">
                            <label for="inputNamaPengaman" class="form-label">Nama Pengaman</label>
                            <input type="text" class="form-control" id="inputNamaPengaman" placeholder="Contoh: APAR" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSavePengaman">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Tambah/Edit IKB -->
    <div class="modal fade" id="modalIKB" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="modalIKBLabel">Tambah Jenis Pekerjaan Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formIKB">
                        <div class="mb-3">
                            <label for="inputNamaIKB" class="form-label">Nama Jenis Pekerjaan Berbahaya</label>
                            <input type="text" class="form-control" id="inputNamaIKB" placeholder="Contoh: Kerja Panas" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnSaveIKB">Simpan Data</button>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Init DataTables for each table
            // We use a common config object
            const dtConfig = {
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "paginate": { "previous": "Previous", "next": "Next" }
                },
                "columnDefs": [{ "orderable": false, "targets": 2 }]
            };

            $('#tableMasterAPD').DataTable(dtConfig);
            $('#tableMasterPengaman').DataTable(dtConfig);
            $('#tableMasterIKB').DataTable(dtConfig);

            // --- Generic Helper for Confirmation ---
            function confirmSave(title, textSuccess, callback) {
                Swal.fire({
                    title: 'Konfirmasi Simpan',
                    text: "Apakah Anda yakin ingin menyimpan data ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: textSuccess,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }

            // --- APD Logic ---
            const modalAPD = new bootstrap.Modal(document.getElementById('modalAPD'));
            const modalAPDLabel = document.getElementById('modalAPDLabel');
            const inputNamaAPD = document.getElementById('inputNamaAPD');
            let isEditAPD = false;

            $('#btnTambahAPD').click(function() {
                isEditAPD = false;
                modalAPDLabel.innerText = 'Tambah APD Baru';
                $('#modalAPD .modal-header').removeClass('bg-warning').addClass('bg-primary');
                $('#modalAPD .btn-close').addClass('btn-close-white');
                inputNamaAPD.value = '';
                modalAPD.show();
            });

            $('#tableMasterAPD').on('click', '.btn-edit-apd', function() {
                isEditAPD = true;
                modalAPDLabel.innerText = 'Edit Data APD';
                $('#modalAPD .modal-header').removeClass('bg-primary').addClass('bg-warning');
                $('#modalAPD .btn-close').removeClass('btn-close-white');
                inputNamaAPD.value = $(this).data('name');
                modalAPD.show();
            });

            $('#btnSaveAPD').click(function() {
                if(!inputNamaAPD.value.trim()){ Swal.fire('Error', 'Nama APD harus diisi', 'error'); return;}
                
                confirmSave('Konfirmasi Simpan', isEditAPD ? 'Data APD diperbarui' : 'Data APD ditambahkan', function() {
                    modalAPD.hide();
                    // In real app: submit form via AJAX
                });
            });

            // --- Pengaman Logic ---
            const modalPengaman = new bootstrap.Modal(document.getElementById('modalPengaman'));
            const modalPengamanLabel = document.getElementById('modalPengamanLabel');
            const inputNamaPengaman = document.getElementById('inputNamaPengaman');
            let isEditPengaman = false;

            $('#btnTambahPengaman').click(function() {
                isEditPengaman = false;
                modalPengamanLabel.innerText = 'Tambah Pengaman Baru';
                $('#modalPengaman .modal-header').removeClass('bg-warning').addClass('bg-primary');
                $('#modalPengaman .btn-close').addClass('btn-close-white');
                inputNamaPengaman.value = '';
                modalPengaman.show();
            });

            $('#tableMasterPengaman').on('click', '.btn-edit-pengaman', function() {
                isEditPengaman = true;
                modalPengamanLabel.innerText = 'Edit Data Pengaman';
                $('#modalPengaman .modal-header').removeClass('bg-primary').addClass('bg-warning');
                $('#modalPengaman .btn-close').removeClass('btn-close-white');
                inputNamaPengaman.value = $(this).data('name');
                modalPengaman.show();
            });

            $('#btnSavePengaman').click(function() {
                if(!inputNamaPengaman.value.trim()){ Swal.fire('Error', 'Nama Pengaman harus diisi', 'error'); return;}

                confirmSave('Konfirmasi Simpan', isEditPengaman ? 'Data Pengaman diperbarui' : 'Data Pengaman ditambahkan', function() {
                    modalPengaman.hide();
                });
            });

            // --- IKB Logic ---
            const modalIKB = new bootstrap.Modal(document.getElementById('modalIKB'));
            const modalIKBLabel = document.getElementById('modalIKBLabel');
            const inputNamaIKB = document.getElementById('inputNamaIKB');
            let isEditIKB = false;

            $('#btnTambahIKB').click(function () {
                isEditIKB = false;
                modalIKBLabel.innerText = 'Tambah Jenis Pekerjaan Baru';
                $('#modalIKB .modal-header').removeClass('bg-warning').addClass('bg-primary');
                $('#modalIKB .btn-close').addClass('btn-close-white');
                inputNamaIKB.value = '';
                modalIKB.show();
            });

            $('#tableMasterIKB').on('click', '.btn-edit-ikb', function () {
                isEditIKB = true;
                modalIKBLabel.innerText = 'Edit Jenis Pekerjaan';
                $('#modalIKB .modal-header').removeClass('bg-primary').addClass('bg-warning');
                $('#modalIKB .btn-close').removeClass('btn-close-white');
                inputNamaIKB.value = $(this).data('name');
                modalIKB.show();
            });

            $('#btnSaveIKB').click(function() {
                if(!inputNamaIKB.value.trim()){ Swal.fire('Error', 'Nama Jenis Pekerjaan harus diisi', 'error'); return;}

                confirmSave('Konfirmasi Simpan', isEditIKB ? 'Data Jenis Pekerjaan diperbarui' : 'Data Jenis Pekerjaan ditambahkan', function() {
                    modalIKB.hide();
                });
            });
        });
    </script>
@endpush
