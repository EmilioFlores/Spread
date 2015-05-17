<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;
use App\milk;

class SeedMilks extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		milk::create(['name' => 'Entera', 'cost' => '0' ]);
		milk::create(['name' => 'Light', 'cost' => '0' ]);
		milk::create(['name' => 'Deslactosada', 'cost' => '7' ]);
		milk::create(['name' => 'Deslactosada Light', 'cost' => '7' ]);
		milk::create(['name' => 'Soya', 'cost' => '7' ]);
		milk::create(['name' => 'Half and Half', 'cost' => '7' ]);
		milk::create(['name' => 'Coco', 'cost' => '7' ]);
		milk::create(['name' => 'Sin Leche', 'cost' => '0' ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('milks')->delete();
	}

}
