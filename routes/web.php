<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    //Admin Controller
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'Profile')->name('admin.profile');
        Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
        Route::post('/store/profile', 'StoreProfile')->name('store.profile');

        Route::get('/change/password', 'ChangePassword')->name('change.password');
        Route::post('/update/password', 'UpdatePassword')->name('update.password');

    });

     //Employee Routes
     Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee/all', 'EmployeeAll')->name('employee.all')->middleware('employee');
        Route::get('/employee/add', 'EmployeeAdd')->name('employee.add')->middleware('employee');
        Route::post('employee/store', 'EmployeeStore')->name('employee.store')->middleware('employee');
        Route::get('/employee/edit/{id}', 'EmployeeEdit')->name('employee.edit')->middleware('employee');
        Route::post('/employee/update', 'EmployeeUpdate')->name('employee.update')->middleware('employee');
        Route::get('/employee/delete/{id}', 'EmployeeDelete')->name('employee.delete')->middleware('employee');
    });


    //Location Routes
    Route::controller(LocationController::class)->group(function () {
        Route::get('/location/all', 'LocationAll')->name('location.all')->middleware('employee');
        Route::get('/location/add', 'LocationAdd')->name('location.add')->middleware('employee');
        Route::post('/location/store', 'LocationStore')->name('location.store')->middleware('employee');
        Route::get('/location/edit/{id}', 'LocationEdit')->name('location.edit')->middleware('employee');
        Route::post('/location/update', 'LocationUpdate')->name('location.update')->middleware('employee');
        Route::get('/location/delete/{id}', 'LocationDelete')->name('location.delete')->middleware('employee');
    });


    //Customer Routes
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customer/all', 'CustomerAll')->name('customer.all');
        Route::get('/customer/add', 'CustomerAdd')->name('customer.add');
        Route::post('/customer/store', 'CustomerStore')->name('customer.store');
        Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
        Route::post('/customer/update', 'CustomerUpdate')->name('customer.update');
        Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');
    });

    

});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
