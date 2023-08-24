<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use Auth;
use Illuminate\Support\Carbon;

class LocationController extends Controller
{
    public function LocationAll(){

        $locations = Location::latest()->get();

        return view('backend.location.location_all',compact('locations'));
    }


    public function LocationAdd(){

        return view('backend.location.location_add');

    }

    public function LocationStore(Request $request){

        Location::create([
            'location_name' => $request->location_name,
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
        ]);

        $notification = array(
            'message' => 'Location Added Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('location.all')->with($notification);

    }


    public function LocationEdit($id){

        $location = Location::findOrFail($id);

        return view('backend.location.location_edit',compact('location'));

    }


    public function LocationUpdate(Request $request){

        $location_id = $request->id;

        Location::findOrFail($location_id)->update([
            'location_name' => $request->location_name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Location Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('location.all')->with($notification);

    }


    public function LocationDelete($id){

        Location::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Location Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    }

}
