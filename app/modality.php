<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class modality extends Model {

	protected $fillable =['name'];

	public function types()
	{
		return $this->hasMany('App\type');
	}

}
