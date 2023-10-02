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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer("customer_id")->nullable();
            $table->string('RE')->nullable();
            $table->string('LE')->nullable();
            $table->string('ADD')->nullable();
            $table->string('VA')->nullable();
            $table->string('PD')->nullable();
            $table->string('VA2')->nullable();
            $table->string('N')->nullable();
            $table->string('N2')->nullable();
            $table->string('SIGNS')->nullable();
            $table->text('remarks')->nullable();
            $table->text('treatment_given')->nullable();
            $table->date('next_appointment')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('prescriptions');
    }
};
