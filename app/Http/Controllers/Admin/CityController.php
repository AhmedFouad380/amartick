<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use DB;
class CityController extends Controller
{
    public function index(){
        $Users = Country::OrderBy('id','desc')->paginate(10);
        return view('Admin.City.index',compact('Users'));

    }



    public function store(Request $request)
    {

        $this->validate(request(),[
            'name_ar' => 'required|string',
            'name_en' => 'required|string', 
        ]);

        $User=new Country();
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;


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
            Country::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=Country::find($request->id);
         
        return view('Admin.City.model',compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(),[
            'name_ar' => 'required|string',
            'name_en' => 'required|string',

        ]);

        $User= Country::find($request->id);
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;


        try {

            $User->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

}
