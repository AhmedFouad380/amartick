<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTime;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Models\Order;
class DeliveryTimeController extends Controller
{
    public function index($id){
        $Users = DeliveryTime::OrderBy('id','desc')->where('main_category_id',$id)->get();
        return view('Admin.DeliveryTime.index',compact('Users','id'));

    }
    public function index2(Request $request){
        $Order = Order::find($request->id);
        $Users = DeliveryTime::OrderBy('id','desc')->where('main_category_id',$Order->main_category_id)->get();
        return response()->json(msgdata($request, success(), 'success', $Users));
    }

    public function Search(Request $request){
        $query = DB::table('delivery_times')->OrderBy('id','desc');
        if($request->name != null ){
            $query->where('name_ar','like','%'.$request->name.'%');
        }

        $Users = $query->get();
        $id= $request->main_category_id;
        return view('Admin.SubCategory.index',compact('Users','id'));

    }
    public function store(Request $request)
    {

        $this->validate(request(),[
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
        ]);

        $User=new DeliveryTime;
        $User->ar_title=$request->ar_title;
        $User->en_title=$request->en_title;
        $User->main_category_id=$request->main_category_id;
        $User->created_by=Auth::id();
        $User->updated_by=Auth::id();
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
            DeliveryTime::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=DeliveryTime::find($request->id);
        return view('Admin.DeliveryTime.model',compact('User'));
    }



    public function update(Request $request)
    {

        $this->validate(request(),[
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
        ]);



        $User= DeliveryTime::find($request->id);
        $User->ar_title=$request->ar_title;
        $User->en_title=$request->en_title;
        $User->main_category_id=$request->main_category_id;
        $User->updated_by=Auth::id();

        $User->save();


        try {

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

}
