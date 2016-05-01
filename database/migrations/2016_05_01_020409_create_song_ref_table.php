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
            $table->integer('songId')->unsigned();
            $table->integer('passageId')->unsigned();
            $table->text('lyric');
            $table->tinyInteger('order')->unsigned();
            $table->timestamps();
            $table->index('songId');
            $table->index('passageId');
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
