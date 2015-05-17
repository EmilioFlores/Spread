<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class option extends Model {

	protected $fillable =['name', 'alto', 'grande', 'venti'];

	public function type()
	{
		return $this->belongsTo('App\type');
	}

}
