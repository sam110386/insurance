<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
    protected $table = 'groups';
    protected $fillable = ['name','email', 'manager_id'];
	public function members()
    {
        return $this->hasMany('App\Models\GroupMember','group_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser','manager_id','id');
    }
}
