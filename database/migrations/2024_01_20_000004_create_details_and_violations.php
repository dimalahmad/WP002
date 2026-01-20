<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel Pivot: Work Permit <-> Employees
        // Menentukan siapa saja yang bekerja di WP ini
        Schema::create('work_permit_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_permit_id')->constrained('work_permits')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');

            // Status Personal per Pegawai di WP ini (Opsional, tapi bagus untuk tracking individu)
            // Misal: employee A lulus induction, employee B gagal/sakit
            $table->string('induction_status')->default('pending'); // 'pending', 'passed', 'failed'

            $table->timestamps();
        });

        // Tabel Pelanggaran (Blacklist History)
        Schema::create('violations', function (Blueprint $table) {
            $table->id();

            // Polimorfik: Bisa Vendor yang melanggar, atau Employee
            $table->string('violator_type'); // 'App\Models\Vendor' atau 'App\Models\Employee'
            $table->unsignedBigInteger('violator_id');

            $table->date('violation_date');
            $table->string('severity'); // 'Ringan', 'Sedang', 'Berat/Blacklist'
            $table->text('description');
            $table->text('sanction'); // 'Teguran', 'SP1', 'Blacklist 1 Tahun'

            // Status Pelanggaran: 'active' (sedang dihukum), 'resolved' (sudah selesai)
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
        Schema::dropIfExists('work_permit_employees');
    }
};
