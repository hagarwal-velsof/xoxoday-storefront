<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xoredemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('product', 255);
            $table->tinyInteger('status'); // 1 means redeemed product delivered, 0 means not delivered
            $table->dateTime('request_date');
            $table->string('address',255);
            $table->string('address2',255)->nullable();
            $table->string('city',255);
            $table->string('state',255);
            $table->string('pincode',255);
            $table->string('landmark',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('redemptions');
    }
};
