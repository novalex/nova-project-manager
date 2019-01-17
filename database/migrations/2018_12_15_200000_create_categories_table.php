<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create(
			'categories',
			function ( Blueprint $table ) {
				$table->increments( 'id' );
				$table->string( 'name' );
				$table->string( 'slug' );
				$table->integer( 'post_type' )->unsigned();
				$table->integer( 'parent' )->unsigned()->nullable()->default( null );
				$table->timestamps();

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
		Schema::dropIfExists( 'categories' );
	}
}
