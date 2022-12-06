<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartOption extends Model
{
    use HasFactory,SoftDeletes;
    protected $hidden=['updated_at','deleted_at'];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function option(){
        return $this->belongsTo(OptionValue::class,'option_value_id','id');
    }

}
