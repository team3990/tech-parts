<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FkAssemblies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_assemblies', function(Blueprint $table)
		{
			// Foreign keys
			$table->foreign('manager_id')->references('id')->on('t4kglo_users');
			$table->foreign('project_id')->references('id')->on('t4kprt_projects');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t4kprt_assemblies', function(Blueprint $table)
		{
			// Undo changes
			$table->dropForeign('t4kprt_assemblies_project_id_foreign');
			$table->dropForeign('t4kprt_assemblies_manager_id_foreign');
		});
	}

}
