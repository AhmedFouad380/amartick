<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\App;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_category_id', 'name_ar', 'name_en', 'image',
    ];
    protected $appends = ['name'];


    public function MainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function Products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }

    public function getNameAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            return $this->name_ar;
        } else {
            return $this->name_en;
        }
    }


    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/SubCategory') . '/' . $image;
        }
        return asset('uploads/SubCategory/default.jpg');

    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'SubCategory');
            $this->attributes['image'] = $imageFields;
        }
    }

    public function getIconAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/SubCategory') . '/' . $image;
        }
        return "";
    }
    public function setIconAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'SubCategory');
            $this->attributes['icon'] = $imageFields;
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
