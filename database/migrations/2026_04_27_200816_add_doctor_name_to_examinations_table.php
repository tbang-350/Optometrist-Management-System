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
        Schema::table('ophthalmology_encounter_records', function (Blueprint $table) {
            $table->string('doctor_name')->after('customer_id')->nullable(); // Making it nullable in DB but required in UI for safety
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ophthalmology_encounter_records', function (Blueprint $table) {
            $table->dropColumn('doctor_name');
        });
    }
};
