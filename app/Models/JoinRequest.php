<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JoinRequest extends Model
{
    use HasFactory  , SoftDeletes;

    protected $hidden = ['updated_at'];


    public function scopeFilter($query)
    {
        if (request()->has('name') ) {
            if (request()->get('name') != null)
                $query->where('name', 'like', '%' . request()->get('name') . '%');
        }

        if (request()->has('email') ) {
            if (request()->get('email') != null)
                $query->where('email', 'like', '%' . request()->get('email') . '%');
        }

        if (request()->has('mobile') ) {
            if (request()->get('mobile') != null)
                $query->where('mobile', 'like', '%' . request()->get('mobile') . '%');
        }


        if (request()->has('description') ) {
            if (request()->get('description') != null)
                $query->where('description', 'like', '%' . request()->get('description') . '%');
        }

        if (request()->has('is_read')) {
            if (request()->get('is_read') != null)
                $query->where('is_read', request()->get('is_read'));
        }


    }

}
