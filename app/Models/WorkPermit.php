<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkPermit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'induction_schedule' => 'datetime',
        'safety_checklist' => 'array', // Konversi JSON otomatis ke Array PHP
    ];

    // Status Constants
    const STATUS_DRAFT = 'draft';
    const STATUS_WAITING_CORSEC = 'waiting_corsec';
    const STATUS_WAITING_HSE = 'waiting_hse';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_ACTIVE = 'active';
    const STATUS_REJECTED = 'rejected';
    const STATUS_EXPIRED = 'expired';
    const STATUS_FINISHED = 'finished'; // Selesai Normal

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'work_permit_employees')
            ->withPivot('induction_status')
            ->withTimestamps();
    }

    // Accessor: Warna Badge Status (Biar bisa dipanggil dimana saja)
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'bg-secondary',
            self::STATUS_WAITING_CORSEC => 'bg-warning text-dark',
            self::STATUS_WAITING_HSE => 'bg-info text-dark',
            self::STATUS_SCHEDULED => 'bg-primary',
            self::STATUS_ACTIVE => 'bg-success',
            self::STATUS_REJECTED => 'bg-danger',
            self::STATUS_EXPIRED => 'bg-danger',
            self::STATUS_FINISHED => 'bg-secondary',
            default => 'bg-light text-dark',
        };
    }

    // Accessor: Label Status Manusiawi
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_WAITING_CORSEC => 'Verifikasi Corsec',
            self::STATUS_WAITING_HSE => 'Review HSE',
            self::STATUS_SCHEDULED => 'Jadwal Induction',
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_REJECTED => 'Ditolak',
            self::STATUS_EXPIRED => 'Kadaluarsa',
            self::STATUS_FINISHED => 'Selesai',
            default => 'Unknown',
        };
    }
}
