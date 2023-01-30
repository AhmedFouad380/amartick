<?php

use App\Http\Controllers\Api\InboxController;
use App\Http\Controllers\Api\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/getOrders', [\App\Http\Controllers\Api\OrderController::class, 'getOrders']);
    Route::post('/StoreOrder', [\App\Http\Controllers\Api\OrderController::class, 'StoreOrder']);
    Route::post('/OrderDates', [\App\Http\Controllers\Api\OrderController::class, 'OrderDates']);
    Route::post('/Store_Orders', [\App\Http\Controllers\Api\OrderController::class, 'Store_Order']);
    Route::post('/CancelOrder', [\App\Http\Controllers\Api\OrderController::class, 'CancelOrder']);
    Route::post('/ChangePaymentStatus', [\App\Http\Controllers\Api\OrderController::class, 'ChangePaymentStatus']);
    Route::post('/ReOrder', [\App\Http\Controllers\Api\OrderController::class, 'ReOrder']);
    Route::post('/GenerateDeliveryCode', [\App\Http\Controllers\Api\OrderController::class, 'GenerateDeliveryCode']);
    Route::post('/DeleteDeliveryCode', [\App\Http\Controllers\Api\OrderController::class, 'DeleteDeliveryCode']);

    Route::post('/CreateProject', [\App\Http\Controllers\Api\ProjectController::class, 'CreateProject']);
    Route::post('/UpdateProject', [\App\Http\Controllers\Api\ProjectController::class, 'update']);
    Route::post('/GetProjects', [\App\Http\Controllers\Api\ProjectController::class, 'GetProjects']);
    Route::post('/GetProjectsNames', [\App\Http\Controllers\Api\ProjectController::class, 'GetProjectsNames']);
    Route::post('/GetProject', [\App\Http\Controllers\Api\ProjectController::class, 'GetProject']);
    Route::post('/DeleteProject', [\App\Http\Controllers\Api\ProjectController::class, 'delete']);

    Route::post('/GetWallet', [\App\Http\Controllers\Api\WalletController::class, 'GetWallet']);
    Route::post('/ApplePayChargingWellet', [\App\Http\Controllers\PaymentController::class, 'ApplePayChargingWellet']);
    Route::post('/WalletPayment', [\App\Http\Controllers\Api\OrderController::class, 'WalletPayment']);

    Route::post('/UpdateUser', [AuthController::class, 'Update']);
    Route::post('/Profile', [AuthController::class, 'Profile']);

//inboxes
    Route::get('/inbox', [InboxController::class, 'index']);
    Route::get('/replies/{id}', [InboxController::class, 'Replies']);
    Route::get('/read/{id}', [InboxController::class, 'Read']);
    Route::get('/get-admin', [InboxController::class, 'getAdmin']);
    Route::post('/sendInbox', [InboxController::class, 'store']);
    Route::post('/sendReply', [InboxController::class, 'StoreReply']);
    Route::post('/search-inbox', [InboxController::class, 'Search']);
    Route::get('/get-notification', [InboxController::class, 'getNotification']);

//    ask money from wallet
    Route::post('/request-amount', [WalletController::class, 'RequestAmount']);

    Route::post('/transfer-amount', [WalletController::class, 'TransferAmount']);


    Route::get('/ProjectsReport', [\App\Http\Controllers\Api\ReportController::class, 'ProjectsReport']);
    Route::post('/PaymentReport', [\App\Http\Controllers\Api\ReportController::class, 'PaymentReport']);
    Route::post('/ProductReport', [\App\Http\Controllers\Api\ReportController::class, 'ProductReport']);
    Route::post('/ProjectDetailsReport', [\App\Http\Controllers\Api\ReportController::class, 'ProjectDetailsReport']);
    Route::post('/shareProjectDetailsReport', [\App\Http\Controllers\Api\ReportController::class, 'ReportShare']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});
Route::get('/unauthrized', [AuthController::class, 'unauthrized'])->name('login');

Route::post('/LoginUser', [AuthController::class, 'login']);
Route::post('/RegisterUser', [AuthController::class, 'store']);
Route::post('/forget_pass', [AuthController::class, 'forget_pass']);
Route::post('/confirm_code', [AuthController::class, 'confirm_code']);
Route::post('/ChangePass', [AuthController::class, 'ChangePass']);
Route::get('/Setting', [AuthController::class, 'Setting']);

Route::post('/MainCategories', [\App\Http\Controllers\Api\CategoryController::class, 'MainCategories']);
Route::post('/SubCategories', [\App\Http\Controllers\Api\CategoryController::class, 'SubCategories']);
Route::post('/MainCategoriesList', [\App\Http\Controllers\Api\CategoryController::class, 'MainCategoriesList']);

Route::post('/Products', [\App\Http\Controllers\Api\ProductController::class, 'index']);

Route::get('/StoreCart', [\App\Http\Controllers\Api\CartController::class, 'StoreCart2']);
Route::get('/ChangeCartCount', [\App\Http\Controllers\Api\CartController::class, 'StoreCart']);
Route::post('/getCart', [\App\Http\Controllers\Api\CartController::class, 'getCart']);
Route::post('/PayDetails', [\App\Http\Controllers\Api\CartController::class, 'PayDetails']);
Route::post('/DeleteCart', [\App\Http\Controllers\Api\CartController::class, 'DeleteCart']);
Route::post('/CartCount', [\App\Http\Controllers\Api\CartController::class, 'CartCount']);


Route::get('/GetCities', [\App\Http\Controllers\Api\CountryController::class, 'GetCities']);
Route::post('/GetTowns', [\App\Http\Controllers\Api\CountryController::class, 'GetTowns']);

//suppliers
Route::group(['middleware' => 'auth:suppliers-api'], function () {
    Route::post('supplier/branch-account', [\App\Http\Controllers\Api\Supplier\BranchAccountController::class, 'branchAccount']);
    Route::post('supplier/request-account', [\App\Http\Controllers\Api\Supplier\BranchAccountController::class, 'RequestAccount']);
    Route::get('supplier/manager-branches', [\App\Http\Controllers\Api\Supplier\BranchAccountController::class, 'ManagerBranches']);
    Route::post('supplier/request-list', [\App\Http\Controllers\Api\Supplier\BranchAccountController::class, 'RequestList']);


    Route::get('supplier/inbox', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'index']);
    Route::get('supplier/replies/{id}', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'Replies']);
    Route::get('supplier/read/{id}', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'Read']);
    Route::get('supplier/get-admin', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'getAdmin']);
    Route::post('supplier/sendInbox', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'store']);
    Route::post('supplier/sendReply', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'StoreReply']);
    Route::post('supplier/search-inbox', [\App\Http\Controllers\Api\Supplier\InboxController::class, 'Search']);

    Route::get('supplier/PandingOrders', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'pending_orders']);
    Route::post('supplier/AcceptOrder', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'Accept']);
    Route::post('supplier/RejectOrder', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'Reject']);
    Route::post('supplier/GetOrders', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'getOrders']);
    Route::post('supplier/OrdersCounts', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'OrdersCounts']);
    Route::post('supplier/DeliveryOrderCode', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'DeliveryOrder']);
    Route::post('supplier/addDeligate', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'AddDeligate']);
    Route::get('supplier/get_deligates/{id}', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'get_deligates']);

    Route::post('supplier/deligate-code', [\App\Http\Controllers\Api\Supplier\OrderController::class, 'CheckDeligate']);

    Route::get('supplier/logout', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'logout']);
    Route::post('supplier/UpdateSupplier', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'Update']);
    Route::get('supplier/Profile', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'Profile']);
    Route::post('supplier/MainCategories', [\App\Http\Controllers\Api\CategoryController::class, 'MainCategories']);

    Route::post('supplier/DeliveryTime', [\App\Http\Controllers\Admin\DeliveryTimeController::class, 'index2']);

});
Route::post('supplier/forget_pass', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'forget_pass']);
Route::post('supplier/confirm_code', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'confirm_code']);
Route::post('supplier/ChangePass', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'ChangePass']);

Route::post('supplier/LoginSupplier', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'login']);
Route::post('supplier/RegisterSupplier', [\App\Http\Controllers\Api\Supplier\AuthController::class, 'Register']);
Route::post('supplier/MainCategoriesList', [\App\Http\Controllers\Api\CategoryController::class, 'MainCategoriesList']);


Route::get('/OrderShare/{id}', [\App\Http\Controllers\Api\OrderController::class, 'OrderShare']);
Route::get('supplier/OrderShare/{id}', [\App\Http\Controllers\Api\OrderController::class, 'OrderShare']);

