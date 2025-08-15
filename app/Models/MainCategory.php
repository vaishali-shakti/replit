<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'main_category';

    protected $fillable = [
        'super_cat_id',
        'name',
        'image',
        'original_image',
        'description',
        'slug_name',
        'meta_title',
        'keyword',
        'meta_description',
        'canonical',
        'special_music',
        'order_by',
        'is_added_in_sitemap'
    ];
    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/main_category/images/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/main_category/images/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'cat_id', 'id');
    }

    public function packages()
    {
        return $this->hasMany(Package::class, 'cat_id', 'id');
    }

    public function super_category()
    {
        return $this->belongsTo(SuperCategory::class, 'super_cat_id', 'id');
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

    public function subCategory()
    {
        return $this->hasMany(SubCategory::class, 'cat_id', 'id');
    }

    // MainCategory belongs to SuperCategory
    public function superCategory()
    {
        return $this->belongsTo(SuperCategory::class, 'super_cat_id', 'id');
    }

}

