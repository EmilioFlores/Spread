<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model {

	protected $fillable =['status', 'total', 'name'];

	public function personalization()
	{
		return $this->hasOne('App\personalization');
	}

}
