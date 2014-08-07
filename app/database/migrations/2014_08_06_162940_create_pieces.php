<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePieces extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_pieces', function(Blueprint $table)
		{
			// Create table
		    $table->create();
		     
		    // Table schema
		    $table->increments('id');
			$table->integer('subassembly_id')->unsigned();
			$table->integer('piece_type_id')->unsigned();
			$table->integer('piece_status_id')->unsigned();
			$table->integer('piece_process_id')->unsigned();
			$table->integer('author_id')->unsigned();
			$table->integer('provider_id')->unsigned()->nullable();

			$table->dateTime('datetime_due');
			$table->dateTime('datetime_tosend')->nullable();
			$table->dateTime('datetime_sent')->nullable();
			$table->dateTime('datetime_toreceive')->nullable();
			$table->dateTime('datetime_received')->nullable();
			$table->dateTime('datetime_toorder')->nullable();
			$table->dateTime('datetime_ordered')->nullable();
			
			$table->text('title');
			$table->text('desc');
			$table->text('code');
			$table->text('material')->nullable();
			$table->float('unit_price')->unsigned();
			$table->float('quantity')->unsigned();
			$table->text('invoice')->nullable();
			$table->text('quote')->nullable();
			$table->text('external_link')->nullable();
			
			$table->text('technical_drawing')->nullable();
					     
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
		Schema::table('t4kprt_pieces', function(Blueprint $table)
		{
			// Undo changes
			$table->drop();
		});
	}

}
