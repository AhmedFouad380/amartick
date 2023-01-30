<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BranchAccount;
use App\Models\Cart;
use App\Models\Inbox;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Project;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\SuppliersOrders;
use App\Models\Wallet;
use App\Models\WorkDays;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;


class OrderController extends Controller
{

    public function getOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        // Start Change Order Type
        $data = Order::where('type', 'pending')->get();

        foreach ($data as $Order) {
            $main_category = MainCategory::find($Order->main_category_id);
            $UpdatedDay = Carbon::parse($Order->updated_at)->format('l');
            $UpdatedTime = Carbon::parse($Order->updated_at)->format('H:i');
            $workDay = WorkDays::where('day_en', 'like', $UpdatedDay)->first();
            $min = ($Order->reorderTime / 60) + $main_category->max_time_reorder;
            $date = Carbon::parse($Order->updated_at)->addMinutes($min);
            if (date('Y-m-d H:i:s') > $date) {
                $Order->type = 'ReOrder';
                $Order->save();
            }
        }
        // End Change Order Type

        if (isset($request->type) || isset($request->project_id) || isset($request->from_date) || isset($request->to_date) || isset($request->MainCategory) || isset($request->from_price) || isset($request->to_price)) {
            $query = Order::where('user_id', $request->user_id);
            if (isset($request->from_date)) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if (isset($request->to_date)) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }
            if (isset($request->from_price)) {
                $query->where('total_price', '>=', $request->from_price);
            }
            if (isset($request->to_price)) {
                $query->where('total_price', '<=', $request->to_price);
            }

            if (isset($request->main_category_id)) {
                $query->where('main_category_id', $request->main_category_id);
            }
            if (isset($request->project_id)) {
                $query->where('project_id', $request->project_id);
            }
            if (isset($request->type)) {
                $query->where('type', $request->type);
            }
            if ($request->type == 'Delivered') {
                $query->OrderBy('delivery_date', 'desc');
            } else {
                $query->OrderBy('id', 'desc');
            }
            $data = $query->with('MainCategory')->with('Project')->with('deliveryTime')->with('MainCategory')->with('OrderDetails')->get();
        } else {
            $data = Order::OrderBy('id', 'desc')->where('user_id', $request->user_id)->with('deliveryTime')->with('Project')->with('MainCategory')->with('OrderDetails')->get();

        }

        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));
        } else {
            return response()->json(msgdata($request, error(), 'nodata', []));
        }
    }


    public function OrderDates(Request $request)
    {

        $data = OrderDate::where('order_id', $request->order_id)->get();

        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));

        } else {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));


        }
    }

    public function CancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        $data = Order::find($request->order_id);
        if ($data->has_deligate == 1) {
            return response()->json(msgdata($request, error(), 'CancelOrderError', (object)[]));
        }
        if ($data->payment_status == 1) {
            $Wallet = new Wallet();
            $Wallet->type = 'deposit';
            $Wallet->user_id = $data->user_id;
            $Wallet->project_id = $data->project_id;
            $Wallet->price = $data->total_price;
            $Wallet->order_id = $data->id;
            $description = $data->id . 'تم اضافة رصيد الى المحقظة مرتجع الطلب رقم ';
            $Wallet->description = $description;
            $Wallet->save();

            $inbox = new Inbox();
            $inbox->message = " تم اضافة رصيد الى المحقظة مرتجع الطلب رقم  " . $data->id;
            $inbox->receiver_id = $data->user_id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = Admin::where('type', 'Admin')->first()->id;
            $inbox->sender_type = "admin";
            $inbox->order_id = $data->id;
            $inbox->save();
        }
        $data->type = 'Cancelled';
        $data->save();
        $OrderDate = new OrderDate;
        $OrderDate->order_id = $data->id;
        $OrderDate->type = 'Cancelled';
        $data->cancel_by = 2;
        $OrderDate->save();
        return response()->json(msgdata($request, success(), 'success', $data));

    }

    public function Store_Order(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'main_category_id' => 'required|exists:main_categories,id',
            'project_id' => 'required|exists:projects,id',
            'delivery_time_id' => 'required|exists:delivery_times,id',
            'delivery_date' => 'required|after:yesterday',
            'is_flexible_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        if (Cart::where('user_id', $request->user_id)->where('main_category_id', $request->main_category_id)->count() > 0) {
            $data = new Order();
            $data->user_id = $request->user_id;
            $data->supplier_id = null;
            $data->main_category_id = $request->main_category_id;
            $data->project_id = $request->project_id;
            $data->delivery_date = $request->delivery_date;
            $data->is_flexible_time = $request->is_flexible_time;
            $data->delivery_time_id = $request->delivery_time_id;
            $data->type = 'Pending';
            $data->total_price = 0;
            $data->request_count = 1;
            $data->request_time = Carbon::now();
            $data->save();
            $Products = Cart::where('user_id', $request->user_id)->where('main_category_id', $request->main_category_id)
                ->select('count', 'product_id')->get();
            foreach ($Products as $b) {
                $Product = Product::find($b->product_id);
                if (isset($Product)) {
                    $orderDetails = new OrderDetails();
                    $orderDetails->order_id = $data->id;
                    $orderDetails->product_id = $Product->id;
                    $orderDetails->user_id = $request->user_id;
                    $orderDetails->name_ar = $Product->name_ar;
                    $orderDetails->name_en = $Product->name_en;
                    $orderDetails->price = $Product->price;
                    $orderDetails->count = $b->count;
                    $orderDetails->save();
                    $totalPrice[] = $Product->price * $b->count;
                }
            }
            Order::where('id', $data->id)->update(['total_price' => array_sum($totalPrice)]);

            $orderDates = new OrderDate();
            $orderDates->type = 'Pending';
            $orderDates->order_id = $data->id;
            $orderDates->date = \Carbon\Carbon::now();
            $orderDates->save();


//       here filter the suppliers
            $main_category = MainCategory::whereId($request->main_category_id)->first();
            $distance = $main_category->max_distance;
            $supplier_count = $main_category->supplier_count;

            $Products = Cart::where('user_id', $request->user_id)
                ->where('main_category_id', $request->main_category_id)
                ->pluck('product_id')->toArray();
            $supplier_products = SupplierProduct::whereIn('product_id', $Products)->get();
            $Suppliers = Supplier::all();
            $data1 = [];

            $project = Project::whereid($request->project_id)->first();

            foreach ($Suppliers as $Supplier) {
                foreach ($Products as $Product) {
                    $supplier_products = SupplierProduct::where('supplier_id', $Supplier->id)
                        ->pluck('product_id')->ToArray();
                    if (in_array($Product, $supplier_products)) {
                        $flage[] = true;
                    } else {
                        $flage[] = false;
                    }


                    if (distance($Supplier->lat, $Supplier->lng, $project->lat, $project->lng) > $distance) {
                        $flage[] = false;
                    }


                }
                if (!in_array(false, $flage)) {
                    $data1[] = $Supplier->id;
                }
                $flage = null;

            }


            if (count($data1) == 0) {
                $inbox = new Inbox();
                $inbox->message = "لا يوجد مودرين لهذه المنتجات فى نطاق الفئه الرئيسيه للطلبية ذات الرقم " . $data->id;
                $inbox->receiver_id = Admin::first()->id;
                $inbox->receiver_type = "admin";
                $inbox->type = "notification";
                $inbox->sender_id = $request->user_id;
                $inbox->sender_type = "user";
                $inbox->is_order = 1;
                $inbox->order_id = $data->id;
                $inbox->save();

//                return response()->json(msgdata($request, error(), 'noSuppliers', (object)[]));

            }


            foreach ($data1 as $item) {

                SuppliersOrders::create([
                    'supplier_id' => $item,
                    'order_id' => $data->id,
                ]);

                $inbox = new Inbox();
                $inbox->message = " تم ارسال طلبية جديده برجاء الاطلاع عليها .. الطلبية ذات الرقم " . $data->id;
                $inbox->receiver_id = $item;
                $inbox->receiver_type = "supplier";
                $inbox->type = "notification";
                $inbox->sender_id = $request->user_id;
                $inbox->sender_type = "user";
                $inbox->is_order = 1;
                $inbox->order_id = $data->id;
                $inbox->save();

            }


            Cart::where('user_id', $request->user_id)->where('main_category_id', $request->main_category_id)->delete();
            $data->max_time_reorder = $main_category->max_time_reorder;


            return response()->json(msgdata($request, success(), 'success', $data));

        } else {
            return response()->json(msgdata($request, error(), 'emptycart', (object)[]));

        }
    }

    public function WalletPayment(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $order = Order::whereId($request->order_id)->first();
        if ($order->type == 'Accepted') {
            $Deposit = Wallet::where('type', 'deposit')->where('project_id', $order->project_id)->sum('price');
            $withdrawal = Wallet::where('type', 'withdrawal')->where('project_id', $order->project_id)->sum('price');
            $total = $Deposit - $withdrawal;
            if ($total > $order->total_price) {

                $wallet = new Wallet;
                $wallet->type = 'withdrawal';
                $wallet->description = 'تم خصم مبلغ' . $order->total_price . "قيمة دفع الطلبية رقم " . $order->id;
                $wallet->user_id = auth()->id();
                $wallet->order_id = $order->id;
                $wallet->price = $order->total_price;
                $wallet->project_id = $order->project_id;
                $wallet->save();

                $order->payment_status = 1;
                $order->payment_type = 'wallet';
                $order->payment_date = Carbon::now('Asia/Riyadh');
                $order->save();

                $inbox = new Inbox();
                $inbox->message = "تمت عملية الدفع للطلبية رقم (  " . $order->id . " ) برجاء التوجة للتسليم ";
                $inbox->receiver_id = $order->supplier_id;
                $inbox->receiver_type = "supplier";
                $inbox->type = "notification";
                $inbox->sender_id = $order->user_id;
                $inbox->sender_type = "user";
                $inbox->is_order = 1;
                $inbox->order_id = $order->id;
                $inbox->save();
                $OrderDate = new OrderDate;
                $OrderDate->order_id = $order->id;
                $OrderDate->type = 'Paid';
                $OrderDate->save();
                return response()->json(msgdata($request, success(), 'success', $order));
            } else {
                return response()->json(msgdata($request, error(), 'emptywallet', (object)[]));
            }
        } else {
            return response()->json(msgdata($request, error(), 'projectEmpty', (object)[]));
        }

    }

    public function ChangePaymentStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $order = Order::whereId($request->order_id)->first();
        $order->payment_status = 1;
        $order->save();

        $inbox = new Inbox();
        $inbox->message = "تمت عملية الدفع للطلبية رقم (  " . $order->id . " ) برجاء التوجة للتسليم ";
        $inbox->receiver_id = $order->supplier_id;
        $inbox->receiver_type = "supplier";
        $inbox->type = "notification";
        $inbox->sender_id = $order->user_id;
        $inbox->sender_type = "user";
        $inbox->is_order = 1;
        $inbox->order_id = $order->id;
        $inbox->save();

        return response()->json(msgdata($request, success(), 'success', $order));


    }

    public function ReOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }


        $data = Order::find($request->order_id);
        $main_category = MainCategory::whereId($data->main_category_id)->first();
        $distance = $main_category->max_distance;
        $supplier_count = $main_category->supplier_count;
        if ($data->request_count >= $main_category->max_request) {
            $data->type = "Cancelled";
            $data->cancel_by = 1;
            $data->save();
            $inbox = new Inbox();
            $inbox->message = "تم رفض الطلبيه رقم" . $data->id . "لعدم وجود موردين فى النطاق المحدد او لعدم استقبال الطلبية";
            $inbox->receiver_id = Admin::first()->id;
            $inbox->receiver_type = "admin";
            $inbox->type = "mail";
            $inbox->sender_id = $data->user_id;
            $inbox->sender_type = "user";
            $inbox->is_order = 1;
            $inbox->order_id = $data->id;
            $inbox->save();
            return response()->json(msgdata($request, error(), 'maxReorder', (object)[]));
        }


        $OrderDetails = OrderDetails::where('order_id', $data->id)->get();
        $totalPrice = [];
        $oldDetails = [];
        foreach ($OrderDetails as $details) {
            $product = Product::find($details->product_id);
            if ($product && $product->is_active == 1) {
                $orderDetails = new OrderDetails();
                $orderDetails->order_id = $data->id;
                $orderDetails->product_id = $product->id;
                $orderDetails->user_id = $details->user_id;
                $orderDetails->name_ar = $product->name_ar;
                $orderDetails->name_en = $product->name_en;
                $orderDetails->price = $product->price;
                $orderDetails->count = $details->count;
                $orderDetails->save();
                $totalPrice[] = $product->price * $details->count;
            }
            $oldDetails[] = $details->id;

        }
        OrderDetails::whereIn('id', $oldDetails)->delete();
        $OrderDetails2 = OrderDetails::where('order_id', $data->id)->get();

        Order::where('id', $data->id)->update(['total_price' => array_sum($totalPrice)]);

        if (count($OrderDetails) != count($OrderDetails2) || $data->total_price != array_sum($totalPrice)) {

            $data->is_changed = 0;
            $data->is_deleted = 0;
            $data->max_time_reorder = $main_category->max_time_reorder;
            if (count($OrderDetails) != count($OrderDetails2)) {
                $data->is_deleted = 1;
            }
            if ($data->total_price != array_sum($totalPrice)) {
                $data->is_changed = 1;
            }
            return response()->json(msgdata($request, success(), 'success', $data));
        }

        $data->request_count = $data->request_count + 1;
        $data->request_time = Carbon::now();
        $data->type = "Pending";
        $data->save();

//       here filter the suppliers

        $Products = OrderDetails::where('order_id', $data->id)
            ->pluck('product_id')->toArray();
        $Suppliers = Supplier::all();
        $data1 = [];
        $project = Project::whereid($data->project_id)->first();

        foreach ($Suppliers as $Supplier) {
            $flage = [];
            foreach ($Products as $Product) {
                $supplier_products = SupplierProduct::where('supplier_id', $Supplier->id)
                    ->pluck('product_id')->ToArray();
                if (in_array($Product, $supplier_products)) {
                    $flage[] = true;
                } else {
                    $flage[] = false;
                }

                if (isset($Supplier->lat) && distance($Supplier->lat, $Supplier->lng, $project->lat, $project->lng) > $distance) {
                    $flage[] = false;
                }


            }
            if (!in_array(false, $flage)) {
                $data1[] = $Supplier->id;
            }

            $flage = null;

        }


        if (count($data1) == 0) {
            $inbox = new Inbox();
            $inbox->message = "لا يوجد مودرين لهذه المنتجات فى نطاق الفئه الرئيسيه للطلبية ذات الرقم " . $data->id;
            $inbox->receiver_id = Admin::first()->id;
            $inbox->receiver_type = "admin";
            $inbox->type = "notification";
            $inbox->sender_id = $data->user_id;
            $inbox->sender_type = "user";
            $inbox->is_order = 1;
            $inbox->order_id = $data->id;
            $inbox->save();

            $data->is_changed = 0;
            $data->is_deleted = 0;
            $data->max_time_reorder = $main_category->max_time_reorder;
            if (count($OrderDetails) != count($OrderDetails2)) {
                $data->is_deleted = 1;
            }
            if ($data->total_price != array_sum($totalPrice)) {
                $data->is_changed = 1;
            }
            return response()->json(msgdata($request, error(), 'noSuppliers', $data));

        }

        $supplierOrders = SuppliersOrders::where('order_id', $request->order_id)->update(
            ['status' => 2]
        );

        foreach ($data1 as $item) {

            SuppliersOrders::create([
                'supplier_id' => $item,
                'order_id' => $data->id,
            ]);
        }
        $data->max_time_reorder = $main_category->max_time_reorder;
        $data->is_changed = 0;
        $data->is_deleted = 0;
        return response()->json(msgdata($request, success(), 'success', $data));


    }

    public function GenerateDeliveryCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = Order::find($request->order_id);
        $data->delivery_code = rand(999, 9999);
        $data->save();

        return response()->json(msgdata($request, success(), 'success', $data));
    }

    public function DeleteDeliveryCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = Order::find($request->order_id);
        $data->delivery_code = null;
        $data->save();

        return response()->json(msgdata($request, success(), 'success', $data));
    }

    public function OrderShare(Request $request, $id)
    {
        $order = Order::whereId($id)->first();
        if ($order) {
            $data['order'] = $order;
            $pdf = PDF::loadView('shareOrder', $data);
            $num = rand(100000, 999999) . '.pdf';
            $pdf->save('public/uploads/orders' . '/' . $num);
            $file = url('public/uploads/orders') . '/' . $num;


            return response()->json(msgdata($request, success(), 'success', $file));


        } else {
            return response()->json(msgdata($request, error(), 'nodata', ""));

        }
    }
}
