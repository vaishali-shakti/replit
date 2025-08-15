<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppBanner extends Model
{
    protected $table = 'appbanner'; 

    protected $fillable = [
        'title',
        'image',
        'description',
        'original_image',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/appbanner/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/appbanner/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }

}
