<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use App\syrup;

class SeedSyrups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		syrup::create(['name' => 'Vainilla', 'cost' => '7' ]);
		syrup::create(['name' => 'Caramelo', 'cost' => '7' ]);
		syrup::create(['name' => 'Cinammon Dolce', 'cost' => '7' ]);
		syrup::create(['name' => 'Clásico', 'cost' => '7' ]);
		syrup::create(['name' => 'Avellana', 'cost' => '7' ]);
		syrup::create(['name' => 'Menta', 'cost' => '7' ]);
		syrup::create(['name' => 'Coco', 'cost' => '7' ]);
		syrup::create(['name' => 'Almendra', 'cost' => '7' ]);
		syrup::create(['name' => 'Frambuesa', 'cost' => '7' ]);
		syrup::create(['name' => 'Vainilla Sugar Free', 'cost' => '7' ]);
		syrup::create(['name' => 'Mocha', 'cost' => '7' ]);
		syrup::create(['name' => 'Mocha Blanco', 'cost' => '7' ]);
		syrup::create(['name' => 'Sin Jarabe', 'cost' => '0' ]);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('syrups')->delete();
	}

}
