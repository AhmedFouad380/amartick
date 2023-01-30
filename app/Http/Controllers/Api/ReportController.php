<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;


class ReportController extends Controller
{
    public function ProjectsReport(Request $request)
    {
        $data = Project::where('manager_id', Auth::user()->id)->orwhere('employee_id', Auth::user()->id)->
        with('employee')->
        with('Manager')->
        withCount('CancelOrders')->
        withCount('CancelOrdersByClient')->
        withCount('CancelOrdersBySytem')->
        withCount('DeliveredOrders')->
        paginate(10);
        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));
        } else {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));

        }
    }

    public function PaymentReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'exists:projects,id',
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $query = Order::where('payment_status', 1)->where('user_id', Auth::user()->id);
        if (isset($request->project_id)) {
            $query->where('project_id', $request->project_id);
        }
        if (isset($request->from)) {
            $query->where('payment_date', '>=', $request->from);
        }
        if (isset($request->to)) {
            $query->where('payment_date', '<=', $request->to);
        }
        $query->with('project');

        $data = $query->paginate(10);
        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));
        } else {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));

        }
    }

    public function ProductReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'exists:products,id',
            'from' => 'date',
            'to' => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }


        $query = OrderDetails::where('user_id', Auth::user()->id);
        if (isset($request->from)) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if (isset($request->to)) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if (isset($request->product_id)) {

            //todo
//            where order project_id == $request->product_id
            $query->whereHas('Order',function ($q) use ($request) {
               $q->where('project_id',$request->product_id);
            });
//            $query->where('product_id', $request->product_id);
        }
        if (isset($request->search)) {
            $query->where('name_ar', 'like', '%' . $request->search . '%');
        }
        $data = $query->paginate(10);
        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));
        } else {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));

        }
    }


    public function ProjectDetailsReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'exists:projects,id',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $categories = MainCategory::with('OrdersDetails')->with(
            ['OrdersDetails' => function ($query) use ($request) {
                $query->where('orders.project_id', $request->project_id);
            }]
        )
            ->withSum(
                ['OrdersDelivered' => function ($query) use ($request) {
                    $query->where('project_id', $request->project_id);
                }],
                'total_price'
            )
//            ->withSum('OrdersDelivered', 'total_price')
            ->get();


        $total_price = Order::where('project_id', $request->project_id)
            ->where('type','Delivered')
            ->sum('total_price');
        $data['categoryItem'] = $categories;
        $data['total_price'] = $total_price;
        return response()->json(msgdata($request, success(), 'success', $data));

    }

    public function ReportShare(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'project_id' => 'exists:projects,id',

        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $project = Project::whereId($request->project_id)->first();

        $categories = MainCategory::with('OrdersDetails')->with(
            ['OrdersDetails' => function ($query) use ($request) {
                $query->where('orders.project_id', $request->project_id);
            }]
        )->withSum(
                ['OrdersDelivered' => function ($query) use ($request) {
                    $query->where('project_id', $request->project_id);
                }],
                'total_price'
            )
             ->get();



        $total_price = Order::where('project_id', $request->project_id)
            ->where('type','Delivered')
            ->sum('total_price');

        $data['categoryItem'] = $categories;
        $data['total_price'] = $total_price;
        $data['project'] = $project;

        $pdf = PDF::loadView('shareReport', $data);
        $num = rand(100000, 999999) . time() . '.pdf';
        $pdf->save('public/uploads/orders' . '/' . $num);
        $file = url('public/uploads/orders') . '/' . $num;

        return response()->json(msgdata($request, success(), 'success', $file));


    }
}
