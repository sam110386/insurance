<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;
	protected $table = 'notes';
    protected $fillable = ['user_ip', 'user_id', 'lead_id','notes'];
    public function lead()
    {
        return $this->belongsTo('App\Models\Lead','lead_id','id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser','user_id','id');
    }
}
