@extends('layouts.admin')

@section('title', 'Safety Induction Schedule')

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Jadwal Safety Induction</h3>
                    <p class="text-muted mb-0">Kelola jadwal dan validasi safety induction vendor</p>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('hse.work_permit_history') }}" class="btn btn-secondary">
                        <i class="bi bi-clock-history"></i> History
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Daftar Jadwal Safety Induction</h3>
                    <div class="card-tools d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-success btn-sm" id="btnBulkUpload" disabled>
                            <i class="bi bi-file-earmark-arrow-up-fill"></i> Upload Massal (<span
                                id="selectedCount">0</span>)
                        </button>
                        <button type="button" class="btn btn-tool" title="Filter">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        <button type="button" class="btn btn-tool" title="Export">
                            <i class="bi bi-cloud-download"></i> Export
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableInduction" class="table table-bordered table-hover align-middle w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center" width="5%">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                    </th>
                                    <th class="text-center" width="5%">No</th>
                                    <th>No. Dokumen WP</th>
                                    <th>No. Izin Kerja Berbahaya</th>
                                    <th>Nama Pemohon</th>
                                    <th>Perusahaan</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Jadwal Induction</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data 1: Siap Induction -->
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input row-checkbox" value="1">
                                    </td>
                                    <td class="text-center">1</td>
                                    <td class="fw-bold text-dark">WP-2024-003</td>
                                    <td><a href="#" class="text-primary fw-bold text-decoration-none">WP-2024-003/L/01</a>
                                    </td>
                                    <td>Rudi Hartono</td>
                                    <td>PT. Sejahtera</td>
                                    <td><span class="badge bg-secondary">Pekerjaan Listrik</span></td>
                                    <td>16 Jan 2024 09:00</td>
                                    <td class="text-center">
                                        <span class="badge bg-success">Siap Induction</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('hse.work_permit.detail', ['id' => 3, 'status' => 'Scheduled', 'type' => 'Pekerjaan Listrik', 'schedule' => '2024-01-16 09:00']) }}"
                                            class="btn btn-sm btn-success text-white" title="Validasi / Upload Bukti">
                                            <i class="bi bi-upload"></i>
                                        </a>
                                    </td>
                                </tr>

                                <!-- Generated Dummy Data for Pagination (All Siap Induction) -->
                                @php
                                    $types = ['Pekerjaan Listrik', 'Bekerja di Ketinggian', 'Kerja Panas', 'Ruang Terbatas'];
                                    $vendors = ['PT. Cipta Karya', 'CV. Bangun Sarana', 'PT. Tekno Global', 'CV. Inti Daya'];
                                @endphp

                                @for ($i = 2; $i <= 15; $i++)
                                    @php
                                        $randType = $types[array_rand($types)];
                                        $randVendor = $vendors[array_rand($vendors)];
                                        // Future dates for ready to induction
                                        $date = date('d M Y H:i', strtotime('+' . rand(1, 5) . ' days 09:00'));
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input row-checkbox" value="{{ $i }}">
                                        </td>
                                        <td class="text-center">{{ $i }}</td>
                                        <td class="fw-bold text-dark">WP-2024-{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td><a href="#"
                                                class="text-primary fw-bold text-decoration-none">WP-2024-{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}/GEN/01</a>
                                        </td>
                                        <td>User Dummy {{ $i }}</td>
                                        <td>{{ $randVendor }}</td>
                                        <td><span class="badge bg-secondary">{{ $randType }}</span></td>
                                        <td>{{ $date }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-success">Siap Induction</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-sm btn-success text-white"
                                                title="Validasi / Upload Bukti">
                                                <i class="bi bi-upload"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div class="modal fade" id="bulkUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-upload-fill me-2"></i> Upload Massal Dokumen
                        Induction</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-center mb-3">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            Anda akan mengunggah dokumen untuk <strong><span id="modalSelectedCount">0</span> Work
                                Permit</strong> terpilih.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="bulkFile" class="form-label fw-bold">Upload Dokumen (PDF/JPG)</label>
                        <input class="form-control" type="file" id="bulkFile" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Pastikan dokumen memuat bukti kehadiran/safety induction untuk seluruh WP
                            yang dipilih.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success fw-bold" id="btnConfirmBulkUpload">
                        <i class="bi bi-check-circle me-1"></i> Upload & Validasi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            var table = $('#tableInduction').DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "pagingType": "simple_numbers",
                "pageLength": 10,
                "columnDefs": [
                    { "orderable": false, "targets": 0 } // Disable ordering on checkbox column
                ],
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

            // Checkbox Logic
            $('#checkAll').on('click', function () {
                var isChecked = this.checked;
                $('.row-checkbox').prop('checked', isChecked);
                updateBulkButton();
            });

            $('#tableInduction tbody').on('change', '.row-checkbox', function () {
                updateBulkButton();
                // Update CheckAll status
                var allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#checkAll').prop('checked', allChecked);
            });

            function updateBulkButton() {
                var selectedCount = $('.row-checkbox:checked').length;
                $('#selectedCount').text(selectedCount);
                if (selectedCount > 0) {
                    $('#btnBulkUpload').removeAttr('disabled');
                } else {
                    $('#btnBulkUpload').attr('disabled', 'disabled');
                }
            }

            // Bulk Upload Button Click
            $('#btnBulkUpload').on('click', function () {
                var selectedCount = $('.row-checkbox:checked').length;
                $('#modalSelectedCount').text(selectedCount);
                new bootstrap.Modal(document.getElementById('bulkUploadModal')).show();
            });

            // Confirm Upload
            $('#btnConfirmBulkUpload').on('click', function () {
                var fileInput = document.getElementById('bulkFile');
                if (fileInput.files.length === 0) {
                    Swal.fire('Peringatan', 'Harap pilih file dokumen terlebih dahulu!', 'warning');
                    return;
                }

                // Simulate Upload
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mengupload dan memvalidasi dokumen...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    timer: 2000,
                    willClose: () => {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Dokumen berhasil diupload. ' + $('#selectedCount').text() + ' Work Permit telah divalidasi.',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    }
                });
            });
        });
    </script>
@endpush