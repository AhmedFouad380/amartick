<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable,HasRoles;

    protected $fillable = [
        'name', 'image', 'email', 'phone', 'address', 'is_active','type',   'password'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getImageAttribute($image)
    {
        if (!empty($image)){
            return asset('uploads/admins').'/'.$image;
        }
        return asset('uploads/admins/default.jpg');
    }

    public function setImageAttribute($image)
    {

        if (is_file($image)) {
            $imageFields = upload($image, 'admins');
            $this->attributes['image'] = $imageFields;

        }

    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password)){
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
}
