<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjects extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_projects', function(Blueprint $table)
		{
			// Create table
		    $table->create();
		     
		    // Table schema
		    $table->increments('id');

		    $table->text('title');
			$table->text('desc');
					     
		    // Table administration
		    $table->timestamps();
		    $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t4kprt_projects', function(Blueprint $table)
		{
			// Undo changes
			$table->drop();
		});
	}

}
