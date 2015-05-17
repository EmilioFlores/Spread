<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class type extends Model {

	protected $fillable =['name'];

	public function options()
	{
		return $this->hasMany('App\option');
	}

	public function modality()
	{
		return $this->belongsTo('App\modality');
	}

}
