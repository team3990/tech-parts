<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePieceProcessPivot extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_piece_process', function(Blueprint $table)
		{
			// Create table
			$table->create();
			
			// Table schema
			$table->increments('id');
			$table->integer('piece_id')->unsigned();
			$table->integer('process_id')->unsigned();
			$table->integer('status_id')->unsigned();
			$table->integer('user_id')->unsigned();
				
			// Foreign keys & indexes
			$table->foreign('piece_id')->references('id')->on('t4kprt_pieces');
			$table->foreign('process_id')->references('id')->on('t4kprt_process');
			$table->foreign('status_id')->references('id')->on('t4kprt_status');
			$table->foreign('user_id')->references('id')->on('t4kglo_users');
				
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
		Schema::table('t4kprt_piece_process', function(Blueprint $table)
		{
			// Undo changes
			$table->drop();
		});
	}

}
