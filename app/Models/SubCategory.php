<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $appends = ['average_rating'];

    protected $table = 'subcategory';
    protected $fillable = [
        'cat_id',
        'name',
        'image',
        'original_image',
        'audio',
        'video',
        'description',
        'payment_type',
        'meta_title',
        'keyword',
        'meta_description',
        'canonical',
        'audio_duration',
        'order_by',
        'is_added_in_sitemap'
    ];
    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/subcategory/images/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/subcategory/images/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }
    // public function getAudioAttribute($value)
    // {
    //     if ($value) {
    //         $audioPath = public_path('storage/subcategory/audio/' . $value);

    //         if (file_exists($audioPath)) {
    //             return url('storage/subcategory/audio/' . $value);
    //         }

    //         return url('audio/noaudio.mp3');
    //     }

    //     // return url('audio/noaudio.mp3');
    // }

        // public function getVideoAttribute($value)
        // {
        //     if ($value) {
        //         $videoPath = public_path('storage/subcategory/video/' . $value);

        //         if (file_exists($videoPath)) {
        //             return url('storage/subcategory/video/' . $value);
        //         }

        //         return url('videos/novideo.mp4');
        //     }

        //     // return url('videos/novideo.mp4');
        // }

    protected $casts = [
        'cat_id' => 'integer',
    ];

    public function main_category()
    {
        return $this->belongsTo(MainCategory::class, 'cat_id', 'id');
    }
    public function packages()
    {
        return $this->hasMany(Package::class, 'sub_cat_id', 'id');
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

    public function ratings()
    {
        return $this->hasMany(Rating::class,'sub_cat_id','id');
    }

    public function getAverageRatingAttribute()
    {
        $avg_rating  = $this->ratings()->avg('rating') ?? "5";
        return ($avg_rating == floor($avg_rating)) ? number_format($avg_rating, 0) : number_format($avg_rating, 1);
        // return $this->ratings()->avg('rating') ?? "5";
    }

    public function likedCategories(){
        return $this->hasMany(Like::class,'sub_cat_id','id');
    }
}
