<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIndexPerformerFavoritesChatthreadsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('create index status ON favorites(status);');
        DB::statement('create index favoriteId ON favorites(favoriteId);');
        DB::statement('create index accountStatus ON users(accountStatus);');
        DB::statement('create index type ON chatthreads(type);');
        DB::statement('create index ownerId ON chatthreads(ownerId);');
        DB::statement('create index user_id ON performer(user_id);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
