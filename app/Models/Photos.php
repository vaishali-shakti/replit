<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    use HasFactory;

    protected $table = 'photos';

  
    protected $fillable = [
        'image',
        'original_image',
    ];


    public $timestamps = true;   use HasFactory;
    
    
    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/photos/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/photos/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }
}
