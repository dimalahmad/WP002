<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskWork extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'recommended_apd' => 'array',
        'recommended_safety' => 'array',
    ];
}
