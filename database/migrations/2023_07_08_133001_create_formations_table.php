<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('formations', function(Blueprint $table)
		{
			$table->integer('id_formation', true);
			$table->string('nom_formation_ar', 150)->nullable();
			$table->date('date_formation')->nullable();
			$table->text('participantes')->nullable();
			$table->string('path_formation', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('formations');
	}

}
