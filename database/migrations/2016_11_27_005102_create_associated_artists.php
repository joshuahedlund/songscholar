<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociatedArtists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associatedArtists',function($table){
            $table->increments('id');
            $table->integer('song_id')->unsigned();
            $table->integer('artist_id')->unsigned();
            $table->integer('createdBy')->unsigned();
            $table->index('song_id');
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
        Schema::drop('associatedArtists');
    }
}
