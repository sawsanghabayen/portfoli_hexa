<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    // use SoftDeletes;

    use HasFactory, Translatable;

    public $translatedAttributes = ['company_name','education_name','description'];
    protected $hidden=['translations','updated_at','deleted_at'];
}
