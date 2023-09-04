<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToArchivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('archives', function(Blueprint $table)
		{
			$table->foreign('id_categorie', 'archives_ibfk_1')->references('id_categorie')->on('categories')->onUpdate('CASCADE')->onDelete('SET NULL');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('archives', function(Blueprint $table)
		{
			$table->dropForeign('archives_ibfk_1');
		});
	}

}
