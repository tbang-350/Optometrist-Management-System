<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class EmployeeController extends Controller
{
    public function EmployeeAll()
    {
        $users = User::latest()->where('role', '2')->get();

        return view('backend.employee.employee_all', compact('users'));

    } // End Method

    public function EmployeeAdd()
    {

        return view('backend.employee.employee_add');

    } // End Method

    public function EmployeeStore(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => '2',
            'password' => Hash::make($request->password),
        ]);

        $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('employee.all')->with($notification);

    } // End Method

    public function EmployeeEdit($id)
    {

        $user = User::findOrFail($id);

        return view('backend.employee.employee_edit', compact('user'));

    } // End Method

    public function EmployeeUpdate(Request $request)
    {
        $employee_id = $request->id;

        $user = User::findOrFail($employee_id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Check if status is checked (i.e., active)
        if ($request->status == 'on') {
            $user->status = true;
        } else {
            $user->status = false;
        }

        $user->save();

        $notification = array(
            'message' => 'Employee Updated Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('employee.all')->with($notification);
    }
    // End Method

    public function EmployeeDelete($id)
    {

        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Employee Deleted Successfully',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);

    } // End Method

}
