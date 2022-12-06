<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['company_name','experience_name','description'];
    protected $hidden=['translations','updated_at','deleted_at'];
}
