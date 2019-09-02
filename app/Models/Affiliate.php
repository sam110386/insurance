<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Affiliate extends Model
{
    use SoftDeletes;
    protected $table = 'affiliate';

	public function leads()
	{
		return $this->hasMany('App\Models\AffiliateLead');
	}    
}
