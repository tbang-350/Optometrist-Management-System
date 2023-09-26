<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;

class PrescriptionController extends Controller
{

    public function PrescriptionAll()
    {

        $prescription = Prescription::latest()->get();

        return view('backend.prescription.prescription_all', compact('prescription'));

    }

    public function PrescriptionAdd($id, Request $request)
    {

        $consultation_id = $id;

        // dd($consultation_id);

        $consultation = Consultation::with('customer')->findOrFail($id);

        // dd($consultation);

        return view('backend.prescription.prescription_add', compact('consultation'));

    }

    public function PrescriptionStore(Request $request)
    {

        $consultation_id = $request->consultation_id;

        $customer_id = $request->customer_id;

        // dd($customer_id);

        // dd($consultation_id);

        $prescription = new Prescription();
        $prescription->date = date('Y-m-d', strtotime($request->date));
        $prescription->customer_id = $customer_id;
        $prescription->RE = $request->RE;
        $prescription->LE = $request->LE;
        $prescription->ADD = $request->ADD;
        $prescription->VA = $request->VA;
        $prescription->PD = $request->PD;
        $prescription->VA2 = $request->VA2;
        $prescription->N = $request->N;
        $prescription->N2 = $request->N2;
        $prescription->SIGNS = $request->SIGNS;
        $prescription->remarks = $request->remarks;
        $prescription->treatment_given = $request->treatment_given;
        $prescription->next_appointment = date('Y-m-d', strtotime($request->next_appointment));
        $prescription->created_by = Auth::user()->id;
        $prescription->created_at = Carbon::now();

        $prescription->save();

        if($prescription->save()){
            Consultation::findOrFail($consultation_id)->update([
                'status' => '1',
            ]);

        }

        $notification = array(
            'message' => 'Prescription Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('consultation.all')->with($notification);


        // dd($prescription);

    }


    public function PrescriptionView($id){

        $data = Prescription::findOrFail($id);

        // dd($data);

        return view('backend.pdf.prescription_view',compact('data'));


    }

}
