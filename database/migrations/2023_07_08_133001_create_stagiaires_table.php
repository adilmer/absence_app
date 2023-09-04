<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStagiairesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stagiaires', function(Blueprint $table)
		{
			$table->integer('id_stagiaire', true);
			$table->string('nom_stagiaire_ar', 100)->nullable();
			$table->string('nom_stagiaire_fr', 100)->nullable();
			$table->date('date_debut_stage')->nullable();
			$table->date('date_fin_stage')->nullable();
			$table->string('direction_stagiaire', 150)->nullable();
			$table->string('filiere_stagiaire', 200)->nullable();
			$table->string('path_stage', 150)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stagiaires');
	}

}
