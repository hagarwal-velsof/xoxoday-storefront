<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Xoxoday\Storefront\Models\Xostate;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xostates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->tinyInteger('status');
        });

         //default data entry for the state table
         if (Xostate::count() <= 0) {
            Artisan::call('db:seed', [
                '--class' => 'StateSeeder',
                '--force' => true]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};
