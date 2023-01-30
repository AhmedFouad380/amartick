<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\BranchAccount;
use App\Models\Deligate;
use App\Models\DeliveryTime;
use App\Models\Inbox;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\Supplier;
use App\Models\SuppliersOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'supplier_id' => 'required|exists:suppliers,id',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        // Start Change Order Type
        $data = Order::where('type', 'Pending')->get();
        foreach ($data as $Order) {
            $main_category = MainCategory::find($Order->main_category_id);

            $date = Carbon::parse($Order->updated_at)->addMinutes($main_category->max_time_reorder)->toDateTimeString();
            if (date('Y-m-d H:i:s') > $date) {
                $Order->type = 'ReOrder';
                $Order->save();
            }
        }
        // End Change Order Type

        //            check if manager or employee
        $supplier = Supplier::whereId(supplier_parent_api())->first();
        if ($supplier->type == "Manager") {
            $EmpSupplier = Supplier::where('parent_id', supplier_parent_api())->pluck('id')->toArray();
            $query = Order::whereIn('supplier_id', $EmpSupplier)->with('Supplier');

        } else {

            $query = Order::where('supplier_id', supplier_parent_api())->with('Supplier');


        }


//            end check

        if ($request->type == "Pending") {
            if ($supplier->type == "Manager") {
                $EmpSupplier = Supplier::where('parent_id', supplier_parent_api())->pluck('id')->toArray();
                $suporder = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
                    ->whereHas('supplier', function ($q) use ($EmpSupplier) {
                        $q->wherein('supplier_id', $EmpSupplier);
                    })
                    ->pluck('order_id')->toArray();

                $query = Order::whereIn('id', $suporder)->where(function($q){
                    $q->where('type', 'Pending')->orwhere('type', 'ReOrder');
                });

            } else {

                $suporder = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
                    ->whereHas('supplier', function ($q) {
                        $q->where('supplier_id', supplier_parent_api());
                    })
                    ->pluck('order_id')->toArray();
                    
                $query = Order::whereIn('id', $suporder)->where(function($q){
                    $q->where('type', 'Pending')->orwhere('type', 'ReOrder');
                });
            }


        } elseif ($request->type == "paid") {
            $query->where('type', "Accepted")->where('payment_status', 1);
        } elseif ($request->type == "not_paid") {
            $query->where('type', "Accepted")->where('payment_status', 0);
        } else {
            $query->where('type', $request->type);
        }
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
            $query->whereIn('main_category_id', $request->main_category_id);
        }
        if (isset($request->project_id)) {
            $query->where('project_id', $request->project_id);
        }
        if($request->type == 'Delivered'){
            $query->OrderBy('delivery_date', 'desc');
        }else{
            $query->OrderBy('id', 'desc');
        }
        $data = $query->with('Project')->with('deliveryTime')->with('MainCategory')->with('OrderDetails')->with('Supplier')->paginate(10);


        return response()->json(msgdata($request, success(), 'success', $data));

    }
    public function OrdersCounts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required|exists:suppliers,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $supplier = Supplier::whereId($request->supplier_id)->first();
        if ($supplier->type == "Manager") {
            $EmpSupplier = Supplier::where('parent_id', $request->supplier_id)->pluck('id')->toArray();


            $suporder = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
                ->whereHas('supplier', function ($q) use ($EmpSupplier) {
                    $q->wherein('supplier_id', $EmpSupplier);
                })
                ->pluck('order_id')->toArray();

            $new = Order::whereIn('id', $suporder)->where('type', 'Pending')->orwhere('type', 'ReOrder')->count();

            $delivered = Order::whereIn('supplier_id', $EmpSupplier)->where('type', 'Delivered')->count();
            $cancelled = Order::whereIn('supplier_id', $EmpSupplier)->where('type', 'Cancelled')->count();
            $accepted_payed = Order::whereIn('supplier_id', $EmpSupplier)->where('type', 'Accepted')->where('payment_status', 1)->count();
            $cancelled_notpayed = Order::whereIn('supplier_id', $EmpSupplier)->where('type', 'Accepted')->where('payment_status', 0)->count();

        } else {

            $suporder = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
                ->whereHas('supplier', function ($q) {
                    $q->where('supplier_id', supplier_parent_api());
                })
                ->pluck('order_id')->toArray();

            $new = Order::whereIn('id', $suporder)->where('type', 'Pending')->orwhere('type', 'ReOrder')->count();

            $delivered = Order::where('supplier_id', $request->supplier_id)->where('type', 'Delivered')->count();
            $cancelled = Order::where('supplier_id', $request->supplier_id)->where('type', 'Cancelled')->count();
            $accepted_payed = Order::where('supplier_id', $request->supplier_id)->where('type', 'Accepted')->where('payment_status', 1)->count();
            $cancelled_notpayed = Order::where('supplier_id', $request->supplier_id)->where('type', 'Accepted')->where('payment_status', 0)->count();

        }

        $data['new'] = $new;
        $data['delivered'] = $delivered;
        $data['cancelled'] = $cancelled;
        $data['accepted_payed'] = $accepted_payed;
        $data['accepted_notpayed'] = $cancelled_notpayed;
        $data['inbox_count'] = Inbox::where('receiver_type', 'supplier')->where('receiver_id', $request->supplier_id)->where('is_read', 0)->count();;

        return response()->json(msgdata($request, success(), 'success', $data));

    }
    public function DeliveryOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'delivery_code' => 'required',

        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }


        $order = Order::find($request->order_id);
        if ($request->delivery_code == $order->delivery_code) {
            $order->type = 'Delivered';
            $order->save();

            OrderDate::create([
                'order_id' => $order->id,
                'type' => "Delivered",
            ]);

            $brunchAccount = new BranchAccount;
            $brunchAccount->price = $order->total_price;
            $brunchAccount->type = 'deposit';
            $brunchAccount->description = ' مستحاقات طلبية رقم ' . $order->id;
            $brunchAccount->supplier_id = $order->supplier_id;
            $brunchAccount->order_id = $order->id;
            $brunchAccount->save();

            $inbox = new Inbox();
            $message = " تم تسليم الطلبية رقم ".$order->id . " بنجاح ";
            $inbox->message = $message;
            $inbox->receiver_id = $order->user_id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = supplier_parent_api();
            $inbox->sender_type = "supplier";
            $inbox->is_order = 1;
            $inbox->order_id = $order->id;
            $inbox->save();
            return response()->json(msgdata($request, success(), 'success', $order));
        } else {
            return response()->json(msgdata($request, error(), 'invalid_code', (object)[]));
        }
    }
    public function AddDeligate(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'deligate_id' => 'required|exists:deligates,id',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        $deligate = Deligate::find($request->deligate_id);
        $order = Order::where('id', $request->order_id)->first();
        $order->deligate_name = $deligate->name;
        $order->deligate_phone = $deligate->phone;
        $order->has_deligate = 1;
//        $order->code = rand(1111, 9999);
//        $message = "رمز التحقق الخاص بالمندوب هو :" . $order->code;
//        $number = $request->deligate_phone;
//        sms($message, $number);
        $order->save();

        OrderDate::create([
            'order_id' => $order->id,
            'type' => "Deligated",
        ]);

        $inbox = new Inbox();
        $message = "تم تعيين مندوب للطلبية رقم " . $order->id . " بنجاح ";
        $inbox->message = $message;
        $inbox->receiver_id = $order->user_id;
        $inbox->receiver_type = "user";
        $inbox->type = "notification";
        $inbox->sender_id = supplier_parent_api();
        $inbox->sender_type = "supplier";
        $inbox->is_order = 1;
        $inbox->order_id = $order->id;
        $inbox->save();

        return response()->json(msgdata($request, success(), 'success', $order));

    }
    public function CheckDeligate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'code' => 'required|exists:orders,code',

        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $order = Order::where('id', $request->order_id)->first();
        if ($request->code == $order->code) {
            $order->has_deligate = 1;
            $order->code = null;
            $order->save();
            return response()->json(msgdata($request, success(), 'success', $order));
        } else {
            return response()->json(msgdata($request, error(), 'invalid_code', $order));
        }
    }
    public function get_deligates($id)
    {

        $data = Deligate::where('supplier_id', $id)->get();

        return response()->json(msgdata($id, success(), 'success', $data));

    }
    public function pending_orders()
    {
        $Users = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
            ->whereHas('supplier', function ($q) {
                $q->where('supplier_id', supplier_parent_api());
            })->with('order', function ($query) {
                $query->where('type', 'Pending')->orWhere('type', 'ReOrder')->with('MainCategory')->with('Project')->with('deliveryTime')->with('MainCategory')->with('OrderDetails');
            })
            ->get();

        return response()->json(msgdata([], success(), 'success', $Users));
    }
    public function Accept(Request $request)
    {
        $order_suppliers = SuppliersOrders::where('order_id', $request->id)->where('supplier_id', supplier_parent_api())->first();
        if ($order_suppliers) {
            if ($order_suppliers->order->type == "Pending" ||
                $order_suppliers->order->type == "ReOrder") {
                $order = Order::where('id', $order_suppliers->order->id)->first();
                $order->type = "Accepted";
                $order->supplier_id = supplier_parent_api();
                $order->delivery_time_id = $request->delivery_time_id;
                $order->save();
                $order_suppliers->status = 1; //accepted
                $order_suppliers->save();

                OrderDate::create([
                    'order_id' => $order->id,
                    'type' => "Accepted",
                ]);
                $dlivery_time = DeliveryTime::find($request->delivery_time_id)->title;

                $inbox = new Inbox();
                $date = Carbon::parse($request->date)->format('Y-m-d');
                if ($order->delivery_date != $date) {
                    $order->delivery_date = $date;
                    $order->save();
                    $inbox->message = " تم قبول الطلبية ذات الرقم " . $order->id . " وتم تغيير موعد التسلم ليصبح بتاريخ " . $date
                        ." وفي وقت توصيل متوقع " .$dlivery_time
                        . " وفى انتظار اتمام عملية الدفع ";

                } else {
                    $inbox->message = "تم قبول الطلبية ذات الرقم " . $order->id . " وفى انتظار اتمام عملية الدفع ";
                }


                $inbox->receiver_id = $order->user_id;
                $inbox->receiver_type = "user";
                $inbox->type = "notification";
                $inbox->sender_id = supplier_parent_api();
                $inbox->sender_type = "supplier";
                $inbox->is_order = 1;
                $inbox->order_id = $order->id;
                $inbox->save();

                return response()->json(msgdata([], success(), 'success', $order_suppliers));
            } else {
                return response()->json(msgdata([], error(), 'error', $order_suppliers));
            }
        } else {
            return response()->json(msgdata([], error(), 'error', (object)[]));
        }


    }
    public function Reject(Request $request)
    {
        $order_supplier = SuppliersOrders::where('order_id', $request->id)->where('supplier_id', supplier_parent_api())->first();
        if ($order_supplier) {
            $order_supplier->status = 2; //rejected
            $order_supplier->save();

            $order_suppliers = SuppliersOrders::where('order_id', $order_supplier->order_id)->where("status", '!=', 2)
                ->count();
            if ($order_suppliers == 0) {
                $inbox = new Inbox();
                $inbox->message = " تم رفض الطلبية ذات الرقم  " . $order_supplier->order_id . " برجاء اعاده المحاولة ثانيآ ";
                $inbox->receiver_id = $order_supplier->order->User->id;
                $inbox->receiver_type = "user";
                $inbox->type = "notification";
                $inbox->sender_id = supplier_parent_api();
                $inbox->sender_type = "supplier";
                $inbox->is_order = 1;
                $inbox->order_id = $order_supplier->order_id;
                $inbox->save();
            }

            return response()->json(msgdata([], success(), 'success', $order_supplier));
        } else {
            return response()->json(msgdata([], error(), 'error', (object)[]));
        }

    }
}
