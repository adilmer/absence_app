<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBureausTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bureaus', function(Blueprint $table)
		{
			$table->foreign('id_service', 'bureaus_ibfk_1')->references('id_service')->on('services')->onUpdate('CASCADE')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bureaus', function(Blueprint $table)
		{
			$table->dropForeign('bureaus_ibfk_1');
		});
	}

}
