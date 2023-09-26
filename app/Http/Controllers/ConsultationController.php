<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class ConsultationController extends Controller
{
    public function ConsultationAll(){

        $consultation = Consultation::latest()->get();

        return view('backend.consultation.consultation_all',compact('consultation'));

    }

    public function ConsultationAdd(){

        $customer = Customer::all();

        return view('backend.consultation.consultation_add',compact('customer'));

    }



    public function ConsultationStore(Request $request){

        $date = new DateTime('now', new DateTimeZone('Africa/Dar_es_Salaam'));

        if ($request->customer_id == '0') {

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->age = $request->age;
            $customer->sex = $request->sex;
            $customer->address = $request->address;
            $customer->phonenumber = $request->phonenumber;
            $customer->location_id = Auth::user()->location_id;
            $customer->created_by = Auth::user()->id;
            $customer->save();

            $consultation  = new Consultation();

            $customer_id = $customer->id;

            $consultation->customer_id = $customer_id;
            $consultation->date = $date;
            $consultation->status = 0;
            $consultation->consultation_fee = $request->consultation_fee;
            $consultation->created_by = Auth::user()->id;

            $consultation->save();

            $notification = array(
                'message' => 'Consultation Added Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('consultation.all')->with($notification);

        } else {

            $customer_id = $request->customer_id;

            $consultation  = new Consultation();
            $consultation->customer_id = $customer_id;
            $consultation->date = $date;
            $consultation->status = 0;
            $consultation->consultation_fee = $request->consultation_fee;
            $consultation->created_by = Auth::user()->id;

            $consultation->save();

            $notification = array(
                'message' => 'Consultation Added Successfully',
                'alert-type' => 'success',
            );

            return redirect()->route('consultation.all')->with($notification);

        }

    }



    public function ConsultationDelete($id){

        Consultation::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Consultation Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('consultation.all')->with($notification);


    }


}
