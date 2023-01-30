<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetails;
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'area', 'description', 'lat', 'lng', 'employee_id', 'manager_id'
    ];

    protected $appends = [
        'totalWallet','totalPayed','TotalWalletPayed','TotalVisaPayed','TotalProduct'
    ];
    public function Wallet(){
        return $this->hasMany(Wallet::class,'project_id');
    }
    public function getTotalWalletAttribute(){
        $deposit =Wallet::where('project_id',$this->attributes['id'])->where('type','deposit')->sum('price');
        $withdrawal = Wallet::where('project_id',$this->attributes['id'])->where('type','withdrawal')->sum('price');
        return $deposit - $withdrawal;
    }
    public function CancelOrders(){
        return $this->hasMany(Order::class,'project_id')->where('type','Cancelled');
    }
    public function CancelOrdersByClient(){
        return $this->hasMany(Order::class,'project_id')->where('cancel_by',2)->where('type','Cancelled');
    }
    public function CancelOrdersBySytem(){
        return $this->hasMany(Order::class,'project_id')->where('cancel_by',1)->where('type','Cancelled');
    }
    public function DeliveredOrders(){
        return $this->hasMany(Order::class,'project_id')->where('type','Delivered');
    }
    public function getTotalPayedAttribute(){
        return Order::where('project_id',$this->attributes['id'])->where('type','Delivered')->sum('total_price');
    }
    public function getTotalVisaPayedAttribute(){
        return Order::where('project_id',$this->attributes['id'])->where('type','Delivered')->where('payment_type','visa')->sum('total_price');
    }
    public function getTotalWalletPayedAttribute(){
        return Order::where('project_id',$this->attributes['id'])->where('type','Delivered')->where('payment_type','wallet')->sum('total_price');
    }
    public function getTotalProductAttribute(){
        $Order = Order::where('project_id',$this->attributes['id'])->where('type','Delivered')->pluck('id');
        
        $key = OrderDetails::whereIn('order_id',$Order)->sum('count');
        return $key + 0;
    }
//   public function getTotalProductAttribute(){
//         return OrderDetails::where('project_id',$this->attributes['id'])->distinct('product_id')->count();
//     }
    public function Manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function Employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }


        return parent::castAttribute($key, $value);
    }

}
