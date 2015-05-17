<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class personalizationSyrup extends Model {

	
	protected $fillable =['name', 'cost'];

	public function personalization()
	{
		return $this->belongsTo('App\personalization');
	}

}
