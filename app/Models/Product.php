<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'main_category_id', 'sub_category_id', 'name_ar', 'name_en', 'description_ar',
        'description_en', 'price', 'is_active','company_id'
    ];

        protected $appends = ['name', 'description', 'unit'];

   
    public function Company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function MainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id');
    }

    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function image()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function getUnitAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            return $this->unit_ar;
        } else {
            return $this->unit_en;
        }
    }

  
    public function getNameAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            return $this->name_ar;
        } else {
            return $this->name_en;
        }
    }

    public function getDescriptionAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            return $this->description_ar;
        } else {
            return $this->description_en;
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
