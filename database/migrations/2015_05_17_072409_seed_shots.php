<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use App\shot;
class SeedShots extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		
		shot::create(['name'=>'Regular', 'cost' => '7']);
		shot::create(['name'=>'Descafeinado', 'cost' => '7']);
		shot::create(['name'=>'Sin shot', 'cost' => '0']);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('shots')->delete();
		//
	}

}
