<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use DateInterval;
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id', 'user_id', 'main_category_id', 'total_price', 'type',
        'delivery_date', 'delivery_time_id', 'project_id'
    ];

    protected $appends = ['isreorder', 'reorderTime', 'ReorderDate', 'CurrentDate', 'ProjectWallet','maxFlexibleDate'];
    protected $hidden = ['code'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'request_time' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
        'total_price' => 'double',
    ];


    public function getTotalPriceAttribute(){
                return round($this->attributes['total_price'],2);

    }
    public function getCurrentDateAttribute()
    {
        return \Carbon\Carbon::now('Asia/Riyadh')->toDateTimeString();
    }
    public function getMaxFlexibleDateAttribute(){
        if($this->attributes['is_flexible_time'] == 1){
            return Carbon::parse($this->attributes['delivery_date'])->addDays(Setting::find(1)->max_flexible_time)->format('Y-m-d');
        }else{
            return null;
        }
    }
    public function getProjectWalletAttribute()
    {
        $Deposit = Wallet::where('type', 'deposit')->where('project_id', $this->attributes['project_id'])->sum('price');
        $withdrawal = Wallet::where('type', 'withdrawal')->where('project_id', $this->attributes['project_id'])->sum('price');
        $total = $Deposit - $withdrawal;
        return $total;
    }

    public function getReorderTimeAttribute()
    {
        if($this->attributes['type'] == 'Pending'){
            $main_category = MainCategory::find($this->attributes['main_category_id']);
            $day = Carbon::parse($this->attributes['updated_at'])->format('l');
            $date = Carbon::parse($this->attributes['updated_at'])->addMinutes($main_category->max_time_reorder)->format('H:i');

            $workDay = WorkDays::where('day_en', 'like', $day)->first();
            if($workDay->is_holiday == 0 ) {
                if ($date > Carbon::parse($workDay->from)->format('H:i') && $date < Carbon::parse($workDay->to)->format('H:i')) {

                    $startTime = \Carbon\Carbon::parse($date);
                    $endTime = \Carbon\Carbon::parse(Carbon::now('Asia/Riyadh'));
                    $totalDuration = $startTime->diffInSeconds($endTime);

                }else{
                    $Nextday = Carbon::parse($this->attributes['updated_at'])->addDay()->format('l');
                    $NextworkDay = WorkDays::where('day_en', 'like', $Nextday)->first();

                    if($NextworkDay->is_holiday == 0){

                        $startTime = \Carbon\Carbon::parse($NextworkDay->from)->addDay();
                        $endTime = \Carbon\Carbon::parse(Carbon::now('Asia/Riyadh'));
                        $diffInMinutes = $startTime->diffInSeconds($endTime);
                        $totalDuration = $diffInMinutes  + ($main_category->max_time_reorder * 60 );

                    }else{
                        $Nextday1 = Carbon::parse($this->attributes['updated_at'])->addDays(2)->format('l');
                        $NextworkDay1 = WorkDays::where('day_en', 'like', $Nextday1)->first();
                        $startTime = \Carbon\Carbon::parse($NextworkDay1->from)->addDays(2);
                        $endTime = \Carbon\Carbon::parse(Carbon::now('Asia/Riyadh'));
                        $diffInMinutes = $startTime->diffInSeconds($endTime);
                        $totalDuration = $diffInMinutes  + ($main_category->max_time_reorder * 60 );
                    }
                }
            }else{
                $Nextday = Carbon::parse($this->attributes['updated_at'])->addDay()->format('l');
                $NextworkDay = WorkDays::where('day_en', 'like', $Nextday)->first();

                if($NextworkDay->is_holiday == 0){

                    $startTime = \Carbon\Carbon::parse($NextworkDay->from)->addDay();
                    $endTime = \Carbon\Carbon::parse(Carbon::now('Asia/Riyadh'));
                    $diffInMinutes = $startTime->diffInSeconds($endTime);
                    $totalDuration = $diffInMinutes  + ($main_category->max_time_reorder * 60 );
                }else{
                    $Nextday1 = Carbon::parse($this->attributes['updated_at'])->addDays(2)->format('l');
                    $NextworkDay1 = WorkDays::where('day_en', 'like', $Nextday1)->first();
                    $startTime = \Carbon\Carbon::parse($NextworkDay1->from)->addDays(2);
                    $endTime = \Carbon\Carbon::parse(Carbon::now('Asia/Riyadh'));
                    $diffInMinutes = $startTime->diffInSeconds($endTime);
                    $totalDuration = $diffInMinutes + ($main_category->max_time_reorder * 60 );

                }
            }

            return $totalDuration; // Output: 20
        }else{
            return 0;
        }
    }

    public function getReorderDateAttribute()
    {
        $main_category = MainCategory::find($this->attributes['main_category_id']);

        $date = Carbon::parse($this->attributes['updated_at'])->addMinutes($main_category->max_time_reorder)->toDateTimeString();


        return $date; // Output: 20

    }

    public function getIsreorderAttribute()
    {
        $main_category = MainCategory::find($this->attributes['main_category_id']);

        $date = Carbon::parse($this->attributes['updated_at'])->addMinutes($main_category->max_time_reorder);
        if (Carbon::now('Asia/Riyadh') > $date) {
//            $b = Order::find($this->attributes['id']);
//            $b->type="ReOrder";
//            $b->save();
            return true;
        } else {
            return false;
        }
    }


    public function MainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'main_category_id')->withDefault([
            'name'=>''
        ]);
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name'=>''
        ]);
    }

    public function deliveryTime()
    {
        return $this->belongsTo(DeliveryTime::class, 'delivery_time_id');
    }


    public function Project()
    {
        return $this->belongsTo(Project::class, 'project_id')->with('Employee')->with('Manager');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault([
            'name'=>''
        ]);
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id')->with('Product');
    }

    public function OrderDates()
    {
        return $this->hasMany(OrderDate::class, 'order_id');
    }

//    public function getTypeAttribute($type)
//    {
//         return trans('lang.'.$type);
//    }


    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'string' && is_null($value)) {
            return '';
        }


        return parent::castAttribute($key, $value);
    }
}
