<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToAgentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agents', function(Blueprint $table)
		{
			$table->foreign('id_grade', 'agents_ibfk_1')->references('id_grade')->on('grades')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_fonction', 'agents_ibfk_2')->references('id_fonction')->on('fonctions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_bureau', 'agents_ibfk_3')->references('id_bureau')->on('bureaus')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_position', 'agents_ibfk_4')->references('id_position')->on('positions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agents', function(Blueprint $table)
		{
			$table->dropForeign('agents_ibfk_1');
			$table->dropForeign('agents_ibfk_2');
			$table->dropForeign('agents_ibfk_3');
			$table->dropForeign('agents_ibfk_4');
		});
	}

}
