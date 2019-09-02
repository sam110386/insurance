<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateLead extends Model
{
    protected $table = 'affiliate_leads';
    protected $fillable = ['affiliate_id', 'lead_id'];
    public function lead()
    {
        return $this->belongsTo('App\Models\Lead','lead_id','id');
    }    
}