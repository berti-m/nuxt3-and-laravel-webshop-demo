<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->required();
            $table->string('surname')->required();
            $table->string('email')->required();
            $table->string('address')->required();
            $table->string('town')->required();
            $table->string('postal_code')->required();
            $table->string('country')->required();
            $table->string('additional_data')->nullable();
            $table->float('total', 10, 2)->unsigned()->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
