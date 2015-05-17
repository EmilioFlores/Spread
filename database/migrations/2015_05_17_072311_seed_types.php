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
		$modality->types()->save(new type(array('name'=>'Filtrado')));
		$modality->types()->save(new type(array('name'=>'Chocolate')));
		$modality->types()->save(new type(array('name'=>'Leche')));
		$modality->types()->save(new type(array('name'=>'Infusiones')));
		$modality->types()->save(new type(array('name'=>'Té Lattes')));

		$modality=modality::where('name', '=', 'Frio')->first();
		$modality->types()->save(new type(array('name'=>'Bebidas frías con café')));
		$modality->types()->save(new type(array('name'=>'Bebidas frías sin café')));
		

	    $type = type::where('name', '=', 'Espresso')->first();
		$type->options()->save(new option(array('name'=>'Café Mocha', 'alto' => '47', 'grande' => '52', 'venti' => '56')));	
		$type->options()->save(new option(array('name'=>'Café Mocha Blanco', 'alto' => '47', 'grande' => '52', 'venti' => '56')));	
		$type->options()->save(new option(array('name'=>'Espresso Americano', 'alto' => '31', 'grande' => '36', 'venti' => '39')));	
		$type->options()->save(new option(array('name'=>'Café Latte', 'alto' => '39', 'grande' => '44', 'venti' => '48')));	
		$type->options()->save(new option(array('name'=>'Cappuccino', 'alto' => '39', 'grande' => '44', 'venti' => '48')));	
		$type->options()->save(new option(array('name'=>'Caramel Macchiato', 'alto' => '49', 'grande' => '54', 'venti' => '59')));	
		$type->options()->save(new option(array('name'=>'Espresso', 'alto' => '20', 'grande' => '30', 'venti' => 'xx')));	
		$type->options()->save(new option(array('name'=>'Espresso Macchiato', 'alto' => '25', 'grande' => '35', 'venti' => 'xx')));	
		$type->options()->save(new option(array('name'=>'Vainilla Cappuccino', 'alto' => '44', 'grande' => '48', 'venti' => '52')));	


		$type = type::where('name', '=', 'Filtrado')->first();
		$type->options()->save(new option(array('name'=>'Café del día', 'alto' => '25', 'grande' => '29', 'venti' => '33')));

		$type = type::where('name', '=', 'Chocolate')->first();
		$type->options()->save(new option(array('name'=>'Chocolate', 'alto' => '40', 'grande' => '44', 'venti' => '48')));	
		$type->options()->save(new option(array('name'=>'Chocolate Blanco', 'alto' => '40', 'grande' => '44', 'venti' => '48')));	


		$type = type::where('name', '=', 'Leche')->first();
		$type->options()->save(new option(array('name'=>'Leche al vapor', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	


		$type = type::where('name', '=', 'Infusiones')->first();
		$type->options()->save(new option(array('name'=>'Té Chai', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	
		$type->options()->save(new option(array('name'=>'Té China Green', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	
		$type->options()->save(new option(array('name'=>'Té English Breakfast', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	
		$type->options()->save(new option(array('name'=>'Té Hibiscus', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	
		$type->options()->save(new option(array('name'=>'Té Vainilla Rooibos', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	
		$type->options()->save(new option(array('name'=>'Té Chammomile', 'alto' => '25', 'grande' => '29', 'venti' => '33')));	
		$type->options()->save(new option(array('name'=>'Té de Menta', 'alto' => '25', 'grande' => '29', 'venti' => '33')));

		$type = type::where('name', '=', 'Té Lattes')->first();
		$type->options()->save(new option(array('name'=>'English Breakfast Latte', 'alto' => '29', 'grande' => '33', 'venti' => '37')));	
		$type->options()->save(new option(array('name'=>'Green Tea Latte', 'alto' => '29', 'grande' => '33', 'venti' => '37')));	
		$type->options()->save(new option(array('name'=>'Té Chai Latte', 'alto' => '29', 'grande' => '33', 'venti' => '37')));	
		$type->options()->save(new option(array('name'=>'Vainilla Rooibos Latte', 'alto' => '29', 'grande' => '33', 'venti' => '37')));	


		$type = type::where('name', '=', 'Bebidas frías con café')->first();
		$type->options()->save(new option(array('name'=>'Chocolate cream frappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59')));	
		$type->options()->save(new option(array('name'=>'Frappuccino café', 'alto' => '44', 'grande' => '49', 'venti' => '54')));	
		$type->options()->save(new option(array('name'=>'Frappuccino caramel', 'alto' => '50', 'grande' => '54', 'venti' => '60')));	
		$type->options()->save(new option(array('name'=>'Frappuccino chip', 'alto' => '50', 'grande' => '54', 'venti' => '60')));	
		$type->options()->save(new option(array('name'=>'Helado Cajeta Latte', 'alto' => '42', 'grande' => '46', 'venti' => '50')));	
		$type->options()->save(new option(array('name'=>'Helado Caramel Macchiato', 'alto' => '42', 'grande' => '46', 'venti' => '50')));	
		$type->options()->save(new option(array('name'=>'Helado Latte', 'alto' => '42', 'grande' => '46', 'venti' => '50')));	
		$type->options()->save(new option(array('name'=>'Helado Mocha', 'alto' => '42', 'grande' => '46', 'venti' => '50')));	
		$type->options()->save(new option(array('name'=>'Helado Mocha Blanco', 'alto' => '42', 'grande' => '46', 'venti' => '50')));	
		$type->options()->save(new option(array('name'=>'Mocha Blanco Frappuccino', 'alto' => '50', 'grande' => '54', 'venti' => '60')));	
		$type->options()->save(new option(array('name'=>'Mocha Frappuccino', 'alto' => '50', 'grande' => '54', 'venti' => '60')));	


		$type = type::where('name', '=', 'Bebidas frías con café')->first();
		$type->options()->save(new option(array('name'=>'Frambuesa Grosella Frappucino', 'alto' => '49', 'grande' => '53', 'venti' => '59')));
		$type->options()->save(new option(array('name'=>'Fresa Cream Frappuccino', 'alto' => '49', 'grande' => '53', 'venti' => '59')));
		
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
