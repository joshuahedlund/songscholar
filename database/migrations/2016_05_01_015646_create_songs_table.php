<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs',function($table){
           $table->increments('id');
           $table->string('name');
           $table->integer('album_id')->unsigned();
           $table->integer('artist_id')->unsigned();
           $table->timestamps();
           $table->index('artist_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('songs');
    }
}
