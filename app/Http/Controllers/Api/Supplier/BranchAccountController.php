<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\AccountRequest;
use App\Models\Admin;
use App\Models\BranchAccount;
use App\Models\Inbox;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BranchAccountController extends Controller
{
    public function RequestAccount(Request $request)
    {
        $rules =
            [
                'supplier_id' => 'required|exists:suppliers,id',
                'price' => 'required',
                'description' => 'nullable',
                'file' => 'nullable'
            ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }


        $request_account = new AccountRequest();
        $request_account->supplier_id = $request->supplier_id;
        $request_account->price = $request->price;
        $request_account->description = $request->description;
        $request_account->file = $request->file;
        try {
            $request_account->save();

        } catch (\Exception $e) {

            return response()->json(msgdata($request, error(), 'error', $e));
        }

        $admin = Admin::first();
        $inbox = new Inbox();
        $inbox->message = 'طلب سحب مبلغ وقدرة ' . $request->price . '<br><br>' . $request->description;
        $inbox->receiver_id = $admin->id;
        $inbox->sender_id = $request->supplier_id;
        $inbox->sender_type = "supplier";
        $inbox->receiver_type = "admin";
        $inbox->save();
        try {
            $inbox->save();
        } catch (\Exception $e) {
            return response()->json(msgdata($request, error(), 'error', $e));
        }

        return response()->json(msgdata($request, success(), 'success', (object)[]));


    }

    public function RequestList(Request $request)
    {
        $rules =
            [
                'supplier_id' => 'required|exists:suppliers,id',

            ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }

        $data = AccountRequest::where('supplier_id', $request->supplier_id)->paginate(10);

        return response()->json(msgdata($request, success(), 'success', $data));


    }

    public function branchAccount(Request $request)
    {
        $rules =
            [
                'supplier_id' => 'required|exists:suppliers,id',

            ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }

        $data['branchAccounts'] = BranchAccount::OrderBy('id','desc')->where('supplier_id', $request->supplier_id)->paginate(10);
        $data['withdrawal'] = BranchAccount::where('supplier_id', $request->supplier_id)->where('type', 'withdrawal')->sum('price');
        $data['deposit'] = BranchAccount::where('supplier_id', $request->supplier_id)->where('type', 'deposit')->sum('price');
        $data['deserved_amount'] = $data['deposit'] - $data['withdrawal'];

        return response()->json(msgdata($request, success(), 'success', $data));
    }

    public function ManagerBranches(Request $request)
    {
        $data = Supplier::where('parent_id', supplier_parent_api())->get();
        return response()->json(msgdata($request, success(), 'success', $data));
    }
}
