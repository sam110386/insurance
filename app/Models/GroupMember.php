<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    protected $table = 'group_members';
    protected $fillable = ['group_id', 'member_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser','member_id','id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group','id','group_id');
    }    
}
