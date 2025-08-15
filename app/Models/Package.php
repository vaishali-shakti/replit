<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'cat_id',
        'sub_cat_id',
        'name',
        'times_day',
        'days',
        'cost',
        'cost_usd',
        'cost_euro',
        'status',
        'packages_order_by',
    ];
    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'cat_id', 'id');
    }

    // Define the relationship to SubCategory
    public function subCategories()
    {
        return $this->belongsTo(SubCategory::class, 'sub_cat_id', 'id');
    }

    public function main_category()
    {
        return $this->belongsTo(MainCategory::class, 'cat_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_cat_id', 'id');
    }
}
