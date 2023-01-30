<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'price', 'supplier_id', 'description', 'file',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',

    ];

    public function getFileAttribute($image)
    {
        if (!empty($image)) {
            return asset('uploads/RequestAccount') . '/' . $image;
        }
        return null;
    }

    public function setFileAttribute($image)
    {

        if (is_file($image)) {
            $imageFields = upload($image, 'RequestAccount');
            $this->attributes['file'] = $imageFields;

        }

    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
