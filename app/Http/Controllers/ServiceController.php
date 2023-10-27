<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Auth;
use Illuminate\Support\Carbon;

class ServiceController extends Controller
{
    public function ServiceAll(){

        $service = Service::latest()->get();

        return view('backend.service.service_all',compact('service'));

    }

    public function ServiceAdd(){

        return view('backend.service.service_add');

    }


    public function ServiceStore(Request $request){

        Service::create([
            'name' => $request->name,
            'service_price' => $request->service_price,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
            'location_id' => Auth::user()->location_id,
        ]);

        $notification = array(
            'message' => 'Service Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('service.all')->with($notification);

    }

    public function ServiceEdit($id){

        $service = Service::findOrFail($id);

        return view('backend.service.service_edit',compact('service'));

    }


    public function ServiceUpdate(Request $request){

        $service_id = $request->id;

        Service::findOrFail($service_id)->update([
            'name' => $request->name,
            'service_price' => $request->service_price,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Service Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('service.all')->with($notification);

    }


    public function ServiceDelete($id){

        Service::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Service Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }



}
