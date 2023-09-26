<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;

use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CategoryController;


use Illuminate\Support\Facades\Route;

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

        Route::get('/view/company/detail', 'ViewCompanyDetail')->name('view.company.detail');
        Route::get('/edit/company/detail', 'EditCompanyDetail')->name('edit.company.detail');
        Route::post('/store/company/detail', 'StoreCompanyDetail')->name('store.company.detail');

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

    //Service Routes
    Route::controller(ServiceController::class)->group(function () {
        Route::get('/service/all', 'ServiceAll')->name('service.all');
        Route::get('/service/add', 'ServiceAdd')->name('service.add');
        Route::post('/service/store', 'ServiceStore')->name('service.store');
        Route::get('/service/edit/{id}', 'ServiceEdit')->name('service.edit');
        Route::post('/service/update', 'ServiceUpdate')->name('service.update');
        Route::get('/service/delete/{id}', 'ServiceDelete')->name('service.delete');
    });

    //Consultation Routes
    Route::controller(ConsultationController::class)->group(function () {
        Route::get('/consultation/all', 'ConsultationAll')->name('consultation.all');
        Route::get('/consultation/add', 'ConsultationAdd')->name('consultation.add');
        Route::post('/consultation/store', 'ConsultationStore')->name('consultation.store');
//        Route::get('/service/edit/{id}', 'ServiceEdit')->name('service.edit');
//        Route::post('/service/update', 'ServiceUpdate')->name('service.update');
        Route::get('/consultation/delete/{id}', 'ConsultationDelete')->name('consultation.delete');
    });

    //Prescription Routes
    Route::controller(PrescriptionController::class)->group(function () {
        Route::get('/prescription/all', 'PrescriptionAll')->name('prescription.all');
        Route::get('/prescription/add/{id}', 'PrescriptionAdd')->name('prescription.add');
        Route::post('/prescription/store', 'PrescriptionStore')->name('prescription.store');
        Route::get('/prescription/view/{id}', 'PrescriptionView')->name('prescription.view');
//        Route::post('/service/update', 'ServiceUpdate')->name('service.update');
//        Route::get('/service/delete/{id}', 'ServiceDelete')->name('service.delete');
    });

    //Supplier Routes
    Route::controller(SupplierController::class)->group(function () {
        Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
        Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
        Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
        Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
        Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
        Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');
    });


    // Unit Routes
    Route::controller(UnitController::class)->group(function () {
        Route::get('/unit/all', 'UnitAll')->name('unit.all');
        Route::get('/unit/add', 'UnitAdd')->name('unit.add');
        Route::post('/unit/store', 'UnitStore')->name('unit.store');
        Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
        Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
        Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');
    });


    // Category Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'CategoryAll')->name('category.all');
        Route::get('/category/add', 'CategoryAdd')->name('category.add');
        Route::post('/category/store', 'CategoryStore')->name('category.store');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::post('/category/update', 'CategoryUpdate')->name('category.update');
        Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');
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
