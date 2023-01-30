<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use DB;
class DistrictController extends Controller
{
    public function index(){
        $Users = City::OrderBy('id','desc')->with('Country')->paginate(10);
        return view('Admin.District.index',compact('Users'));

    }



    public function store(Request $request)
    {

        $this->validate(request(),[
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'country_id'=>'required|exists:countries,id'
        ]);

        $User=new City();
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;
        $User->country_id=$request->country_id;


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
            City::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=City::find($request->id);
        if(ProductImage::where('product_id',$request->id)->where('type','Main')->first()){
        $User->image=ProductImage::where('product_id',$request->id)->where('type','Main')->first()->image;
        }else{
            $User->image=null;
        }
        return view('Admin.District.model',compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(),[
            'name_ar' => 'required|string',
            'name_en' => 'required|string',

        ]);

        $User= City::find($request->id);
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;
        $User->country_id=$request->country_id;

        try {

            $User->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

}
