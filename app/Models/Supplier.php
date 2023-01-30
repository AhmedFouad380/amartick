<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Supplier extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','image','email','phone','address','is_active','parent_id','type','password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Parent()
    {
        return $this->belongsTo(Supplier::class, 'parent_id');
    }

    public function employees()
    {
        return $this->hasMany(Supplier::class, 'parent_id');
    }

    public function Orders()
    {
        return $this->hasMany(Order::class, 'supplier_id');
    }


    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/suppliers') . '/' . $image;
        }
        return asset('uploads/admins/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'suppliers');
            $this->attributes['image'] = $imageFields;
        }
        return asset('uploads/admins/default.jpg');
    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }


        return parent::castAttribute($key, $value);
    }


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

}
