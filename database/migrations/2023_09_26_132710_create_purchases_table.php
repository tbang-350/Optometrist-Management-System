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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name')->nullable();
            $table->integer('category_id');
            $table->integer('product_id');
            $table->string('purchase_no');
            $table->date('date');
            $table->double('buying_qty');
            $table->double('buying_unit_price');
            $table->double('selling_unit_price');
            $table->double('total_buying_amount');
            $table->tinyInteger('status')->default('1')->comment('0 = pending , 1 = approved');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('location_id')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
