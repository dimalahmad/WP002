<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel Master Pegawai (OS)
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->onDelete('cascade');

            $table->string('name');
            $table->string('nik')->unique(); // Identitas Unik
            $table->string('gender'); // L/P
            $table->date('date_of_birth')->nullable();
            $table->string('blood_type')->nullable(); // A, B, AB, O
            $table->text('address')->nullable();

            // File Paths
            $table->string('photo_path')->nullable(); // Foto Wajah
            $table->string('ktp_path')->nullable();   // Scan KTP

            // Status Blacklist
            $table->boolean('is_blacklisted')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
