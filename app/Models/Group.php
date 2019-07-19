<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $fillable = ['name', 'manager_id'];
	public function members()
    {
        return $this->hasMany('App\Models\GroupMember','group_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser','manager_id','id');
    }
}
