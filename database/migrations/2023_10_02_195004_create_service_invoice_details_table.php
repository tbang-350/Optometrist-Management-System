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
        Schema::create('service_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('service_invoice_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->double('service_price')->nullable();
            $table->double('service_selling_price')->nullable();
            $table->tinyInteger('status')->default('1');
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
        Schema::dropIfExists('service_invoice_details');
    }
};
