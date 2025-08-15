<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'support_id',
        'action_by',
        'message',
        'is_read'
    ];

    public function getUser(){
        return $this->hasOne(User::class,'id','action_by');
    }
    public function getSupport(){
        return $this->belongsTo(Supporter::class,'support_id','id');
    }
}
