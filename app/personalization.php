<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class personalization extends Model {

	protected $fillable =['code', 'modality', 'type', 'option', 'size', 'milk', 'foam', 'temperature','step','transaction'];

	public function order()
	{
		return $this->belongsTo('App\order');
	}

	public function personalizationToppings()
	{
		return $this->hasMany('App\personalizationTopping');
	}

	public function personalizationSyrups()
	{
		return $this->hasMany('App\personalizationSyrup');
	}

	public function personalizationShots()
	{
		return $this->hasMany('App\personalizationShot');
	}
	public function option()
	{
		return $this->hasOne('App\option');
	}


}