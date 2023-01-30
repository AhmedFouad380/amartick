<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;
class AccouontRequestsController extends Controller
{
    public function index(){
        if(Auth::guard('admins')->check()){
        $Users = AccountRequest::OrderBy('id','desc')->paginate(10);
        }else{
            $Users = AccountRequest::OrderBy('id','desc')->where('supplier_id',Auth::guard('suppliers')->user()->id)->paginate(10);
        }
        return view('Admin.AccountRequest.index',compact('Users'));

    }


    public function Search(Request $request){
        if(Auth::guard('admins')->check()){
            $query = AccountRequest::OrderBy('id','desc');
        }else{
            $query   = AccountRequest::OrderBy('id','desc')->where('supplier_id',Auth::guard('suppliers')->user()->id);
        }
        if($request->supplier_id != 0 ){
            $query->where('supplier_id',$request->supplier_id);
        }
        if($request->from != null ){
            $query->whereDate('created_at','>=',$request->from);
        }
        if($request->to != null ){
            $query->whereDate('created_at','>=',$request->to);
        }
        $Users = $query->paginate(10);
        return view('Admin.AccountRequest.index',compact('Users'));

    }


    public function store(Request $request)
    {

        $this->validate(request(),[
            'price' => 'required|string',
            'supplier_id' => 'required',
            'description' => 'required|string',

        ]);
        if(AccountRequest::where('supplier_id',$request->supplier_id)->whereDate('created_at', '=' ,    date('Y-m-d'))->count() >  0 ){

            return back()->with('message', 'Failed');
        }
        $User=new AccountRequest;
        $User->price=$request->price;
        $User->supplier_id=$request->supplier_id;
        $User->description=$request->description;
        if($request->file){
            $User->file=$request->file;
        }

        try {
            $User->save();

        } catch (Exception $e) {
            return back()->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try{
            AccountRequest::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=AccountRequest::find($request->id);
        return view('Admin.AccountRequest.model',compact('User'));
    }



    public function update(Request $request)
    {

        $this->validate(request(),[
            'id' => 'required',
            'price' => 'required|string',
            'supplier_id' => 'required',
            'description' => 'required|string',

        ]);

        $User= AccountRequest::find($request->id);
        $User->price=$request->price;
        $User->supplier_id=$request->supplier_id;
        $User->description=$request->description;
        if($request->file){
            $User->file=$request->file;
        }
        $User->save();


        try {

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

}
