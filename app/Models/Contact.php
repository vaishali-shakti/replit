<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    // Specify the table name, in case it's different from the default (plural of model name)
    protected $table = 'contact';

    // Specify which attributes are mass assignable
    protected $fillable = [
        'name',
        'email',
        'number',
        'message',
    ];

}
