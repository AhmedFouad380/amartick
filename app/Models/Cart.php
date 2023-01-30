<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }

        return parent::castAttribute($key, $value);
    }
    protected $fillable = [
        'user_id', 'product_id', 'main_category_id'
    ];
    protected $appends  = ['estimateddate'];
    public function getEstimateddateAttribute()
    {
        $main_category = MainCategory::find($this->attributes['main_category_id']);

        $date = Carbon::now()->addHours($main_category->estimate_time);
    return     Carbon::parse($date)->format('Y-m-d');

    }
    public function Product(){

     return $this->belongsTo('App\Models\Product', 'product_id')->with('Company')->with('images');

    }

    public function MainCategory()
    {

        return $this->belongsTo('App\Models\MainCategory', 'main_category_id');

    }


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
