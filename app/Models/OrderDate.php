<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class OrderDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'type', 'date'
    ];
    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        if ($locale = App::currentLocale() == "ar") {
            if ($this->type == 'Pending') {
                return 'تم ارسال الطلب ';
            } else if ($this->type == 'Accepted') {
                return 'تم قبول  الطلب  ';
            } else if ($this->type == 'Paid') {
                return 'تم عملية الدفع لطلبكم  ';
            } else if ($this->type == 'Delivered') {
                return 'تم توصيل طلبكم  ';
            } else if ($this->type == 'Cancelled') {
                return 'تم الغاء طلبكم  ';
            } else if ($this->type == 'Deligated') {
                return 'تم تعيين مندوب للطلبية  ';
            }
        } else {
            if ($this->type == 'Pending') {
                return 'Your Order is pending';
            } else if ($this->type == 'Accepted') {
                return 'Your Order is Accepted';
            } else if ($this->type == 'Paid') {
                return ' Your Order is Paid ';
            } else if ($this->type == 'Delivered') {
                return 'Your Order is Delivered';
            } else if ($this->type == 'Cancelled') {
                return 'Your Order is Cancelled';
            } else if ($this->type == 'Deligated') {
                return 'Deligate Has Been Added to Order';
            }
        }
    }

    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }
        return parent::castAttribute($key, $value);
    }
}
