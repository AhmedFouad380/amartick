<?php

use App\Http\Controllers\Admin\InboxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;


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


Route::get('/login', function () {
    return view('login');
});


    Route::get('/sign-up', function () {
    return view('signup');
});

Route::POST('/signup', [\App\Http\Controllers\Admin\SupllierController::class, 'Register']);


Route::get('/admin/login', function () {
    return view('login');
});


Route::get('/Admin', function () {
    $users = \App\Models\User::count();
    return view('Admin.index', compact('users'));
});

Route::POST('/UserLogin', [\App\Http\Controllers\Admin\AdminController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\Admin\AdminController::class, 'logout']);
Route::get('/', function () {
    return view('Home');
});
Route::get('/Terms&Policy', function () {
    return view('Policy');
});
Route::group(['middleware' => 'Supplier'], function () {
    Route::get('/Admin-Panel', function () {
        $users = \App\Models\User::count();
        $supplier = \App\Models\Supplier::count();
        $today = Carbon\Carbon::today();
        $monthly_orders = \App\Models\Order::whereBetween('created_at', [$today->startOfMonth()->toDateTimeString(), $today->endOfMonth()->toDateTimeString()])->get();
        $monthly_projects = \App\Models\Project::whereBetween('created_at', [$today->startOfMonth()->toDateTimeString(), $today->endOfMonth()->toDateTimeString()])->count();
        return view('Admin.index', compact('users', 'supplier', 'monthly_orders', 'monthly_projects'));
    });
    Route::get('/Users', [UserController::class, 'index'])->middleware('Admin');

    Route::get('/Users', [UserController::class, 'index'])->middleware('Admin');
    Route::get('/UsersSearch', [UserController::class, 'Search'])->middleware('Admin');
    Route::get('/Edit_User', [UserController::class, 'edit'])->middleware('Admin');
    Route::get('/Edit_User_notation', [UserController::class, 'show']);

    Route::get('/Admins', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->middleware('Admin');;
    Route::get('/AdminsSearch', [\App\Http\Controllers\Admin\AdminController::class, 'search'])->middleware('Admin');;
    Route::get('/Edit_Admins', [\App\Http\Controllers\Admin\AdminController::class, 'edit'])->middleware('Admin');;
    Route::get('/UpdateStatusAdmin', [\App\Http\Controllers\Admin\AdminController::class, 'UpdateStatusUser'])->middleware('Admin');;
    Route::get('/Profile', [\App\Http\Controllers\Admin\AdminController::class, 'Profile']);
    Route::post('/Update_Profile', [\App\Http\Controllers\Admin\AdminController::class, 'Update_Profile']);

    Route::get('/Branches', [\App\Http\Controllers\Admin\SupllierController::class, 'Branches']);

    Route::get('/suppliers', [\App\Http\Controllers\Admin\SupllierController::class, 'index'])->middleware('Admin');
    Route::get('/suppliersSearch', [\App\Http\Controllers\Admin\SupllierController::class, 'suppliersSearch']);
    Route::post('/suppliers_store', [\App\Http\Controllers\Admin\SupllierController::class, 'store']);
    Route::get('/suppliers_delete', [\App\Http\Controllers\Admin\SupllierController::class, 'delete']);
    Route::get('/UpdateStatusSupplier', [\App\Http\Controllers\Admin\SupllierController::class, 'UpdateStatusSupplier']);
    Route::post('/SupplierActive', [\App\Http\Controllers\Admin\SupllierController::class, 'SupplierActive']);
    Route::get('/supplier/{id}', [\App\Http\Controllers\Admin\SupllierController::class, 'supplier']);


    Route::get('/Categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->middleware('Admin');;
    Route::get('/CategoriesSearch', [\App\Http\Controllers\Admin\CategoryController::class, 'Search'])->middleware('Admin');;
    Route::get('/Edit_Categories', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->middleware('Admin');;

    Route::get('/SubCategory/{id}', [\App\Http\Controllers\Admin\SubCategoryController::class, 'index'])->middleware('Admin');;
    Route::get('/SubCategorySearch', [\App\Http\Controllers\Admin\SubCategoryController::class, 'Search'])->middleware('Admin');;
    Route::get('/Edit_SubCategory', [\App\Http\Controllers\Admin\SubCategoryController::class, 'edit'])->middleware('Admin');;


    Route::get('/DeliveryTime/{id}', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'index'])->middleware('Admin');;
    Route::get('/DeliveryTimeSearch', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'Search'])->middleware('Admin');;
    Route::get('/Edit_DeliveryTime', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'edit'])->middleware('Admin');;

    Route::get('/Products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->middleware('Admin');
    Route::get('/ProductSearch', [\App\Http\Controllers\Admin\ProductController::class, 'Search'])->middleware('Admin');
    Route::get('/UpdateStatusProduct', [\App\Http\Controllers\Admin\ProductController::class, 'UpdateStatusProduct'])->middleware('Admin');

    Route::get('/Edit_Products', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->middleware('Admin');;

    Route::get('/SupplierProduct', [\App\Http\Controllers\Admin\SupplierProductController::class, 'index']);
    Route::get('/SupplierProducts/{id}', [\App\Http\Controllers\Admin\SupplierProductController::class, 'index2']);
    Route::get('/ProductsSearch', [\App\Http\Controllers\Admin\SupplierProductController::class, 'Search']);
    Route::get('/ChangeStatus', [\App\Http\Controllers\Admin\SupplierProductController::class, 'ChangeStatus']);
    Route::get('/ChangeStatus2', [\App\Http\Controllers\Admin\SupplierProductController::class, 'ChangeStatus2']);

    Route::get('/ProductsImages/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'ProductsImages']);
    Route::get('/Edit_ProductsImages', [\App\Http\Controllers\Admin\ProductController::class, 'Edit_ProductsImages'])->middleware('Admin');;
    Route::post('/Create_ProductsImages', [\App\Http\Controllers\Admin\ProductController::class, 'Create_ProductsImages'])->middleware('Admin');;
    Route::get('/Delete_ProductsImages', [\App\Http\Controllers\Admin\ProductController::class, 'Delete_ProductsImages'])->middleware('Admin');;
    Route::post('/Update_ProductsImages', [\App\Http\Controllers\Admin\ProductController::class, 'Update_ProductsImages'])->middleware('Admin');;
// region
    //    region
    Route::get('/regions', [\App\Http\Controllers\Admin\regionController::class, 'index'])->middleware('Admin');
    Route::post('/create-region', [\App\Http\Controllers\Admin\regionController::class, 'store'])->middleware('Admin');
    Route::get('/edit-region', [\App\Http\Controllers\Admin\regionController::class, 'edit'])->middleware('Admin');;
    Route::post('/update-region', [\App\Http\Controllers\Admin\regionController::class, 'update'])->middleware('Admin');;
    Route::get('/delete-region', [\App\Http\Controllers\Admin\regionController::class, 'delete'])->middleware('Admin');;
//    workDays
    Route::get('/workDays', [\App\Http\Controllers\Admin\workDaysController::class, 'index'])->middleware('Admin');
    Route::get('/edit-workDays', [\App\Http\Controllers\Admin\workDaysController::class, 'edit'])->middleware('Admin');;
    Route::post('/update-workDays', [\App\Http\Controllers\Admin\workDaysController::class, 'update'])->middleware('Admin');;

//    cities
    Route::get('/Cities', [\App\Http\Controllers\Admin\CityController::class, 'index'])->middleware('Admin');
    Route::post('/create-city', [\App\Http\Controllers\Admin\CityController::class, 'store'])->middleware('Admin');
    Route::get('/edit-city', [\App\Http\Controllers\Admin\CityController::class, 'edit'])->middleware('Admin');;
    Route::post('/update-city', [\App\Http\Controllers\Admin\CityController::class, 'update'])->middleware('Admin');;
    Route::get('/delete-city', [\App\Http\Controllers\Admin\CityController::class, 'delete'])->middleware('Admin');;
//    districts
    Route::get('/District', [\App\Http\Controllers\Admin\DistrictController::class, 'index'])->middleware('Admin');
    Route::post('/create-district', [\App\Http\Controllers\Admin\DistrictController::class, 'store'])->middleware('Admin');
    Route::get('/edit-district', [\App\Http\Controllers\Admin\DistrictController::class, 'edit'])->middleware('Admin');;
    Route::post('/update-district', [\App\Http\Controllers\Admin\DistrictController::class, 'update'])->middleware('Admin');;
    Route::get('/delete-district', [\App\Http\Controllers\Admin\DistrictController::class, 'delete'])->middleware('Admin');;

    //    BranchAccounts
    Route::get('/BranchAccount/{id}', [\App\Http\Controllers\Admin\BranchAccountController::class, 'index'])->middleware('Admin');
    Route::post('/create-BranchAccount', [\App\Http\Controllers\Admin\BranchAccountController::class, 'store'])->middleware('Admin');
//    Route::get('/edit-BranchAccount', [\App\Http\Controllers\Admin\BranchAccountController::class, 'edit'])->middleware('Admin');;
//    Route::post('/update-BranchAccount', [\App\Http\Controllers\Admin\BranchAccountController::class, 'update'])->middleware('Admin');;
//    Route::get('/delete-BranchAccount', [\App\Http\Controllers\Admin\BranchAccountController::class, 'delete'])->middleware('Admin');;

    //    AccouontRequests
    Route::get('/AccouontRequests', [\App\Http\Controllers\Admin\AccouontRequestsController::class, 'index']);
    Route::get('/AccouontRequestSearch', [\App\Http\Controllers\Admin\AccouontRequestsController::class, 'search']);
    Route::post('/create-AccouontRequests', [\App\Http\Controllers\Admin\AccouontRequestsController::class, 'store']);
    Route::get('/edit-AccouontRequests', [\App\Http\Controllers\Admin\AccouontRequestsController::class, 'edit'])->middleware('Admin');;
    Route::post('/update-AccouontRequests', [\App\Http\Controllers\Admin\AccouontRequestsController::class, 'update'])->middleware('Admin');;
    Route::get('/delete-AccouontRequests', [\App\Http\Controllers\Admin\AccouontRequestsController::class, 'delete'])->middleware('Admin');;

    /*deligates*/

    Route::get('/deligates', [\App\Http\Controllers\Admin\DeligateController::class, 'index']);
    Route::post('/create-deligate', [\App\Http\Controllers\Admin\DeligateController::class, 'store']);
    Route::get('/edit-deligate', [\App\Http\Controllers\Admin\DeligateController::class, 'edit']);
    Route::post('/update-deligate', [\App\Http\Controllers\Admin\DeligateController::class, 'update']);
    Route::get('/delete-deligate', [\App\Http\Controllers\Admin\DeligateController::class, 'delete']);



    /*end deligates*/
    Route::get('/UserProjects/{id}', [\App\Http\Controllers\Admin\ProjectsController::class, 'index'])->middleware('Admin');;
    Route::get('/wallet/{id}', [\App\Http\Controllers\Admin\ProjectsController::class, 'Wallet'])->middleware('Admin');
    Route::post('/add-wallet', [\App\Http\Controllers\Admin\ProjectsController::class, 'store'])->middleware('Admin');


    Route::post('/Create_Users', [UserController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_Users', [UserController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_Users', [UserController::class, 'update'])->middleware('Admin');;

    Route::post('/Create_Products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_Products', [\App\Http\Controllers\Admin\ProductController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_Products', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->middleware('Admin');;

    Route::post('/Create_Admins', [\App\Http\Controllers\Admin\AdminController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_Admins', [\App\Http\Controllers\Admin\AdminController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_Admins', [\App\Http\Controllers\Admin\AdminController::class, 'update'])->middleware('Admin');;

    Route::post('/Create_Categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_Categories', [\App\Http\Controllers\Admin\CategoryController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_Catgories', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->middleware('Admin');;

    Route::post('/Create_SubCategory', [\App\Http\Controllers\Admin\SubCategoryController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_SubCategory', [\App\Http\Controllers\Admin\SubCategoryController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_SubCategory', [\App\Http\Controllers\Admin\SubCategoryController::class, 'update'])->middleware('Admin');;

    Route::post('/Create_Company', [\App\Http\Controllers\Admin\CompanyController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_Company', [\App\Http\Controllers\Admin\CompanyController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_Company', [\App\Http\Controllers\Admin\CompanyController::class, 'update'])->middleware('Admin');;
    Route::get('/Edit_Company', [\App\Http\Controllers\Admin\CompanyController::class, 'edit'])->middleware('Admin');;
    Route::get('/CompanySearch', [\App\Http\Controllers\Admin\CompanyController::class, 'Search'])->middleware('Admin');;
    Route::get('/Company', [\App\Http\Controllers\Admin\CompanyController::class, 'index'])->middleware('Admin');;

    Route::post('/Create_DeliveryTime', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'store'])->middleware('Admin');;
    Route::get('/Delete_DeliveryTime', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'delete'])->middleware('Admin');;
    Route::post('/Update_DeliveryTime', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'update'])->middleware('Admin');;

    Route::post('/store_event', 'Admin\EventsController@store')->middleware('Admin');;
    Route::get('/changePass', 'Admin\UserController@changePass')->middleware('Admin');;
    Route::get('/getHolidays', 'Admin\AskPermissionController@getHolidays')->middleware('Admin');;


    Route::get('/orders', [\App\Http\Controllers\Admin\OrdersController::class, 'index']);
    Route::get('/orders-datatable', [\App\Http\Controllers\Admin\OrdersController::class, 'datatable'])->name('orders.datatable.data');
    Route::post('/DeliveryOrder', [\App\Http\Controllers\Admin\OrdersController::class, 'DeliveryOrder']);
    Route::get('/OrderSearch', [\App\Http\Controllers\Admin\OrdersController::class, 'search']);

    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrdersController::class, 'singleOrder']);
    Route::get('/orders_ajax/{id}', [\App\Http\Controllers\Admin\OrdersController::class, 'singleOrder_ajax']);
    Route::get('/order-details', [\App\Http\Controllers\Admin\OrdersController::class, 'OrderDetails']);
    Route::get('/pending-orders/{id?}', [\App\Http\Controllers\Admin\OrdersController::class, 'pending_orders']);

    Route::get('/order/accept', [\App\Http\Controllers\Admin\OrdersController::class, 'Accept']);
    Route::get('/order/reject', [\App\Http\Controllers\Admin\OrdersController::class, 'Reject']);

//    deligate
    Route::post('/addDeligate', [\App\Http\Controllers\Admin\OrdersController::class, 'AddDeligate']);
    Route::post('/deligate-code', [\App\Http\Controllers\Admin\OrdersController::class, 'CheckDeligate']);


    Route::get('/check', function () {
        Artisan::call('notification:send');
    });

    Route::get('/inbox', [InboxController::class, 'index']);
    Route::get('/outbox', [InboxController::class, 'outbox']);


    Route::get('/inbox/{id}', [InboxController::class, 'SingleInbox']);
    Route::get('/replies/{id}', [InboxController::class, 'Replies']);
    Route::get('/get-users/{type}', [InboxController::class, 'getUsers']);
    Route::post('/sendInbox', [InboxController::class, 'store']);
    Route::post('/sendReply', [InboxController::class, 'StoreReply']);

    Route::post('/Update_Setting', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->middleware('Admin');;
    Route::get('/Setting', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->middleware('Admin');;


    //    roles
    Route::get('/roles', [\App\Http\Controllers\Admin\RolesController::class, 'index'])->middleware('Admin');
    Route::post('/roles/store', [\App\Http\Controllers\Admin\RolesController::class, 'store'])->name('roles.store')->middleware('Admin');
    Route::get('/roles/edit', [\App\Http\Controllers\Admin\RolesController::class, 'edit'])->name('roles.edit')->middleware('Admin');;
    Route::post('/roles/update_permission', [\App\Http\Controllers\Admin\RolesController::class, 'update'])->name('roles.update_permission')->middleware('Admin');;
    Route::get('/role/delete', [\App\Http\Controllers\Admin\RolesController::class, 'delete'])->name('roles.delete_role')->middleware('Admin');;


});


Route::get('/CronReOrder', [\App\Http\Controllers\Admin\OrdersController::class, 'CronReOrder']);

Route::get('lang/{lang}', function ($lang) {

    if (session()->has('lang')) {
        session()->forget('lang');
    }
    if ($lang == 'en') {
        session()->put('lang', 'en');
    } else {
        session()->put('lang', 'ar');
    }


    return back();
});

Route::get('/GetSubCategory/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'GetSubCategory'])->middleware('Admin');;

Route::get('/PaymentPage', [\App\Http\Controllers\PaymentController::class, 'PaymentPage']);
Route::get('/PaymentSTC', [\App\Http\Controllers\PaymentController::class, 'PaymentSTC']);
Route::get('/PaymentApplyPay', [\App\Http\Controllers\PaymentController::class, 'PaymentApplyPay']);
Route::get('/PaymentStatus', [\App\Http\Controllers\PaymentController::class, 'PaymentStatus']);
Route::get('/WalletStatus', [\App\Http\Controllers\PaymentController::class, 'WalletStatus']);

Route::post('/store_event', [\App\Http\Controllers\Admin\EventsController::class, 'store']);
Route::get('/Wallet_Charging', [\App\Http\Controllers\PaymentController::class, 'Wallet_Charging']);
Route::get('/Wallet_ChargingSTC', [\App\Http\Controllers\PaymentController::class, 'Wallet_ChargingSTC']);


Route::get('/OrderNotification', [\App\Http\Controllers\Admin\OrdersController::class, 'OrderNotification']);
Route::get('/OrderCancelled', [\App\Http\Controllers\Admin\OrdersController::class, 'OrderCancelled']);

