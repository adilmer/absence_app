<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agents', function(Blueprint $table)
		{
			$table->integer('id_agent', true);
			$table->integer('mat')->nullable()->unique('mat');
			$table->integer('ppr')->nullable();
			$table->string('cin', 20)->nullable();
			$table->string('nom_fr', 100)->nullable();
			$table->string('nom_ar', 100)->nullable();
			$table->string('sexe', 20)->nullable();
			$table->date('date_naiss')->nullable();
			$table->string('lieu_naiss', 100)->nullable();
			$table->date('date_rec')->nullable();
			$table->integer('id_grade')->nullable()->index('id_grade');
			$table->date('date_grade')->nullable();
			$table->integer('echelle')->nullable();
			$table->integer('echellon')->nullable();
			$table->date('date_echellon')->nullable();
			$table->integer('indice')->nullable();
			$table->date('date_position')->nullable();
			$table->string('lieu_position', 100)->nullable();
			$table->integer('id_fonction')->index('id_fonction');
			$table->integer('id_bureau')->index('id_bureau');
			$table->integer('id_position')->default(1)->index('id_position');
			$table->string('situation_fam', 50)->nullable();
			$table->string('fonction_cj', 50)->nullable();
			$table->integer('nbr_enfant')->nullable();
			$table->string('aos', 10)->nullable();
			$table->string('aff_mutuelle', 50)->nullable();
			$table->string('immatriculation', 50)->nullable();
			$table->string('n_affilation', 50)->nullable();
			$table->string('aff_cmr', 50)->nullable();
			$table->string('rib', 24)->nullable();
			$table->string('agence', 50)->nullable();
			$table->string('tel', 15)->nullable();
			$table->string('adresse_fr', 150)->nullable();
			$table->string('adresse_ar', 150)->nullable();
			$table->string('photo', 150)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('agents');
	}

}
