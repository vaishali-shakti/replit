<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'original_image',
        'image'
    ];
    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/banners/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/banners/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }

   
    public function getImageUrlAttribute()
    {
        // Assuming images are stored in 'storage/app/public/banners'
        return asset('storage/banners/' . $this->image);
    }
}
