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
        
        //See http://stackoverflow.com/questions/21307464/can-i-import-a-mysql-dump-to-a-laravel-migration
        $filename = str_replace("\\", "/", storage_path('passageVersions.csv'));

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE passageVersions
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (id,passage_id,version,text,created_at,updated_at);";

        DB::unprepared($query);
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
