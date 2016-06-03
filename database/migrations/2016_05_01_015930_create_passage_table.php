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
           $table->timestamps();
           $table->index('book');
        });
        
        //See http://stackoverflow.com/questions/21307464/can-i-import-a-mysql-dump-to-a-laravel-migration
        $filename = str_replace("\\", "/", storage_path('passages.csv'));

        $query = "LOAD DATA LOCAL INFILE '".$filename."' INTO TABLE passages
            FIELDS TERMINATED BY ','
            ENCLOSED BY '\"'
            LINES TERMINATED BY '\n'
            IGNORE 1 LINES
            (id,book,chapter,verse,created_at,updated_at);";

        DB::unprepared($query);
        
        //Notes: to regenrate passages.csv and passageVersions.csv from scratch:
        //Download bible-mysql.sql from https://github.com/scrollmapper/bible_databases/
        // Import
        // Run:
        // INSERT INTO passages 
        //(SELECT t_kjv.id,books.name,t_kjv.c,t_kjv.v,NOW(),NOW() FROM t_kjv JOIN books ON t_kjv.b=books.id);
        // INSERT INTO passageVersions (passage_id, version, text, created_at, updated_at) (SELECT t_kjv.id,'KJV',t_kjv.t,NOW(),NOW() FROM t_kjv);
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
