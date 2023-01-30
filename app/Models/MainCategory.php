<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class MainCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar', 'name_en', 'image', 'deliver_from', 'deliver_to', 'estimate_time'
    ];

    protected $appends = ['name'];


    public function getNameAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            return $this->name_ar;
        } else {
            return $this->name_en;
        }
    }

    public function DeliveryTime()
    {
        return $this->hasMany(DeliveryTime::class, 'main_category_id');
    }


    public function Orders()
    {
        return $this->hasMany(Order::class, 'main_category_id');
    }

    public function OrdersDelivered()
    {
        return $this->hasMany(Order::class, 'main_category_id')->where('type','Delivered');
    }



    public function OrdersDetails()
    {
        return $this->hasManyThrough(OrderDetails::class, Order::class, 'main_category_id', 'order_id')->where('orders.type','Delivered');
    }

    public function OrdersDetailsSum()
    {
        return $this->hasManyThrough(OrderDetails::class, Order::class, 'main_category_id', 'order_id')->sum('price');
    }

    public function SubCategories()
    {
        return $this->hasMany(SubCategory::class, 'main_category_id');
    }

    public function Products()
    {
        return $this->hasMany(Product::class, 'main_category_id');
    }

    public function getImageAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/MainCategory') . '/' . $image;
        }
        return asset('uploads/MainCategory/default.jpg');
    }

    public function setImageAttribute($image)
    {
        if (is_file($image)) {
            $imageFields = upload($image, 'MainCategory');
            $this->attributes['image'] = $imageFields;
        }
    }

    public function getIconAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/MainCategory/Icon') . '/' . $image;
        }
        return "";
    }


    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }


        return parent::castAttribute($key, $value);
    }

}
