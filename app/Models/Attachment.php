<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

protected $fillable = ['file','supplier_id'];
    public function getFileAttribute($image)
    {

        if (!empty($image)) {
            return asset('uploads/attachments') . '/' . $image;
        }
        return "";
    }

    public function setFileAttribute($image)
    {

        if (is_file($image)) {
            $imageFields = upload($image, 'attachments');
            $this->attributes['file'] = $imageFields;

        }

    }

}
