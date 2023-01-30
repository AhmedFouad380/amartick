<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject

{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'image',
        'email',
        'phone',
        'address',
        'is_active',
        'is_verified',
        'parent_id',
        'type',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setEmailAttribute($value)
    {
        if (empty($value)) { // will check for empty string
            $this->attributes['email'] = NULL;
        } else {
            $this->attributes['email'] = $value;
        }
    }

    public function Parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function Projects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function Carts()
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function Orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/users') . '/' . $image;
        }
        return asset('uploads/admins/default.jpg');
    }

    public function setImageAttribute($image)
    {

        if (is_file($image)) {
            $imageFields = upload($image, 'users');
            $this->attributes['image'] = $imageFields;

        }

    }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }


        return parent::castAttribute($key, $value);
    }
}

