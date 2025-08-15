<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plans extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'plans';
    protected $fillable = [
        'name',
        'times_day',
        'days',
        'cost',
        'cost_usd',
        'cost_euro',
        'order_by',
    ];
}
