<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Auth\Database\Administrator;

class AdminUser extends Administrator
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

    public function managerGroups(){
    	return $this->hasMany('App\Models\Group','manager_id','id');
    }

    public function userGroups(){
    	return $this->hasMany('App\Models\GroupMember','member_id','id');
    }    
}
