# Sistem Manajemen Work Permit (Prototipe)

## 📌 Deskripsi Proyek
Aplikasi ini adalah **Sistem Manajemen Work Permit (Izin Kerja)** yang dikembangkan untuk kebutuhan manajemen izin kerja perusahaan. Sistem ini mendigitalkan proses pengajuan, verifikasi, dan persetujuan izin kerja yang melibatkan berbagai departemen (User, Corporate Secretary, dan HSE).

Aplikasi ini dibangun menggunakan **Laravel** dengan template **AdminLTE**, berfokus pada antarmuka pengguna (UI) yang bersih, responsif, dan mudah digunakan.

---

## 🆕 Update Terbaru (Januari 2026)
*   **UI/UX Refactoring**: Perubahan tampilan pada Master Vendor dan Master OS. Tab navigasi dihapus digantikan dengan tampilan *Single Page Scroll* yang lebih informatif.
*   **Pemisahan Alur Edit**: Tombol "Edit" dipindahkan ke dalam halaman Detail/History untuk menjaga kebersihan tabel utama.
*   **Fitur Cetak**: Penambahan opsi cetak dokumen Work Permit dan HSE Induction pada halaman detail.

---

## 🚀 Fitur Utama

Sistem ini dibagi menjadi 3 peran utama (Role):

### 1. 👷 User (Pemohon)
*   **Dashboard**: Melihat ringkasan Work Permit.
*   **Master Data**: Manajemen data Outsourcing (OS) dan Vendor (Edit, History, & Blacklist).
*   **Pengajuan Work Permit**: Membuat pengajuan izin kerja baru dengan fitur simulasi input pegawai otomatis.
*   **Cetak Dokumen**: Fitur pencetakan lengkap meliputi:
    *   **Work Permit**: Dokumen izin kerja untuk pegangan User/Vendor.
    *   **Bukti Safety Induction**: Sertifikat kelayakan K3 (Muncul setelah status valid).
    *   **ID Card**: Kartu identitas sementara pegawai dengan QR Code.
*   **History**: Melihat riwayat pengajuan izin kerja.

### 2. 🏢 Corsec (Corporate Secretary)
*   **Verifikasi Work Permit**: Menerima pengajuan dari User dan melakukan verifikasi administratif.
*   **E-Approval**: Fitur tanda tangan digital (Canvas) untuk menyetujui dokumen.
*   **Cetak ID Card**: Akses untuk mencetak ID Card bagi izin yang sudah valid.

### 3. 🛡️ HSE (Health, Safety, and Environment)
*   **Review Keselamatan**: Meninjau aspek keselamatan dari pengajuan izin kerja (Jenis pekerjaan berbahaya, dll).
*   **Safety Induction**: Penjadwalan dan validasi safety induction.
*   **Master Data K3**:
    *   Master APD (Alat Pelindung Diri).
    *   Master IKB (Izin Kerja Berbahaya).
    *   Master Pengaman.

---

## 🛠️ Teknologi yang Digunakan

*   **Framework**: [Laravel](https://laravel.com/) (PHP)
*   **Template Admin**: [AdminLTE 3.2](https://adminlte.io/)
*   **CSS Framework**: Bootstrap 5
*   **Icon Library**: Bootstrap Icons
*   **JavaScript Libs**:
    *   **jQuery** (Core logic)
    *   **DataTables** (Tabel interaktif dengan fitur Search/Pagination)
    *   **Select2** (Pilihan dropdown yang lebih baik)
    *   **SweetAlert2** (Notifikasi popup yang modern)
    *   **Chart.js / Signature Pad** (Fitur tanda tangan digital)
    *   **Google Charts API** (Generator QR Code untuk ID Card)

---

## 📂 Struktur Folder Penting

*   `routes/web.php` : Definisi rute aplikasi (dikelompokkan berdasarkan User, Corsec, dan HSE).
*   `resources/views/user/` : Halaman-halaman untuk role User.
*   `resources/views/corsec/` : Halaman-halaman untuk role Corsec.
*   `resources/views/hse/` : Halaman-halaman untuk role HSE.
*   `resources/views/layouts/` : Layout utama (Sidebar, Navbar, Footer).

---

## ⚙️ Instalasi & Menjalankan Aplikasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### Prasyarat
*   PHP >= 8.1
*   Composer
*   Node.js & NPM

### Langkah-langkah
1.  **Clone Repositori** (atau ekstrak file zip):
    ```bash
    git clone https://github.com/username/project-wp.git
    cd Project_WP
    ```

2.  **Install Dependensi PHP**:
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend**:
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment**:
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Atur konfigurasi database di file `.env` jika diperlukan (Meski saat ini data masih menggunakan *Dummy Data* statis di Controller/View).

5.  **Generate Key**:
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Server**:
    Cukup jalankan file batch yang telah disediakan di root direktori project:
    ```bash
    .\run_server.bat
    ```
    *Script ini otomatis akan membuka dua jendela terminal untuk Laravel Server dan Vite.*

7.  **Akses Aplikasi**:
    Buka browser dan kunjungi `http://127.0.0.1:8000`

---

## ⚠️ Catatan Penting
Saat ini, sebagian besar data yang ditampilkan di tabel adalah **Dummy Data** yang disimulasikan langsung di dalam View (`.blade.php`) untuk keperluan demonstrasi prototipe. Fitur Database akan diaktifkan sepenuhnya setelah koneksi driver SQL Server terkonfigurasi dengan benar.

---

**Dibuat dengan ❤️ dan ☕ oleh Pengembang**