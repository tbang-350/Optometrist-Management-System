<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;

class AdminController extends Controller
{

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    } // End Method


    public function Profile(){

        $id = Auth::user()->id;

        $adminData = User::find($id);

        return view('admin.admin_profile_view',compact('adminData'));

    } // End Method


    public function EditProfile(){

        $id = Auth::user()->id;

        $editData = User::find($id);

        return view('admin.admin_profile_edit',compact('editData'));

    } // End Method


    public function StoreProfile(Request $request){

        $id = Auth::user()->id;

        $data = User::find($id);

        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;

        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');

            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_image'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Profile Updated Succesfully',
            'alert-type' => 'info'
        );

        return redirect()->route('admin.profile')->with($notification);


    } // End Method


    public function ChangePassword(){

        return view('admin.admin_change_password');

    } // End Method

    public function UpdatePassword(Request $request){

        $validateData = $request->validate([

            'oldpassword' => 'required',
            'newpassword' => 'required',
            'confirm_password' => 'required | same:newpassword',

        ]);

        $hashedPassword = Auth::user()->password;

        if (Hash::check($request->oldpassword, $hashedPassword)) {

            $users = User::find(Auth::id());
            $users->password = bcrypt($request->newpassword);
            $users->save();

            session()->flash('message','Password Updated Succesfully');

            return redirect()->back();
        } else {
            session()->flash('message','Old Password Does not match');

            return redirect()->back();
        }

    } // End Method


    public function ViewCompanyDetail()
    {

        $company = Company::latest()->first();

        // dd($company);

        return view('company.company_details_view', compact('company'));

    } // End Method


    public function EditCompanyDetail()
    {

        $company = Company::first();

        // dd($company);

        return view('company.company_edit_details', compact('company'));

    } // End Method


    public function StoreCompanyDetail(Request $request)
    {

        $company = Company::first();

        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->company_address = $request->company_address;
        $company->company_phone = $request->company_phone;

        $company->save();

        $notification = array(
            'message' => 'Company Details Updated Successfully',
            'alert-type' => 'info',
        );

        return redirect()->route('view.company.detail')->with($notification);

    } // End Method

}

