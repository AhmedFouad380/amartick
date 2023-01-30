<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BranchAccount;
use App\Models\Deligate;
use App\Models\Inbox;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\OrderDate;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\SuppliersOrders;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
//        if (Auth::guard('admins')->check()) {
//            $Users = Order::OrderBy('id', 'desc')->paginate(10);
//        } else {
//            if (Auth::guard('suppliers')->user()->type == 'Manager') {
//                $supplier = Supplier::whereId(Auth::guard('suppliers')->user()->id)->first();
//                $EmpSupplier = Supplier::where('parent_id', $supplier->id)->pluck('id')->toArray();
//                $Users = Order::whereIn('supplier_id', $EmpSupplier)->OrderBy('id', 'desc')->paginate(10);
//            } else {
//
//                $Users = Order::where('supplier_id', supplier_parent())->OrderBy('id', 'desc')->paginate(10);
//            }
//        }

        return view('Admin.Orders.index');
    }


    public function datatable(Request $request)
    {

        if (Auth::guard('admins')->check()) {
            $data = Order::orderBy('id', 'desc');
        } else {
            if (Auth::guard('suppliers')->user()->type == 'Manager') {
                $supplier = Supplier::whereId(Auth::guard('suppliers')->user()->id)->first();
                $EmpSupplier = Supplier::where('parent_id', $supplier->id)->pluck('id')->toArray();
                $data = Order::whereIn('supplier_id', $EmpSupplier)->OrderBy('id', 'desc');
            } else {
                $data = Order::where('supplier_id', supplier_parent())->OrderBy('id', 'desc');
            }
        }



        return DataTables::of($data)
            ->addColumn('checkbox', function ($row) {
                $checkbox = '';
                $checkbox .= '<div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="' . $row->id . '" />
                                </div>';
                return $checkbox;
            })
            ->editColumn('supplier_id', function ($row) {
             return   $row->Supplier->name;
            })

            ->editColumn('user_id', function ($row) {
              return   $row->User->name;
            })
            ->editColumn('main_category_id', function ($row) {
               return  $row->MainCategory->name;
            })
            ->editColumn('type',function ($row){
                if($row->type == 'ReOrder'){
                    $action = ` <span style="width: 133px;"><span
                    class="label font-weight-bold label-lg  label-light-danger label-inline">`.trans('lang.'.$row->type).`</span></span>`;
                }else{
                    $action  =    trans('lang.'.$row->type);
                    if($row->type == "Accepted"){
                        if($row->payment_status == 1){
                            $action .= `   <span style="width: 133px;"><span
                                                                                            class="label font-weight-bold label-lg  label-light-primary label-inline">
                                                                                             `. trans('lang.paid').`   </span></span>`;
                        }else{
                            $action .= `                        <span style="width: 133px;"><span
                                                                                            class="label font-weight-bold label-lg  label-light-danger label-inline">
                                                                                            `.  trans('lang.not_paid') . `  </span></span>`;
                        }
                    }
                }

                if($row->created_at <Carbon::now()->subDay() && $row->type == "pending"){
                                        $action .= '    <label style="color: #ff0000">
                                                ' . Carbon\Carbon::parse($row->created_at)->diffForHumans(Carbon::now()) .
                                            '</label>';
               }

                return $action;
            })
            ->addColumn('supplier_buttons',function ($row){
                if(Auth::guard('suppliers')->check()){
                    if(Auth::guard('suppliers')->user()->type != 'Manager'){
                        if($row->payment_status ==1){
                         return  $actions ='    <a data-id="'.$row->User->id.'"
                                                       data-project-id="'.$row->project_id.'"
                                                       data-original-title="'.__('lang.Customer_data').'"
                                                       title="'.__('lang.Customer_data').'"
                                                       class="btn btn-secondary edit-Adverts">
                                                        <i class="fa fa-user"></i>'.trans('lang.Customer_data').'
                                                    </a>

                                                    <a data-id="'.$row->id.'"
                                                       data-original-title="'. __('lang.Deligate_data') .'"
                                                       title="'.__('lang.Deligate_data') .'"
                                                       class="btn btn-primary add-deligate">
                                                        <i class="fa fa-shipping-fast"></i>'. trans('lang.Deligate_data') .'
                                                    </a>';
                        }
                    }
                }


            })
            ->addColumn('supplier_buttons2',function ($row){
                if($row->payment_status ==1 && $row->type != "Delivered"){
                             return    $action = '<button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#exampleModal" data-whatever="'.$row->id.'">
                                                        <i class="fa fa-truck icon-nm"></i>
                                                    </button>';
               }
            })

            ->editColumn('is_active', function ($row) {
                $is_active = '<div class="badge badge-light-success fw-bolder">مفعل</div>';
                $not_active = '<div class="badge badge-light-danger fw-bolder">غير مفعل</div>';
                if ($row->is_active == 'active') {
                    return $is_active;
                } else {
                    return $not_active;
                }
            })
            ->addColumn('actions', function ($row) {
                $actions = '<a class="btn btn-success btn-sm btn-clean btn-icon btn-icon-md DeliveryOrder"
                                           data-id="'.$row->id.'">
                                            <i class="fa fa-eye icon-nm"></i>
                                        </a>';
                return $actions;

            })
            ->rawColumns(['actions', 'checkbox', 'is_active'])
            ->make();

    }


    public function search(Request $request)
    {
        if (Auth::guard('admins')->check()) {
            $query = Order::OrderBy('id', 'desc');
        } else {
            $query = Order::where('supplier_id', supplier_parent())->OrderBy('id', 'desc');
        }
        if ($request->supplier_id != '0') {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->main_category_id != '0') {
            $query->where('main_category_id', $request->main_category_id);
        }
        if ($request->type != '0') {
            $query->where('type', $request->type);
        }
        if (isset($request->from)) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if (isset($request->to)) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        $Users = $query->paginate(10);
        return view('Admin.Orders.index', compact('Users'));

    }

    public function pending_orders($id = null)
        {
            if($id){
                $Users = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
                    ->whereHas('supplier', function ($q) {
                        $q->where('supplier_id', supplier_parent());
                    })->whereHas('order', function ($query  ) use($id) {
                        $query->where('id',$id)->where('type','!=', 'Delivered')->Where('type','!=', 'Delivered')->Where('type','!=', 'Cancelled');
                    })
                    ->get();
            }else{
                $Users = SuppliersOrders::where('status', 0)->OrderBy('id', 'desc')
                    ->whereHas('supplier', function ($q) {
                        $q->where('supplier_id', supplier_parent());
                    })->whereHas('order', function ($query) {
                        $query->where('type', 'Pending')->orWhere('type', 'ReOrder');
                    })
                    ->get();
            }


            return view('Admin.Orders.pending', compact('Users'));
        }

    public function Accept(Request $request)
    {


        $order_suppliers = SuppliersOrders::where('id', $request->id)->first();

        if ($order_suppliers->order->type == "Pending" ||
            $order_suppliers->order->type == "ReOrder") {
            $order = Order::where('id', $order_suppliers->order->id)->first();
            $order->type = "Accepted";
            $order->supplier_id = supplier_parent();

            $order->save();
            $order_suppliers->status = 1; //accepted
            $order_suppliers->save();

            OrderDate::create([
                'order_id' => $order->id,
                'type' => "Accepted",
            ]);


            $inbox = new Inbox();
            $date = Carbon::parse($request->date)->format('Y-m-d');
            if ($order->delivery_date != $date) {
                $order->delivery_date = $date;
                $order->save();
                $inbox->message = "تم قبول الطلبية ذات الرقم " . $order->id . "وتم تغيير موعد التسلم ليصبح بتاريخ " . $date . " وفى انتظار اتمام عملية الدفع";
            } else {
                $inbox->message = "تم قبول الطلبية ذات الرقم " . $order->id . " وفى انتظار اتمام عملية الدفع";
            }


            $inbox->receiver_id = $order->user_id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = supplier_parent();
            $inbox->sender_type = "supplier";
            $inbox->is_order = 1;
            $inbox->order_id = $order->id;
            $inbox->save();

            return response()->json(['message' => 'Success']);
        } else {
            return response()->json(['message' => 'Failed']);
        }


    }

    public function Reject(Request $request)
    {
        $order_supplier = SuppliersOrders::where('id', $request->id)->first();

        $order_supplier->status = 2; //rejected
        $order_supplier->save();

        $order_suppliers = SuppliersOrders::where('order_id', $order_supplier->order_id)->where("status", '!=', 2)
            ->count();
        if ($order_suppliers == 0) {
            $inbox = new Inbox();
            $inbox->message = "تم رفض الطلبية ذات الرقم " . $order_supplier->order_id . "برجاء اعاده المحاولة ثانيآ";
            $inbox->receiver_id = $order_supplier->order->User->id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = supplier_parent();
            $inbox->sender_type = "supplier";
            $inbox->is_order = 1;
            $inbox->order_id = $order_supplier->order_id;
            $inbox->save();
        }

        return response()->json(['message' => 'Success']);

    }

    public function OrderDetails(Request $request)
    {
        $Users = Order::findOrFail($request->id);
        return view('Admin.Orders.details', compact('Users'));
    }

    public function singleOrder($id)
    {
        $Users = Order::whereId($id)->get();
        return view('Admin.Orders.index', compact('Users'));
    }

    public function singleOrder_ajax($id)
    {
        $Users = Order::whereId($id)->first();
        return response()->json(['order' => $Users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function OrderNotification()
    {
        $orders = Order::where('type', 'Accepted')->where('payment_status', 0)->where('created_at', '<=', Carbon::now()->addDays(10))->get();
        foreach ($orders as $order) {
            $inbox = new Inbox();
            $inbox->message = "برجاء العلم انه تم قبول الطلبية ولم يتم الدفع برجاء الدفع قبل رفض الطلبيه من النظام";
            $inbox->receiver_id = $order->user_id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = Admin::first()->id;
            $inbox->sender_type = "Admin";
            $inbox->is_order = 1;
            $inbox->order_id = $order->id;
            $inbox->save();
        }
    }


    public function OrderCancelled()
    {
        $orders = Order::where('type', 'Accepted')->where('payment_status', 0)->where('created_at', '<=', Carbon::now()->addHour(Setting::find(1)->max_pay_time))->get();
        foreach ($orders as $order) {

            $order->type = "ReOrder";
            $order->cancel_by = 1;

            OrderDate::create([
                'order_id' => $order->id,
                'type' => "Pending",
            ]);

            $order->save();
            $inbox = new Inbox();
            $inbox->message = "برجاء العلم انه تم اللغاء الطلبية و تحويلها الى طلبات اعادة الارسال للتأخير فى الدفع";
            $inbox->receiver_id = $order->user_id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = Admin::first()->id;
            $inbox->sender_type = "Admin";
            $inbox->is_order = 1;
            $inbox->order_id = $order->id;
            $inbox->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function CronReOrder()
    {
        $data = Order::where('type', 'Pending')->get();

        foreach ($data as $Order) {
            $main_category = MainCategory::find($Order->main_category_id);

            $date = Carbon::parse($Order->updated_at)->addMinutes($main_category->max_time_reorder)->toDateTimeString();

            if (date('Y-m-d H:i:s') > $date) {
                $Order->type = 'ReOrder';
                $Order->save();
            }
        }
    }


    public function AddDeligate(Request $request)
    {
//        dd($request->all());
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'deligate_id' => 'required|exists:deligates,id',
//            'deligate_name' => 'required|string',
//            'deligate_phone' => 'required|numeric|regex:/(966)[0-9]{8}/',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $order = Order::where('id', $request->order_id)->first();
        $deligate = Deligate::find($request->deligate_id);
        $order->deligate_name = $deligate->name;
        $order->deligate_phone = $deligate->phone;
        $order->has_deligate = 1;
//        $order->code = rand(1111, 9999);
        $message = "  تم تعيينك لشحن الطلبية رقم  " . $order->id . ' برجاء التوجه لتسليمها';
        $number = $deligate->phone;
        sms($message, $number);
        $order->save();

        OrderDate::create([
            'order_id' => $order->id,
            'type' => "Deligated",
        ]);


        return response()->json(['success' => "success"]);

    }

    public function CheckDeligate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'code' => 'required|exists:orders,code',

        ]);

        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $order = Order::where('id', $request->order_id)->first();
        if ($request->code == $order->code) {
            $order->has_deligate = 1;
            $order->code = null;
            $order->save();
            return response()->json(['success' => "success"]);
        } else {
            return response()->json(['errors' => ['رمز التحقق غير صحيح']]);
        }
    }

    public function DeliveryOrder(Request $request)
    {

        $this->validate(request(), [
            'order_id' => 'required|exists:orders,id',
            'delivery_code' => 'required',
        ]);

        $order = Order::find($request->order_id);
        if ($request->delivery_code == $order->delivery_code) {
            $order->type = 'Delivered';
            $order->save();

            $brunchAccount = new BranchAccount;
            $brunchAccount->price=$order->total_price;
            $brunchAccount->type='deposit';
            $brunchAccount->description=' مستحاقات طلبية رقم ' .$order->id;
            $brunchAccount->supplier_id=$order->supplier_id;
            $brunchAccount->order_id = $order->id;
            $brunchAccount->save();

            $inbox = new Inbox();
            $d = ' تم تسليم الطلبية رقم ';
            $b = ' بنجاح ';
            $message = $d . $order->id . $b;
            $inbox->message = $message;
            $inbox->receiver_id = $order->user_id;
            $inbox->receiver_type = "user";
            $inbox->type = "notification";
            $inbox->sender_id = supplier_parent();
            $inbox->sender_type = "supplier";
            $inbox->is_order = 1;
            $inbox->order_id = $order->id;
            $inbox->save();

            OrderDate::create([
                'order_id' => $order->id,
                'type' => "Delivered",
            ]);


            return redirect('/orders')->with('message', 'Success');
        } else {
            return back()->with('message', 'FailedCode1');
        }
    }
}
