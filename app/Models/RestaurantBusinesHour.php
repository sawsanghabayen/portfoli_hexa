<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RestaurantBusinesHour extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $hidden = ['updated_at', 'created_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(Subadmin::class,'user_id');
    }

    public function getFromAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function getToAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

}
