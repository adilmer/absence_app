<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBureausTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bureaus', function(Blueprint $table)
		{
			$table->integer('id_bureau', true);
			$table->string('nom_bureau_fr', 150)->nullable();
			$table->string('nom_bureau_ar', 150)->nullable();
			$table->integer('id_service')->index('id_service');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bureaus');
	}

}
