<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongRefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songRefs',function($table){
            $table->increments('id');
            $table->integer('song_id')->unsigned();
            $table->integer('passage_id')->unsigned();
            $table->text('lyric');
            $table->tinyInteger('order')->unsigned();
            $table->timestamps();
            $table->index('song_id');
            $table->index('passage_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('songRefs');
    }
}
