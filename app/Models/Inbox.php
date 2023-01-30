<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'message', 'file', 'inbox_id', 'sender_id', 'receiver_id', 'type',
        'is_read', 'sender_type', 'receiver_type','order_id','is_order'
    ];

    protected $dispatchesEvents = [
        'created'=>'App\Events\InboxCreated'
    ];

    protected $hidden = ['file'];
    protected $with = ['files'];
    public $timestamps = false;


    protected $casts = [
        'is_read' => 'integer',
        'created_at' => 'datetime:Y-m-d h:i',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function files()
    {
        return $this->hasMany(InboxFile::class, 'inbox_id');
    }

    public function inboxes()
    {
        return $this->hasOne(Inbox::class);
    }

    public function scopeRoot($query)
    {
        return $query->where('inbox_id', null);
    }

    public function childreninboxes()
    {
        return $this->hasMany(Inbox::class)->with('inboxes')->orderBy('id','desc');
    }


    public function getFileAttribute($image)
    {

        if (!empty($image)) {
            return asset('uploads/inboxes') . '/' . $image;
        }
        return "";
    }

    public function setFileAttribute($image)
    {

        if (is_file($image)) {
            $imageFields = upload($image, 'inboxes');
            $this->attributes['file'] = $imageFields;

        }

    }


    public function getSender()
    {

        if ($this->attributes['sender_type'] == "admin") {
            return $this->hasOne('App\Models\Admin', 'id', 'sender_id');
        } elseif ($this->attributes['sender_type'] == "user") {
            return $this->hasOne('App\Models\User', 'id', 'sender_id');
        } else {
            return $this->hasOne('App\Models\Supplier', 'id', 'sender_id');
        }
    }


    public function getReciever()
    {

        if ($this->attributes['receiver_type'] == "admin") {
            return $this->hasOne('App\Models\Admin', 'id', 'receiver_id');
        } elseif ($this->attributes['receiver_type'] == "user") {
            return $this->hasOne('App\Models\User', 'id', 'receiver_id');
        } else {
            return $this->hasOne('App\Models\Supplier', 'id', 'receiver_id');

        }

    }

}
