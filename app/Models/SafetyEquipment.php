<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyEquipment extends Model
{
    use HasFactory;

    protected $table = 'safety_equipments';
    protected $guarded = ['id'];
}
