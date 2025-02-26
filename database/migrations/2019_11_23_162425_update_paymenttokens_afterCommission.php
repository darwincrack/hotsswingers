<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePaymenttokensAfterCommission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `paymenttokens` ADD `modelCommission` INT NULL AFTER `updatedAt`, ADD `afterModelCommission` DOUBLE NULL AFTER `modelCommission`, ADD `studioCommission` INT NULL AFTER `afterModelCommission`, ADD `afterStudioCommission` DOUBLE NULL AFTER `studioCommission`;');
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
