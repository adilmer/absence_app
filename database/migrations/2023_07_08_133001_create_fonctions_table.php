<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFonctionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fonctions', function(Blueprint $table)
		{
			$table->integer('id_fonction', true);
			$table->string('nom_fonction_fr', 70)->nullable();
			$table->string('nom_fonction_ar', 70)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fonctions');
	}

}
