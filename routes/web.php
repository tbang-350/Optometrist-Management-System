<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceInvoiceController;
use App\Http\Controllers\SupplierController;
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
    // Route::controller(UnitController::class)->group(function () {
    //     Route::get('/unit/all', 'UnitAll')->name('unit.all');
    //     Route::get('/unit/add', 'UnitAdd')->name('unit.add');
    //     Route::post('/unit/store', 'UnitStore')->name('unit.store');
    //     Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
    //     Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
    //     Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');
    // });

    // Category Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'CategoryAll')->name('category.all');
        Route::get('/category/add', 'CategoryAdd')->name('category.add');
        Route::post('/category/store', 'CategoryStore')->name('category.store');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::post('/category/update', 'CategoryUpdate')->name('category.update');
        Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');
    });

    // Product Routes
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product/all', 'ProductAll')->name('product.all');
        Route::get('/product/add', 'ProductAdd')->name('product.add');
        Route::post('/product/store', 'ProductStore')->name('product.store');
        Route::get('/product/edit/{id}', 'ProductEdit')->name('product.edit');
        Route::post('/product/update', 'ProductUpdate')->name('product.update');
        Route::get('/product/delete/{id}', 'ProductDelete')->name('product.delete');
    });

    // Purchase Routes
    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/purchase/all', 'PurchaseAll')->name('purchase.all');
        Route::get('/purchase/add', 'PurchaseAdd')->name('purchase.add');
        Route::post('/purchase/store', 'PurchaseStore')->name('purchase.store');
        Route::get('/purchase/delete/{id}', 'PurchaseDelete')->name('purchase.delete');
        Route::get('/purchase/pending', 'PurchasePending')->name('purchase.pending');
        Route::get('/purchase/approve/{id}', 'PurchaseApprove')->name('purchase.approve');
        Route::get('/daily/purchase/report', 'DailyPurchaseReport')->name('daily.purchase.report');
        Route::get('/daily/purchase/pdf', 'DailyPurchasePdf')->name('daily.purchase.pdf');
    });

    // Invoice Routes
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice/all', 'InvoiceAll')->name('invoice.all');
        Route::get('/invoice/add', 'InvoiceAdd')->name('invoice.add');
        Route::post('/invoice/store', 'InvoiceStore')->name('invoice.store');
        Route::get('/invoice/pending/list', 'PendingList')->name('invoice.pending.list');
        Route::get('/invoice/delete/{id}', 'InvoiceDelete')->name('invoice.delete');
        Route::get('/invoice/approve/{id}', 'InvoiceApprove')->name('invoice.approve');
        Route::post('/approval/store/{id}', 'ApprovalStore')->name('approval.store');
        Route::get('/print/invoice/list', 'PrintInvoiceList')->name('print.invoice.list');
        Route::get('/print/invoice/{id}', 'PrintInvoice')->name('print.invoice');
        Route::get('/daily/invoice/report', 'DailyInvoiceReport')->name('daily.invoice.report');
        Route::get('/daily/invoice/pdf', 'DailyInvoicePdf')->name('daily.invoice.pdf');

    });

    //Service Invoice Routes
    Route::controller(ServiceInvoiceController::class)->group(function () {
        Route::get('/service/invoice/all', 'ServiceInvoiceAll')->name('service.invoice.all');
        Route::get('/service/invoice/add', 'ServiceInvoiceAdd')->name('service.invoice.add');
        Route::post('/service/invoice/store', 'ServiceInvoiceStore')->name('service.invoice.store');
        Route::get('/print/service/invoice/{id}', 'PrintServiceInvoice')->name('print.service.invoice');
        Route::get('/daily/service/invoice/report', 'DailyServiceInvoiceReport')->name('daily.service.invoice.report');
        Route::get('/daily/service/invoice/pdf', 'DailyServiceInvoicePdf')->name('daily.service.invoice.pdf');
        Route::get('/service/invoice/payment/report', 'ServiceInvoicePaymentReport')->name('service.invoice.payment.report');
        Route::get('/service/payment/option/report', 'servicePaymentOptionReport')->name('service.payment.option.report');

    });

});

// Default Routes
Route::controller(DefaultController::class)->group(function () {
    Route::get('/get-category', 'GetCategory')->name('get-category');
    Route::get('/get-product', 'GetProduct')->name('get-product');
    Route::get('/check_product', 'GetStock')->name('check_product_stock');
    Route::get('/get-buying-unit-price', 'GetBuyingUnitPrice')->name('get_buying_unit_price');
    Route::get('/autocomplete/suppliers', 'AutocompleteSuppliers')->name('autocomplete.suppliers');
    Route::get('/autocomplete/categories', 'AutocompleteCategories')->name('autocomplete.categories');
    Route::get('/autocomplete/products', 'AutocompleteProducts')->name('autocomplete.products');

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
