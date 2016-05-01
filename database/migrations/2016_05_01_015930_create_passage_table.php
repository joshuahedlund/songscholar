<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passages',function($table){
           $table->increments('id');
           $table->string('book',25);
           $table->tinyInteger('chapter')->unsigned();
           $table->tinyInteger('verse')->unsigned();
           $table->string('version',20);
           $table->text('text');
           $table->timestamps();
           $table->index('book');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('passages');
    }
}
