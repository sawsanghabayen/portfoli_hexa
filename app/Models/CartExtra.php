<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartExtra extends Model
{
    use HasFactory,SoftDeletes;
    protected $hidden=['updated_at','deleted_at'];

    public function extra(){
        return $this->belongsTo(Extra::class)->withTrashed();
    }
}
