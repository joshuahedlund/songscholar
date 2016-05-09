<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassageVersion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passageVersions',function($table){
           $table->increments('id');
           $table->integer('passage_id')->unsigned();
           $table->string('version',20);
           $table->text('text');
           $table->timestamps();
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
        Schema::drop('passageVersions');
    }
}
