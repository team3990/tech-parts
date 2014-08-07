<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_notes', function(Blueprint $table)
		{
			// Create table
		    $table->create();
		     
		    // Table schema
		    $table->increments('id');
			$table->integer('assembly_id')->unsigned();
			$table->integer('subassembly_id')->unsigned();
			$table->integer('piece_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->dateTime('datetime');
			$table->text('note');
					     
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
		Schema::table('t4kprt_notes', function(Blueprint $table)
		{
			// Undo changes
			$table->drop();
		});
	}

}
