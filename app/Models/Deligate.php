<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deligate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'supplier_id'];


    public
    function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
