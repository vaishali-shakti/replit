<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cms extends Model
{
    use HasFactory;

    protected $table = 'cms';

    protected $fillable = [
        'title',
        'slug_name',
        'image',
        'original_image',
        'description',
    ];

    // Automatically generate the slug before creating or updating the model
    protected static function boot()
    {
        parent::boot();

        // Automatically generate a slug when creating a new model instance
        static::creating(function ($model) {
            if (empty($model->slug_name)) {
                $model->slug_name = self::generateUniqueSlug($model->title);
            }
        });

        // Automatically generate a new slug when updating the model
        static::updating(function ($model) {
            if (empty($model->slug_name) || $model->isDirty('title')) {
                $model->slug_name = self::generateUniqueSlugUpdate($model->title, $model->id);
            }
        });
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/cms/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/cms/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = 2;

        while (static::where('slug_name', $slug)->exists()) {
            $slug = Str::slug($title) . '-' . $count++;
        }
        return $slug;
    }

    protected static function generateUniqueSlugUpdate($title, $id)
    {
        $slug = Str::slug($title);
        $count = 2;

        // Check for uniqueness, excluding the current model by ID
        while (static::where('slug_name', $slug)->where('id', '!=', $id)->exists()) {
            $slug = Str::slug($title) . '-' . $count++;
        }
        return $slug;
    }
}
