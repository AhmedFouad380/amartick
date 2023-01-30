<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Deligate;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use DB;
class DeligateController extends Controller
{
    public function index(){
        $Users = Deligate::where('supplier_id',supplier_parent())->OrderBy('id','desc')->paginate(10);
        return view('Admin.Deligate.index',compact('Users'));

    }



    public function store(Request $request)
    {


        $this->validate(request(),[
            'name' => 'required|string',
            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/',


        ]);

        $User=new Deligate();
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->supplier_id=supplier_parent();


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
            Deligate::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=Deligate::find($request->id);
        if(ProductImage::where('product_id',$request->id)->where('type','Main')->first()){
        $User->image=ProductImage::where('product_id',$request->id)->where('type','Main')->first()->image;
        }else{
            $User->image=null;
        }
        return view('Admin.Deligate.model',compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|string',
            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/',

        ]);

        $User= Deligate::find($request->id);
        $User->name=$request->name;
        $User->phone=$request->phone;


        try {

            $User->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

}
