<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory, Translatable;

    public $translatedAttributes = ['f_name','l_name','location','job'];
    protected $hidden=['translations','updated_at','deleted_at'];
    public function getActiveStatusAttribute()
    {
        return $this->freelance_active ? 'Available' : 'Disabled';
    }

    
public function getImageAttribute($value)
{
    return url('uploads/images/infos/' . $value);
}

}
