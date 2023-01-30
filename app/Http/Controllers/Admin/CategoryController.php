<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $Users = MainCategory::OrderBy('id', 'desc')->get();
        return view('Admin.MainCategory.index', compact('Users'));

    }


    public function Search(Request $request)
    {
        $query = DB::table('main_categories')->OrderBy('id', 'desc');
        if ($request->name != null) {
            $query->where('name_ar', 'like', '%' . $request->name . '%');
        }
        if ($request->estimate_time != null) {
            $query->where('estimate_time', $request->estimate_time);
        }
        $Users = $query->get();
        return view('Admin.MainCategory.index', compact('Users'));

    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'image' => 'required',
            'estimate_time' => 'required',
            'supplier_count' => 'required',
            'max_request' => 'required',
            'max_distance' => 'required',
            'max_time_reorder' => 'required',

        ]);

        $User=new MainCategory;
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;
        $User->deliver_from=$request->deliver_from;
        $User->deliver_to=$request->deliver_to;
        $User->estimate_time=$request->estimate_time;
        $User->supplier_count=$request->supplier_count;
        $User->max_request=$request->max_request;
        $User->max_distance=$request->max_distance;
        $User->max_time_reorder=$request->max_time_reorder;
            $User->icon=$request->icon;
        if($request->file('image')){
            $User->image=$request->image;

        }
         try {
            $User->save();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try {
            MainCategory::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }


    public function edit(Request $request)
    {
        $User = MainCategory::find($request->id);
        return view('Admin.MainCategory.model', compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'estimate_time' => 'required',
        ]);




        $User= MainCategory::find($request->id);
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;
        $User->deliver_from=$request->deliver_from;
        $User->deliver_to=$request->deliver_to;
        $User->estimate_time=$request->estimate_time;
        $User->supplier_count=$request->supplier_count;
        $User->max_request=$request->max_request;
        $User->max_distance=$request->max_distance;
        $User->max_time_reorder=$request->max_time_reorder;
        $User->icon=$request->icon;


        if($request->file('image')){
            $User->image=$request->image;

         }
        $User->save();


        try {

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }
    public function GetSubCategory(Request $request){
        $data = SubCategory::where('main_category_id',$request->id)->pluck('id','name_ar');

        return response($data);
    }

}
