<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    protected $table = 'vehicles';

    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser','user_id','id');
    }    
}
