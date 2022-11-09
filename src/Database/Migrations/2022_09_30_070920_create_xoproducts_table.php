<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Xoxoday\Storefront\Models\Xoproduct;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xoproducts', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->text('description');
            $table->integer('points');
            $table->string('image',255);
            $table->timestamps();
        });

        //default data entry for the product table
        if (Xoproduct::count() <= 0) {
            Artisan::call('db:seed', [
                '--class' => 'ProductSeeder',
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
        Schema::dropIfExists('products');
    }
};
