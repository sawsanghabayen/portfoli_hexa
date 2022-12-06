<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory,SoftDeletes;
    protected $hidden=['updated_at','deleted_at'];


    public function options(){
        return $this->hasMany(CartOption::class)->withTrashed();
    }

    public function extras(){
        return $this->hasMany(CartExtra::class)->withTrashed();
    }

    public function meal(){
        return $this->belongsTo(Meal::class)->withTrashed();
    }


}
