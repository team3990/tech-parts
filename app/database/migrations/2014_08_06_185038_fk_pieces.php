<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FkPieces extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t4kprt_pieces', function(Blueprint $table)
		{
			// Foreign keys
			$table->foreign('subassembly_id')	->references('id')->on('t4kprt_subassemblies');
			$table->foreign('piece_type_id')	->references('id')->on('t4kprt_piece_type');
			$table->foreign('piece_status_id')	->references('id')->on('t4kprt_piece_status');
			$table->foreign('piece_process_id')	->references('id')->on('t4kprt_piece_process');
			$table->foreign('author_id')		->references('id')->on('t4kglo_users');
			$table->foreign('provider_id')		->references('id')->on('t4kprt_providers');
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
			$table->dropForeign('t4kprt_pieces_subassembly_id_foreign');
			$table->dropForeign('t4kprt_pieces_piece_type_id_foreign');
			$table->dropForeign('t4kprt_pieces_piece_status_id_foreign');
			$table->dropForeign('t4kprt_pieces_piece_process_id_foreign');
			$table->dropForeign('t4kprt_pieces_author_id_foreign');
			$table->dropForeign('t4kprt_pieces_provider_id_foreign');
		});
	}

}
