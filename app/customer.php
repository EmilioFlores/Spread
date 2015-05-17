<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class customer extends Model {

	protected $fillable =['phone'];

	public function personalizations()
	{
		return $this->hasMany('App\personalization');
	}

}
