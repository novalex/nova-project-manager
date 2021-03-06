<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'posts',
			function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->string( 'name' );
				$table->string( 'slug' )->nullable()->default( null );
				$table->longText( 'body' )->nullable()->default( null );
				$table->integer( 'category' )->unsigned()->nullable()->default( null );
				$table->integer( 'post_type' )->unsigned();
				$table->timestamps();

				$table->unique( 'slug' );
				$table->foreign( 'category' )->references( 'id' )->on( 'categories' );
				$table->foreign( 'post_type' )->references( 'id' )->on( 'post_types' );
			}
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'posts' );
	}
}
