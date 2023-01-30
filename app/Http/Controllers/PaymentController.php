<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\OrderDate;
use App\Models\Project;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
class   PaymentController extends Controller
{
    public function  PaymentPage(Request $request){

        $this->validate(request(),[
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        $user_id= $request->user_id;
        $Order = Order::find($request->order_id);
        $url = 'http://amar-tick.com/PaymentStatus?order_id='.$Order->id;
        $description ='Order ID ' . $Order->id;
        $total = $Order->total_price;
        return view('payment',compact('Order','user_id','url','description','total'));
    }

    public function PaymentSTC(Request $request){
        $this->validate(request(),[
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        $user_id= $request->user_id;
        $Order = Order::find($request->order_id);
        $url = 'http://amar-tick.com/PaymentStatus?order_id='.$Order->id;
        $description ='Order ID ' . $Order->id;
        $total = $Order->total_price;
        return view('PaymentSTC',compact('Order','user_id','url','description','total'));

    }

    public function PaymentApplyPay(Request $request){
        $this->validate(request(),[
            'user_id' => 'required|exists:users,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        $user_id= $request->user_id;
        $Order = Order::find($request->order_id);
        $url = 'http://amar-tick.com/PaymentStatus?order_id='.$Order->id;
        $description ='Order ID ' . $Order->id;
        $total = $Order->total_price;
        return view('PaymentApplyPay',compact('Order','user_id','url','description','total'));

    }
    public function  Wallet_Charging(Request $request){

        $this->validate(request(),[
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'amount'=>'required'
        ]);

        $user_id= $request->user_id;
        $Order = Project::find($request->project_id);
        $description ='شحن المحفظة بمبلغ  ' . $request->amount . 'للمشروع '. $Order->name;
        $url = 'http://amar-tick.com/WalletStatus?project_id='.$request->project_id.'&description='.$description.'&total='.$request->amount.'&user_id='.$user_id;
        $total = $request->amount;
        return view('payment',compact('Order','user_id','url','description','total'));
    }
    public function  Wallet_ChargingSTC(Request $request){

        $this->validate(request(),[
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'amount'=>'required'
        ]);

        $user_id= $request->user_id;
        $Order = Project::find($request->project_id);
        $description ='شحن المحفظة بمبلغ  ' . $request->amount . 'للمشروع '. $Order->name;
        $url = 'http://amar-tick.com/WalletStatus?project_id='.$request->project_id.'&description='.$description.'&total='.$request->amount.'&user_id='.$user_id;
        $total = $request->amount;
        return view('PaymentSTC',compact('Order','user_id','url','description','total'));
    }

    public function ApplePayChargingWellet(Request $request){
        $Wallet = New Wallet();
        $Wallet->type='deposit';
        $Wallet->user_id=$request->user_id;
        $Wallet->project_id=$request->project_id;
        $Wallet->price=$request->amount;
        $Wallet->description=$request->amount.'تم شحن مبلغ ';
        $Wallet->save();
        $Status = 1;
        $Message = 'تمت عملية الدفع بنجاح ';


        return response()->json(msgdata($request, success(), 'success', $Wallet));
    }
    public function WalletStatus(Request $request){

        if($request->status == 'paid') {

            $Wallet = New Wallet();
            $Wallet->type='deposit';
            $Wallet->user_id=$request->user_id;
            $Wallet->project_id=$request->project_id;
            $Wallet->price=$request->amount / 100;
            $Wallet->description=$request->description;
            $Wallet->save();
            $Status = 1;
            $Message = 'تمت عملية الدفع بنجاح ';

            return view('PaymentStatus',compact('Message','Status'));
        }else{
            $Status = 0;
            $Message = $request->message;
            return view('PaymentStatus',compact('Message','Status'));
        }
    }

    public function PaymentStatus(Request $request){

        if($request->status == 'paid') {
            $Order = Order::findOrFail($request->order_id);
                $Order->payment_status=1;
                $Order->payment_type='visa';
                $Order->payment_date=Carbon::now('Asia/Riyadh');
                $Order->save();
                $Status = 1;
                $Message = 'تمت عملية الدفع بنجاح ';
                $inbox = new Inbox();
                $inbox->message = " تم دفع حساب  برجاء التوجه لتسليمه  طلب رقم  " . $Order->id;
                $inbox->receiver_id = $Order->supplier_id;
                $inbox->receiver_type = "supplier";
                $inbox->type = "notification";
                $inbox->sender_id = $Order->user_id;
                $inbox->sender_type = "user";
                $inbox->save();
                $OrderDate = new OrderDate;
                $OrderDate->order_id=$Order->id;
                $OrderDate->type='Paid';
                $OrderDate->save();
                // OrderDate::create([
                //     'order_id' => $Order->id,
                //     'type' => "Paid",
                // ]);

          
            return view('PaymentStatus',compact('Message','Status'));
        }else{
            $Status = 0;
            $Message = $request->message;
            return view('PaymentStatus',compact('Message','Status'));
        }
    }
}
