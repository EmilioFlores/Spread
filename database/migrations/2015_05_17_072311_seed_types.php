<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use App\type;
use App\modality;
use App\option;

class SeedTypes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$modality=modality::where('name', '=', 'Caliente')->first();
		$modality->types()->save(new type(array('name'=>'Espresso')));

		// $modality->types()->create(['name', '=', 'Espresso']);
		// $modality->types()->create(['name', '=', 'Filtrado']);
		// $modality->types()->create(['name', '=', 'Chocolate']);
		// $modality->types()->create(['name', '=', 'Leche']);
		// $modality->types()->create(['name', '=', 'Infusiones']);
		// $modality->types()->create(['name', '=', 'Té lattes']);

		// $modality=modality::where('name', '=', 'Frio')->first();
		// $modality->types()->create(['name', '=', 'Bebidas frías con café']);
		// $modality->types()->create(['name', '=', 'Bebidas frías sin café ']);

	    $type = type::where('name', '=', 'Espresso')->first();
		$type->options()->save(new option(array('name'=>'Cappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59')));	
		// $type->options()->create(['name'=> 'Chocolate cream frappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59']);		
		// $type->options()->create(['name'=> 'Frappucino café', 'alto' => '44', 'grande' => '49', 'venti' => '54']);		
		// $type->options()->create(['name'=> 'Frappucino caramel', 'alto' => '50', 'grande' => '54', 'venti' => '60']);		
		
		// $type = type::where('name', '=', 'Bebidas frías sin café')->first();
		// $type->options()->create(['name'=> 'Frambuesa Grosella Frappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59']);		
		// $type->options()->create(['name'=> 'Fresa Cream Frappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59']);		
		// $type->options()->create(['name'=> 'Green Tea Cream Frappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59']);		
		
		// $type = type::where('name', '=', 'Expresso')->first();
		// $type->options()->create(['name'=> 'Café Mocha', 'alto' => '47', 'grande' => '52', 'venti' => '56']);		
		// $type->options()->create(['name'=> 'Café Mocha Blanco', 'alto' => '47', 'grande' => '52', 'venti' => '56']);		
		// $type->options()->create(['name'=> 'Espresso Americano', 'alto' => '31', 'grande' => '36', 'venti' => '39']);		
		
		// $type = type::where('name', '=', 'Chocolate')->first();
		// $type->options()->create(['name'=> 'Chocolate', 'alto' => '40', 'grande' => '44', 'venti' => '48']);		
		// $type->options()->create(['name'=> 'Chocolate Blanco', 'alto' => '40', 'grande' => '44', 'venti' => '48']);		
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
