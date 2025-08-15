<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'receipt_no',
        'amount',
        'payment_status',
        'order_id',
        'payment_id',
        'payment_date',
        'active_until',
        'currency',
        'type'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }
    public function plan()
    {
        return $this->belongsTo(Plans::class, 'package_id', 'id');
    }
    public function getUserDetails()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
