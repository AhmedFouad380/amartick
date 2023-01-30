<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchAccount extends Model
{
    use HasFactory;
    protected $fillable = [
        'price', 'type', 'supplier_id', 'order_id', 'description', 'file'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',

    ];

    public function getFileAttribute($image)
    {
        if (!empty($image)){
            return asset('uploads/BranchAccount').'/'.$image;
        }
        return null;
    }

    public function setFileAttribute($image)
    {

        if (is_file($image)) {
            $imageFields = upload($image, 'BranchAccount');
            $this->attributes['file'] = $imageFields;

        }

    }

    public function Order(){
        return $this->belongsTo(Order::class , 'order_id');
    }

    public function Supplier(){
        return $this->belongsTo(Supplier::class , 'supplier_id');
    }
}
