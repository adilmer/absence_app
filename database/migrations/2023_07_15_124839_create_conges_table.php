<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCongesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('conges', function(Blueprint $table)
		{
			$table->integer('id_conge', true);
			$table->string('type_conge', 100)->nullable();
			$table->date('date_debut_conge')->nullable();
			$table->date('date_fin_conge')->nullable();
			$table->integer('nbr_jours');
			$table->integer('annee_conge');
			$table->integer('id_agent')->nullable()->index('id_agent');
			$table->string('remplacant', 150)->nullable();
			$table->string('adresse_conge', 200)->nullable();
			$table->date('date_prise')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('conges');
	}

}
