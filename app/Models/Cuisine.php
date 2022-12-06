<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuisine extends Model
{
    use HasFactory,SoftDeletes,Translatable;
    protected $table = 'cuisines';
    public $translatedAttributes = ['name'];
    protected $hidden=['translations','updated_at','deleted_at'];


}
