<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    // Relasi ke User Login
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi ke Pegawai OS
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Relasi ke Work Permit
    public function workPermits()
    {
        return $this->hasMany(WorkPermit::class);
    }

    // Relasi ke Pelanggaran (Polymorphic)
    public function violations()
    {
        return $this->morphMany(Violation::class, 'violator');
    }

    // Helper: Cek apakah Blacklist
    public function getIsBlacklistedAttribute()
    {
        return $this->status === 'blacklisted';
    }
}
