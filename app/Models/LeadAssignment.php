<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadAssignment extends Model
{
    use SoftDeletes;
    protected $table = 'lead_assignments';
    protected $fillable = ['lead_id','group_id', 'associate_id','vendor_id'];

    public function lead()
    {
        return $this->belongsTo('App\Models\AdminUser','lead_id','id');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Group','group_id','id');
    }    
    
    public function associate()
    {
        return $this->belongsTo('App\Models\AdminUser','associate_id','id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Models\AdminUser','vendor_id','id');
    }    
}
