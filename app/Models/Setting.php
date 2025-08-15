<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    // The name of the table (optional if the model name matches the table name)
    protected $table = 'settings';

    // The attributes that are mass assignable
    protected $fillable = [
        'title',
        'key',
        'value',
        'original_image',
        'type',
    ];
    public function getImageAttribute()
    {
        if ($this->original_image) {
            $imagePath = public_path('storage/setting/' . $this->value);

            // Return the URL if the file exists
            if (file_exists($imagePath)) {
                return url('storage/setting/' . $this->value);
            }
        }

        // Return a fallback image if no valid image is found
        return url('images/noimage.webp');
    }
    
}
