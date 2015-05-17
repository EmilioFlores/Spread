<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class personalizationShot extends Model {

	
	protected $fillable =['name', 'amount'];

	public function personalization()
	{
		return $this->belongsTo('App\personalization');
	}

}
