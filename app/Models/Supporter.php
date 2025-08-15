<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supporter extends Model
{
    protected $table = 'supporter';

    protected $fillable = [
        'user_id',
        'msg_status',
        'ticket_no'
    ];

    public function getUser(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function latestMsg()
    {
        return $this->hasOne(Messages::class,'support_id', 'id')->whereHas('getUser',function($que) {
            $que->whereNotIn('role_id',[1,2]);
        })->orderBy('created_at','desc');
    }
}

