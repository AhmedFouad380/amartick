<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BranchAccount;
use Illuminate\Http\Request;

class BranchAccountController extends Controller
{
    public function index($id){
        $Users = BranchAccount::where('supplier_id',$id)->get();
        return view('Admin.BranchAccount.index',compact('Users','id'));
    }



    public function store(Request $request){
        $this->validate(request(),[
            'amount' => 'required',
            'description' => 'required',
            'supplier_id' => 'required',

        ]);


        $wallet = new BranchAccount;
        $wallet->type='withdrawal';
        $wallet->price=$request->amount;
        $wallet->description=$request->description;
        $wallet->supplier_id=$request->supplier_id;
        $wallet->file=$request->file;
        $wallet->save();

        return redirect()->back()->with('message', 'Success');
    }
//    public function delete(Request $request)
//    {
//        try {
//            BranchAccount::whereIn('id', $request->id)->delete();
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Failed']);
//        }
//        return response()->json(['message' => 'Success']);
//    }


}
