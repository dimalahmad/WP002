<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel Work Permits (Header Transaksi)
        Schema::create('work_permits', function (Blueprint $table) {
            $table->id();

            // Penomoran
            $table->string('doc_no')->unique(); // WP-2024-xxx

            // Relasi
            $table->foreignId('vendor_id')->constrained('vendors');

            // Detail Pekerjaan
            // 'Kerja Panas', 'Bekerja di Ketinggian', etc.
            $table->string('work_type');
            $table->text('work_description');
            $table->string('location');

            // Waktu
            $table->date('start_date');
            $table->date('end_date');

            // Status Workflow
            // 'draft', 'waiting_corsec', 'waiting_hse', 'scheduled', 'active', 'rejected', 'expired', 'finished'
            $table->string('status')->default('draft');

            // Alasan Penolakan (Jika ada)
            $table->text('rejection_note')->nullable();

            // --- Fitur HSE: Safety Induction & Validasi ---

            // Jadwal yang ditentukan HSE
            $table->dateTime('induction_schedule')->nullable();

            // Bukti File Induction (PDF/JPG) yang diupload User
            $table->string('induction_evidence_path')->nullable();

            // Tanda Tangan Validasi HSE (Canvas Base64 atau Path)
            $table->text('hse_validation_signature')->nullable();

            // Checklist K3 (JSON)
            // Menyimpan state checkbox: { "apd": ["Helmet", "Shoes"], "safety": ["Line", "APAR"] }
            $table->json('safety_checklist')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_permits');
    }
};
