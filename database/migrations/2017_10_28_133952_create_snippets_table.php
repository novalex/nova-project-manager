<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snippets', function (Blueprint $table) {
        	$table->increments('id');
        	$table->string('name');
        	$table->string('slug')->nullable()->default(NULL);
        	$table->longText('body')->nullable()->default(NULL);
        	$table->integer('category_id')->nullable()->default(NULL);
        	$table->timestamps();

        	$table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('snippets');
    }
}
