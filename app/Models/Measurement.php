<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'record_id',
        'sys_bp1',
        'sys_bp2',
        'dia_bp1',
        'dia_bp2',
        'pulse1',
        'pulse2',
    ];
}
