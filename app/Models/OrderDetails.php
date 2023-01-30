<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class OrderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id','product_id','name_ar','name_en','price','count'
    ];
    protected $appends = [
        'totalPrice','name'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function getTotalPriceAttribute(){
        return $this->price * $this->count;
    }
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id')->with('images')->with('Company');
    }



    public function getNameAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            return $this->name_ar;
        } else {
            return $this->name_en;
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
