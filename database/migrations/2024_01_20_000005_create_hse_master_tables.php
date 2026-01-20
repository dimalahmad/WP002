<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel Master APD & Pengaman
        Schema::create('safety_equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // 'apd' or 'safety_device'
            $table->timestamps();
        });

        // 2. Tabel Master IKB (Instruksi Kerja Berbahaya / Jenis Pekerjaan)
        Schema::create('risk_works', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Kita simpan checklist preference sebagai JSON dulu agar simpel
            // Atau bisa many-to-many tapi JSON lebih cepat untuk prototype "data dinamis"
            $table->json('recommended_apd')->nullable();
            $table->json('recommended_safety')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_works');
        Schema::dropIfExists('safety_equipments');
    }
};
