<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
	protected $table = 'leads';
	protected $fillable = [
		'first_name','last_name','street','city','state','zip','phone','email','married','children','homeowner','bundled','first_driver_first_name','first_driver_last_name','first_driver_dob','first_driver_gender','first_driver_dl','first_driver_state','second_driver_first_name','second_driver_last_name','second_driver_dob','second_driver_gender','second_driver_dl','second_driver_state','third_driver_first_name','third_driver_last_name','third_driver_dob','third_driver_gender','third_driver_dl','third_driver_state','fourth_driver_first_name','fourth_driver_last_name','fourth_driver_dob','fourth_driver_gender','fourth_driver_dl','fourth_driver_state','fifth_driver_first_name','fifth_driver_last_name','fifth_driver_dob','fifth_driver_gender','fifth_driver_dl','fifth_driver_state','first_vehicle_year','first_vehicle_make','first_vehicle_model','first_vehicle_trim','first_vehicle_vin','first_vehicle_owenership','first_vehicle_uses','first_vehicle_mileage','second_vehicle_year','second_vehicle_make','second_vehicle_model','second_vehicle_trim','second_vehicle_vin','second_vehicle_owenership','second_vehicle_uses','second_vehicle_mileage','third_vehicle_year','third_vehicle_make','third_vehicle_model','third_vehicle_trim','third_vehicle_vin','third_vehicle_owenership','third_vehicle_uses','third_vehicle_mileage','fourth_vehicle_year','fourth_vehicle_make','fourth_vehicle_model','fourth_vehicle_trim','fourth_vehicle_vin','fourth_vehicle_owenership','fourth_vehicle_uses','fourth_vehicle_mileage','fifth_vehicle_year','fifth_vehicle_make','fifth_vehicle_model','fifth_vehicle_trim','fifth_vehicle_vin','fifth_vehicle_owenership','fifth_vehicle_uses','fifth_vehicle_mileage','liability','body_injury','deduct','medical','towing','uninsured','rental','previous_insurance','current_insurance','duration','at_fault','tickets','dui','quality_provides','agent_in_person','referrer','referrer_name','ip_address'
	];

	/**
     * Get the comments for the blog post.
     */
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}
}
