<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel Vendors (Master Perusahaan)
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('pic_name');
            $table->string('phone_number');
            $table->text('notes')->nullable();

            // Status: 'active', 'blacklisted'
            $table->string('status')->default('active');

            $table->timestamps();
            $table->softDeletes(); // Agar data tidak hilang permanen
        });

        // 2. Modifikasi Users (jika perlu field tambahan role & relasi vendor)
        // Kita asumsikan tabel users bawaan Laravel sudah ada, kita tambah field saja
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                // Role: 'admin', 'hse', 'corsec', 'vendor_user'
                $table->string('role')->default('vendor_user');

                // Relasi ke Vendor (jika role = vendor_user)
                $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn(['role', 'vendor_id']);
            });
        }
        Schema::dropIfExists('vendors');
    }
};
