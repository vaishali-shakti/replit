<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'sub_cat_id',
        'rating',
        'description'
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function subcat()
    {
        return $this->hasOne(SubCategory::class,'id','sub_cat_id');
    }
}
