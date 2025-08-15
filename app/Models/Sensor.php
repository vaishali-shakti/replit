<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'machine_id',
        'upload_file_name',
        'record_id',
        'file_name',
        'sensor_id'
    ];

    public function getPatientHospital(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
