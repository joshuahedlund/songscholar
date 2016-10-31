<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefFulltext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE songRefs ADD FULLTEXT search(lyric)');
        DB::statement('ALTER TABLE passageVersions ADD FULLTEXT search(text)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP INDEX search ON songRefs');
        DB::statement('DROP INDEX search ON passageVersions');        
    }
}