<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Inbox;
use App\Models\InboxFile;
use App\Models\Project;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{

    public function getWallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'exists:projects,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        $data = Wallet::OrderBy('id', 'desc')->where('project_id', $request->project_id)->paginate(10);
        $Deposit = Wallet::where('type', 'deposit')->where('project_id', $request->project_id)->sum('price');
        $withdrawal = Wallet::where('type', 'withdrawal')->where('project_id', $request->project_id)->sum('price');
        $total = $Deposit - $withdrawal;
        $data->total_wallet = $total;

        $data2['data'] = $data;
        $data2['total_wallet'] = $total;

        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data2));

        } else {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));


        }
    }

    public function RequestAmount(Request $request)
    {
        $rules =
            [
                'amount' => "required|numeric",
                'project_id' => "required|exists:projects,id",
            ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }

        $admin = Admin::first();
        $project = Project::whereId($request->project_id)->first();
        if ($project->totalWallet < $request->amount) {
            return response()->json(['status' => 401, 'msg' => "عفوا المبلغ المطلوب اكبر من المتاح فى المحفظة!", 'data' => (object)[]]);
        }
        $message = " طلب استرداد مبلغ من المحفظه وقدرة " . " " . $request->amount . " ريال سعودى من المشروع " . $project->name;
        $inbox = new Inbox();
        $inbox->message = $message;
        $inbox->receiver_id = $admin->id;
        $inbox->sender_id = Auth::user()->id;
        $inbox->sender_type = "user";
        $inbox->receiver_type = "admin";

        $inbox->save();
        try {
            $inbox->save();

        } catch (\Exception $e) {

            return response()->json(msgdata($request, error(), 'error', $e));
        }


        return response()->json(msgdata($request, success(), 'success', $inbox));
    }


    public function TransferAmount(Request $request)
    {
        $rules =
            [
                'amount' => "required|numeric",
                'from_project_id' => "required|exists:projects,id",
                'to_project_id' => "required|exists:projects,id",
            ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }


        $from_project = Project::whereId($request->from_project_id)->first();
        $to_project = Project::whereId($request->from_project_id)->first();
        if ($from_project->totalWallet < $request->amount) {
            return response()->json(['status' => 401, 'msg' => "عفوا المبلغ المطلوب اكبر من المتاح فى المحفظة!", 'data' => (object)[]]);
        }


        $wallet = new Wallet;
        $wallet->type = "withdrawal";
        $wallet->price = $request->amount;
        $wallet->description = "تحويل الى مشروع " . " " . $to_project->name;
        $wallet->project_id = $request->from_project_id;
        $wallet->save();

        $wallet = new Wallet;
        $wallet->type = "deposit";
        $wallet->price = $request->amount;
        $wallet->description = "تحويل من مشروع " . " " . $from_project->name;
        $wallet->project_id = $request->to_project_id;
        $wallet->save();

        return response()->json(msgdata($request, success(), 'success', (object)[]));
    }
}
