<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersOrders extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id','order_id','status'];

     public function supplier()
     {
         return $this->belongsTo(Supplier::class, 'supplier_id');
     }

     public function order()
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
