<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'dob',
        'time_of_birth',
        'place_of_birth',
        'mobile_number_1',
        'mobile_number_2',
        'discomfort',
        'image',
        'email',
        'password',
        'role_id',
        'oauth_id',
        'frequency',
        'start_date',
        'end_date',
        'timezone',
        'current_session_id',
        'parent_id',
        'user_limit'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            $imagePath = public_path('storage/users/' . $value);

            if (file_exists($imagePath)) {
                return url('storage/users/' . $value);
            }

            return url('images/noimage.webp');
        }

        return url('images/noimage.webp');
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function parentUser(){
        return $this->hasOne(User::class, 'id', 'parent_id');
    }
}
