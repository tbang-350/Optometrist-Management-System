<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Customer;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PrescriptionController extends Controller
{

    public function PrescriptionAll()
    {

        $current_location = Auth::user()->location_id;

        if ($current_location == 1) {

            $prescription = Prescription::latest()->get();

        } else {

            $prescription = Prescription::latest()->where("location_id", $current_location)->get();

        }

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

    public function PrescriptionAddPlain()
    {

        $customer = Customer::all();

        return view('backend.prescription.prescription_add_plain', compact('customer'));

    }

    public function PrescriptionStore(Request $request)
    {
        // Validate the request inputs
        // $request->validate([
        //     'consultation_id' => 'required|integer',
        //     'customer_id' => 'required|integer',
        //     'date' => 'required|date',
        //     'RE' => 'required|string',
        //     'LE' => 'required|string',
        //     'ADD' => 'required|string',
        //     'VA' => 'required|string',
        //     'PD' => 'required|string',
        //     'VA2' => 'required|string',
        //     'N' => 'required|string',
        //     'N2' => 'required|string',
        //     'SIGNS' => 'required|string',
        //     'remarks' => 'required|string',
        //     'treatment_given' => 'required|string',
        //     'next_appointment' => 'nullable|date',
        // ]);

        $consultation_id = $request->consultation_id;
        $customer_id = $request->customer_id;

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
        $prescription->next_appointment = $request->next_appointment ? date('Y-m-d', strtotime($request->next_appointment)) : Carbon::now()->addMonths(6)->format('Y-m-d');
        $prescription->created_by = Auth::user()->id;
        $prescription->created_at = Carbon::now();
        $prescription->location_id = Auth::user()->location_id;

        $prescription->save();

        if ($prescription->save()) {
            Consultation::findOrFail($consultation_id)->update([
                'status' => '1',
            ]);
        }

        $notification = array(
            'message' => 'Prescription Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('consultation.all')->with($notification);
    }

    public function PrescriptionStorePlain(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'customer_id' => 'nullable|integer',
            'name' => 'required_without:customer_id|string|max:255',
            'age' => 'required_without:customer_id|integer',
            'sex' => 'required_without:customer_id|string|max:10',
            'address' => 'required_without:customer_id|string|max:255',
            'phonenumber' => 'required_without:customer_id|string|max:15',
            'date' => 'required|date',
            'RE' => 'required|string',
            'LE' => 'required|string',
            'ADD' => 'required|string',
            'VA' => 'required|string',
            'PD' => 'required|string',
            'VA2' => 'required|string',
            'N' => 'required|string',
            'N2' => 'required|string',
            'SIGNS' => 'required|string',
            'remarks' => 'required|string',
            'treatment_given' => 'required|string',
            'next_appointment' => 'nullable|date',
        ]);

        $customer_id = $request->customer_id;

        // Set next_appointment to six months from now if not provided
        $next_appointment = $request->next_appointment ? date('Y-m-d', strtotime($request->next_appointment)) : Carbon::now()->addMonths(6)->format('Y-m-d');

        if ($customer_id) {
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
            $prescription->next_appointment = $next_appointment;
            $prescription->created_by = Auth::user()->id;
            $prescription->created_at = Carbon::now();
            $prescription->location_id = Auth::user()->location_id;

            $prescription->save();
        } else {
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->age = $request->age;
            $customer->sex = $request->sex;
            $customer->address = $request->address;
            $customer->phonenumber = $request->phonenumber;
            $customer->location_id = Auth::user()->location_id;
            $customer->created_at = Carbon::now();
            $customer->created_by = Auth::user()->id;

            $customer->save();

            $customer_id = $customer->id;

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
            $prescription->next_appointment = $next_appointment;
            $prescription->created_by = Auth::user()->id;
            $prescription->created_at = Carbon::now();
            $prescription->location_id = Auth::user()->location_id;

            $prescription->save();
        }

        $notification = array(
            'message' => 'Prescription Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('prescription.all')->with($notification);
    }

    public function PrescriptionView($id)
    {

        $data = Prescription::findOrFail($id);

        // dd($data);

        return view('backend.pdf.prescription_view', compact('data'));

    }

    public function PrescriptionDelete($id)
    {

        Prescription::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Prescription Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('prescription.all')->with($notification);

    }

    public function PrescriptionEdit($id)
    {

        $prescription = Prescription::findOrFail($id);

        // dd($prescription);

        return view('backend.prescription.prescription_edit', compact('prescription'));

    }

}
