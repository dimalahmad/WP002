@extends('layouts.admin')

@section('title', 'Master Blacklist (HSE)')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- jQuery UI CSS (for Autocomplete) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .dataTables_wrapper .dataTables_length select {
            padding-right: 2rem !important;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-top: 3px solid #dc3545;
            /* Red color to match danger theme */
            color: #dc3545;
        }

        .nav-tabs .nav-link {
            color: #495057;
        }

        /* Fix jQuery UI Autocomplete z-index in Modals */
        .ui-front {
            z-index: 9999 !important;
        }

        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .ui-menu-item .ui-menu-item-wrapper {
            padding: 8px 12px;
        }

        .ui-menu-item .ui-menu-item-wrapper.ui-state-active {
            background: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }
    </style>
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-danger">Master Blacklist</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <!-- Optional Breadcrumb or other header elements -->
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-4" id="blacklistTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="os-tab" data-bs-toggle="tab" data-bs-target="#os-content"
                        type="button" role="tab" aria-controls="os-content" aria-selected="true">
                        <i class="bi bi-person-x-fill me-2"></i>Blacklist OS
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="vendor-tab" data-bs-toggle="tab" data-bs-target="#vendor-content"
                        type="button" role="tab" aria-controls="vendor-content" aria-selected="false">
                        <i class="bi bi-building-fill-x me-2"></i>Blacklist Vendor
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="blacklistTabsContent">
                <!-- Tab Content: Blacklist OS -->
                <div class="tab-pane fade show active" id="os-content" role="tabpanel" aria-labelledby="os-tab">
                    <div class="card card-outline card-danger shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Database OS Blacklist</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalAddBlacklistOS">
                                    <i class="bi bi-plus-lg"></i> Tambah Blacklist OS
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
                            <table id="tableBlacklistOS" class="table table-bordered table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama Lengkap</th>
                                        <th>NIK</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Blacklist</th>
                                        <th>Alasan</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($blacklistedOS as $index => $emp)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-bold">{{ $emp->name }}</td>
                                            <td>{{ $emp->nik }}</td>
                                            <td>{{ $emp->gender }}</td>
                                            <td>{{ $emp->updated_at->format('d/m/Y') }}</td>
                                            <td>Pelanggaran K3 Berat (Data Dinamis)</td>
                                            <td class="text-center"><span class="badge bg-danger">Blacklist</span></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('hse.blacklist-os.detail') }}"
                                                        class="btn btn-info text-white" title="Detail"><i
                                                            class="bi bi-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="8" class="text-center">Tidak ada data blacklist OS.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab Content: Blacklist Vendor -->
                <div class="tab-pane fade" id="vendor-content" role="tabpanel" aria-labelledby="vendor-tab">
                    <div class="card card-outline card-danger shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Vendor Blacklist</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalAddBlacklistVendor">
                                    <i class="bi bi-plus-lg"></i> Tambah Blacklist Vendor
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
                            <table id="tableBlacklistVendor" class="table table-bordered table-hover align-middle w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama Vendor</th>
                                        <th>Nama PIC</th>
                                        <th>Tanggal Blacklist</th>
                                        <th>Alasan</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($blacklistedVendors as $index => $vendor)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-bold">{{ $vendor->name }}</td>
                                            <td>{{ $vendor->pic_name ?? 'PIC Unknown' }}</td> // Asumsi pic_name
                                            <td>{{ $vendor->updated_at->format('d/m/Y') }}</td>
                                            <td>Kinerja Buruk (Data Dinamis)</td>
                                            <td class="text-center"><span class="badge bg-danger">Blacklist</span></td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('hse.blacklist-vendor.detail') }}"
                                                        class="btn btn-info text-white" title="Detail"><i
                                                            class="bi bi-eye"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center">Tidak ada vendor blacklist.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Blacklist OS -->
    <div class="modal fade" id="modalAddBlacklistOS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Tambah Blacklist OS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBlacklistOS">
                        <div class="mb-3">
                            <label for="osInput" class="form-label">Nama Pegawai / NIK</label>
                            <!-- Changed to Input Text for Autocomplete -->
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="osInput" placeholder="Ketik Nama atau NIK..."
                                    autocomplete="off">
                            </div>
                            <div class="form-text">Cari berdasarkan Nama atau No. Induk Karyawan.</div>
                        </div>
                        <div class="mb-3">
                            <label for="osReason" class="form-label">Alasan Blacklist</label>
                            <textarea class="form-control" id="osReason" rows="3" required
                                placeholder="Contoh: Melanggar aturan K3..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnSaveBlacklistOS">Simpan Blacklist</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Blacklist Vendor -->
    <div class="modal fade" id="modalAddBlacklistVendor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Tambah Blacklist Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBlacklistVendor">
                        <div class="mb-3">
                            <label for="vendorInput" class="form-label">Nama Vendor</label>
                            <!-- Changed to Input Text for Autocomplete -->
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" class="form-control" id="vendorInput" placeholder="Ketik Nama Vendor..."
                                    autocomplete="off">
                            </div>
                            <div class="form-text">Cari vendor dari database.</div>
                        </div>
                        <div class="mb-3">
                            <label for="vendorReason" class="form-label">Alasan Blacklist</label>
                            <textarea class="form-control" id="vendorReason" rows="3" required
                                placeholder="Contoh: Dokumen palsu..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="btnSaveBlacklistVendor">Simpan Blacklist</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery UI (Required for Autocomplete) -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Init DataTables
            var tableOS = $('#tableBlacklistOS').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 5,
                "columnDefs": [
                    { "className": "text-center", "targets": [6, 7] } // Index 6 (Status) & 7 (Aksi) text-center
                ]
            });
            var tableVendor = $('#tableBlacklistVendor').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 5,
                "columnDefs": [
                    { "className": "text-center", "targets": [5, 6] } // Index 5 (Status) & 6 (Aksi) text-center
                ]
            });

            // Data Sources (Dummy Database)
            // Data Sources (From Database)
            var availableOS = {!! json_encode($osAutocomplete) !!};
            var availableVendors = {!! json_encode($vendorAutocomplete) !!};

            // Init Autocomplete for OS
            $("#osInput").autocomplete({
                source: availableOS,
                minLength: 0, // Enable showing all if needed? No, user wants search.
                appendTo: "#modalAddBlacklistOS", // Append to modal so it appears above it (z-index fix)
                autoFocus: true
            });

            // Init Autocomplete for Vendor
            $("#vendorInput").autocomplete({
                source: availableVendors,
                minLength: 0,
                appendTo: "#modalAddBlacklistVendor",
                autoFocus: true
            });

            // Handle Save Blacklist OS
            $('#btnSaveBlacklistOS').click(function () {
                var name = $('#osInput').val();
                var reason = $('#osReason').val();

                if (!name || !reason) {
                    Swal.fire('Error', 'Harap lengkapi semua form!', 'error');
                    return;
                }

                // Optional: Validate if name exists in list (Strict Mode)
                // if (!availableOS.includes(name)) { ... }
                // For now, let's allow free text or exact match as per user story "semisal mau tambah blacklist bisa menambahkan nama"

                Swal.fire({
                    title: 'Konfirmasi Blacklist',
                    text: "Apakah Anda yakin ingin mem-blacklist " + name + " dengan alasan: " + reason + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Blacklist!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Berhasil!', 'Data ' + name + ' telah ditambahkan ke daftar blacklist.', 'success');
                        $('#modalAddBlacklistOS').modal('hide');
                        // Add dummy row
                        // Try to split name and nik if format "Name - NIK"
                        var namePart = name;
                        var nikPart = "Unknown";
                        if (name.includes(" - ")) {
                            var parts = name.split(" - ");
                            namePart = parts[0];
                            nikPart = parts[1];
                        }

                        // Get current row count for numbering
                        var rowCount = tableOS.rows().count();

                        tableOS.row.add([
                            rowCount + 1, // Auto-increment number
                            '<span class="fw-bold">' + namePart + '</span>', // Bold Name
                            nikPart,
                            'Laki-laki',
                            '{{ date("d/m/Y") }}',
                            reason,
                            '<span class="badge bg-danger">Blacklist</span>',
                            '<div class="btn-group btn-group-sm"><a href="{{ route("hse.blacklist-os.detail") }}" class="btn btn-info text-white" title="Detail"><i class="bi bi-eye"></i></a></div>'
                        ]).draw(false);
                        // Reset Form
                        $('#formBlacklistOS')[0].reset();
                    }
                });
            });

            // Handle Save Blacklist Vendor
            $('#btnSaveBlacklistVendor').click(function () {
                var vendor = $('#vendorInput').val();
                var reason = $('#vendorReason').val();

                if (!vendor || !reason) {
                    Swal.fire('Error', 'Harap lengkapi semua form!', 'error');
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Blacklist',
                    text: "Apakah Anda yakin ingin mem-blacklist " + vendor + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Blacklist!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Berhasil!', 'Vendor ' + vendor + ' telah ditambahkan ke daftar blacklist.', 'success');
                        $('#modalAddBlacklistVendor').modal('hide');

                        // Get current row count for numbering
                        var rowCount = tableVendor.rows().count();

                        // Add dummy row
                        tableVendor.row.add([
                            rowCount + 1, // Auto-increment number
                            '<span class="fw-bold">' + vendor + '</span>', // Bold Vendor Name
                            'PIC Baru',
                            '{{ date("d/m/Y") }}',
                            reason,
                            '<span class="badge bg-danger">Blacklist</span>',
                            '<div class="btn-group btn-group-sm"><a href="{{ route("hse.blacklist-vendor.detail") }}" class="btn btn-info text-white" title="Detail"><i class="bi bi-eye"></i></a></div>'
                        ]).draw(false);
                        // Reset Form
                        $('#formBlacklistVendor')[0].reset();
                    }
                });
            });
        });
    </script>
@endpush