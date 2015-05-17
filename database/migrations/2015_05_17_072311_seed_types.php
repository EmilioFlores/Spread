<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\type;
use App\modality;

class SeedTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$modality=modality::where('name', '=', 'Caliente')->first();
		$modality->types()->create(['name', '=', 'Espresso']);
		$modality->types()->create(['name', '=', 'Filtrado']);
		$modality->types()->create(['name', '=', 'Chocolate']);
		$modality->types()->create(['name', '=', 'Leche']);
		$modality->types()->create(['name', '=', 'Infusiones']);
		$modality->types()->create(['name', '=', 'Té lattes']);

		$modality=modality::where('name', '=', 'Frio')->first();
		$modality->types()->create(['name', '=', 'Bebidas frías con café']);
		$modality->types()->create(['name', '=', 'Bebidas frías sin café ']);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('types')->delete();
	}

}
