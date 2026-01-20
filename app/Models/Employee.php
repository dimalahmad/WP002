<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'name',
        'nik',
        'gender',
        'date_of_birth',
        'blood_type',
        'address',
        'photo_path',
        'ktp_path',
        'is_blacklisted'
    ];

    protected $casts = [
        'is_blacklisted' => 'boolean',
        'date_of_birth' => 'date'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // Relasi Many-to-Many dengan WP
    public function workPermits()
    {
        return $this->belongsToMany(WorkPermit::class, 'work_permit_employees')
            ->withPivot('induction_status')
            ->withTimestamps();
    }

    public function violations()
    {
        return $this->morphMany(Violation::class, 'violator');
    }
}
