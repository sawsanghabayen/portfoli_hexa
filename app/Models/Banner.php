<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes;
    protected $hidden = ['updated_at', 'deleted_at'];

    public function getImageAttribute($value)
    {
        return url('uploads/images/banners/' . $value);
    }
    public function user(){
        return $this->belongsTo(Subadmin::class,'user_id','id');
    }

    public function scopeFilter($query)
    {
        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status',  request()->get('status'));
        }
        if (request()->has('user_id')) {
            if (request()->get('user_id') != null)
                $query->where('user_id',  request()->get('user_id'));
        }
    }

}
