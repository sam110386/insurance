<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
	protected $table = 'admin_users';
    public function notes()
    {
        return $this->hasMany('App\Models\Note');
    }

    public function by_who()
    {
        return $this->belongsTo('App\Models\AdminUser', 'created_by' , 'id');
    }    
}
