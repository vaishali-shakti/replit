<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuperCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'super_category';

    protected $fillable = [
        'name',
        'slug_name',
        'meta_title',
        'keyword',
        'description',
        'canonical',
        'order_by',
        'is_added_in_sitemap'
    ];

        // public function mainCategories()
        // {
        //     return $this->hasMany(MainCategory::class, 'super_cat_id', 'id');
        // }
        // public function subCategories()
        // {
        //     return $this->hasMany(SubCategory::class, 'cat_id', 'id');
        // }
    public function mainCategories()
    {
        return $this->hasMany(MainCategory::class, 'super_cat_id', 'id');
    }

    // SuperCategory has many SubCategories (directly, without going through MainCategory)
    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'cat_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug_name = static::generateUniqueSlug($model->name);
        });

        static::updating(function ($model) {
            $model->slug_name = static::generateUniqueSlugUpdate($model->name, $model->id);
        });
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = 2;

        while (static::where('slug_name', $slug)->exists()) {
            $slug = Str::slug($title).'-'.$count++;
        }
        return $slug;
    }

    protected static function generateUniqueSlugUpdate($title, $id)
    {
        $slug = Str::slug($title);
        $count = 2;
        // Check for uniqueness, excluding the current model by ID
        while (static::where('slug_name', $slug)->where('id', '!=', $id)->exists()) {
            $slug = Str::slug($title).'-'.$count++;
        }
        return $slug;
    }
}

