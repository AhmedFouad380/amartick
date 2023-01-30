<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;

    protected function castAttribute($key, $value)
        {
            if ($this->getCastType($key) == 'string' && is_null($value)) {
                return '';
            }

            return parent::castAttribute($key, $value);
    }
}
