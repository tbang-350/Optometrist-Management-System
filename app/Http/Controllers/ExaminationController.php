<?php

namespace App\Http\Controllers;

use App\Models\OphthalmologyEncounterRecord;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;

class ExaminationController extends Controller
{
    public function ExaminationAll()
    {
        $examinations = OphthalmologyEncounterRecord::with('customer', 'creator')->latest()->get();
        $customers = Customer::all(); // For the modal select

        return view('backend.examination.examination_all', compact('examinations', 'customers'));
    }

    public function ExaminationStore(Request $request)
    {
        $date = new DateTime('now', new DateTimeZone('Africa/Dar_es_Salaam'));

        $record = new OphthalmologyEncounterRecord();
        $record->customer_id = $request->customer_id;
        $record->created_by = Auth::user()->id;
        $record->location_id = Auth::user()->location_id;
        $record->date = $date->format('Y-m-d');

        // History
        $record->chief_complaint = $request->chief_complaint;
        $record->hpi = $request->hpi;
        $record->past_ocular_history = $request->past_ocular_history;
        $record->social_history = $request->social_history;

        // Vitals
        $record->body_temperature = $request->body_temperature;
        $record->pulse_rate = $request->pulse_rate;
        $record->oxygen_saturation = $request->oxygen_saturation;
        $record->blood_pressure = $request->blood_pressure;
        $record->respiration_rate = $request->respiration_rate;
        $record->blood_glucose = $request->blood_glucose;

        // Visual Acuity
        $record->va_chart_used = $request->va_chart_used;
        $record->va_od_unaided = $request->va_od_unaided;
        $record->va_od_aided = $request->va_od_aided;
        $record->va_od_pinhole = $request->va_od_pinhole;
        $record->va_os_unaided = $request->va_os_unaided;
        $record->va_os_aided = $request->va_os_aided;
        $record->va_os_pinhole = $request->va_os_pinhole;

        // IOP
        $record->tonometer_type = $request->tonometer_type;
        $record->iop_od = $request->iop_od;
        $record->iop_os = $request->iop_os;

        // SLE OD
        $record->sle_od_lids_lashes = $request->sle_od_lids_lashes;
        $record->sle_od_conjunctiva = $request->sle_od_conjunctiva;
        $record->sle_od_sclera = $request->sle_od_sclera;
        $record->sle_od_cornea = $request->sle_od_cornea;
        $record->sle_od_anterior_chamber = $request->sle_od_anterior_chamber;
        $record->sle_od_iris = $request->sle_od_iris;
        $record->sle_od_pupil_size = $request->sle_od_pupil_size;
        $record->sle_od_pupil_shape = $request->sle_od_pupil_shape;
        $record->sle_od_pupil_reaction = $request->sle_od_pupil_reaction;
        $record->sle_od_lens = $request->sle_od_lens;

        // SLE OS
        $record->sle_os_lids_lashes = $request->sle_os_lids_lashes;
        $record->sle_os_conjunctiva = $request->sle_os_conjunctiva;
        $record->sle_os_sclera = $request->sle_os_sclera;
        $record->sle_os_cornea = $request->sle_os_cornea;
        $record->sle_os_anterior_chamber = $request->sle_os_anterior_chamber;
        $record->sle_os_iris = $request->sle_os_iris;
        $record->sle_os_pupil_size = $request->sle_os_pupil_size;
        $record->sle_os_pupil_shape = $request->sle_os_pupil_shape;
        $record->sle_os_pupil_reaction = $request->sle_os_pupil_reaction;
        $record->sle_os_lens = $request->sle_os_lens;

        // Plan
        $record->investigations = $request->investigations;
        $record->differential_diagnosis = $request->differential_diagnosis;
        $record->management_plan = $request->management_plan;

        $record->save();

        $notification = array(
            'message' => 'Examination Record Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('examination.all')->with($notification);
    }

    public function ExaminationDelete($id)
    {
        OphthalmologyEncounterRecord::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Examination Record Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('examination.all')->with($notification);
    }

    public function ExaminationView($id)
    {
        $examination = OphthalmologyEncounterRecord::with('customer', 'creator', 'location')->findOrFail($id);
        return view('backend.examination.examination_view', compact('examination'));
    }
}
