<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['name','client'];
    protected $hidden=['translations','updated_at','deleted_at'];

    public function getImageAttribute($value)
    {
        return url('uploads/images/projects/' . $value);
    }

    public function images()
    {
        
        return $this->morphMany(Image::class, 'object', 'object_type', 'object_id', 'id');

    }

    public function getMainImageAttribute()
    {
        return $this->images()->first()->name ?? '';
    }

}
