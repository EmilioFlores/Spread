<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\topping;
class SeedToppings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		topping::create(['name'=>"Crema Batida", "cost" => "7"]);
		topping::create(['name'=>"Espiral de Mocha", "cost" => "4"]);
		topping::create(['name'=>"Espiral de Caramelo", "cost" => "4"]);
		topping::create(['name'=>"Espiral de Cajeta", "cost" => "4"]);
		topping::create(['name'=>"Sin topping", "cost" => "0"]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('topping')->delete();
		//
	}

}
