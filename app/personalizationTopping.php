<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class personalizationTopping extends Model {

	protected $fillable =['name', 'amount'];

	public function personalization()
	{
		return $this->belongsTo('App\personalization');
	}

}
