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
        Schema::create('ophthalmology_encounter_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('created_by')->nullable();
            $table->integer('location_id')->nullable();
            $table->date('date')->nullable();

            // Patient History
            $table->text('chief_complaint')->nullable();
            $table->text('hpi')->nullable();
            $table->text('past_ocular_history')->nullable();
            $table->text('social_history')->nullable();

            // Vitals
            $table->decimal('body_temperature', 5, 2)->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->decimal('oxygen_saturation', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('respiration_rate')->nullable();
            $table->decimal('blood_glucose', 8, 2)->nullable();

            // Ocular Examination - Visual Acuity
            $table->string('va_chart_used')->nullable();
            $table->string('va_od_unaided')->nullable();
            $table->string('va_od_aided')->nullable();
            $table->string('va_od_pinhole')->nullable();
            $table->string('va_os_unaided')->nullable();
            $table->string('va_os_aided')->nullable();
            $table->string('va_os_pinhole')->nullable();

            // Intraocular Pressure
            $table->string('tonometer_type')->nullable();
            $table->decimal('iop_od', 5, 2)->nullable();
            $table->decimal('iop_os', 5, 2)->nullable();

            // Slit Lamp Examination - Right Eye (OD)
            $table->text('sle_od_lids_lashes')->nullable();
            $table->text('sle_od_conjunctiva')->nullable();
            $table->text('sle_od_sclera')->nullable();
            $table->text('sle_od_cornea')->nullable();
            $table->text('sle_od_anterior_chamber')->nullable();
            $table->text('sle_od_iris')->nullable();
            $table->decimal('sle_od_pupil_size', 5, 2)->nullable();
            $table->string('sle_od_pupil_shape')->nullable();
            $table->string('sle_od_pupil_reaction')->nullable();
            $table->text('sle_od_lens')->nullable();

            // Slit Lamp Examination - Left Eye (OS)
            $table->text('sle_os_lids_lashes')->nullable();
            $table->text('sle_os_conjunctiva')->nullable();
            $table->text('sle_os_sclera')->nullable();
            $table->text('sle_os_cornea')->nullable();
            $table->text('sle_os_anterior_chamber')->nullable();
            $table->text('sle_os_iris')->nullable();
            $table->decimal('sle_os_pupil_size', 5, 2)->nullable();
            $table->string('sle_os_pupil_shape')->nullable();
            $table->string('sle_os_pupil_reaction')->nullable();
            $table->text('sle_os_lens')->nullable();

            // Other
            $table->text('investigations')->nullable();

            // Assessment and Plan
            $table->text('differential_diagnosis')->nullable();
            $table->text('management_plan')->nullable();

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
        Schema::dropIfExists('ophthalmology_encounter_records');
    }
};
