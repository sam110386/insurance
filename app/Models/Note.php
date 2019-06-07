<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
	protected $table = 'notes';
    protected $fillable = ['user_ip', 'user_id', 'lead_id','notes'];
    public function lead()
    {
        return $this->belongsTo('App\Models\Lead');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser','lead_id','id');
    }
}
