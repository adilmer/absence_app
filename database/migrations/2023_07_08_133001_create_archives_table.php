<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('archives', function(Blueprint $table)
		{
			$table->integer('id_archive', true);
			$table->string('nom_archive_ar', 200);
			$table->integer('id_categorie')->nullable()->index('id_categorie');
			$table->date('date_archive')->nullable();
			$table->string('path_archive', 120)->nullable();
			$table->dateTime('created_at')->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('archives');
	}

}
