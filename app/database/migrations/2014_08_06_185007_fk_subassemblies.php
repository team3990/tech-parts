<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FkSubassemblies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_subassemblies', function(Blueprint $table)
		{
			// Foreign keys
			$table->foreign('assembly_id')->references('id')->on('t4kprt_assemblies');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t4kprt_subassemblies', function(Blueprint $table)
		{
			// Undo changes
			$table->dropForeign('t4kprt_subassemblies_assembly_id_foreign');
		});
	}

}
