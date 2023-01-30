<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainCategory;
use App\Models\SubCategory;
class CategoryController extends Controller
{

    public function MainCategories(Request $request){
        if(isset($request->search)){
            $data = MainCategory::where('name_ar','like','%'.$request->search.'%')->orwhere('name_en','like','%'.$request->search.'%')->paginate(10);
        }else{
        $data = MainCategory::paginate(10);
        }
        if(count($data)>0){
            return response()->json(msgdata($request, success(), 'success', $data ));
        }else{
            return response()->json(msgdata($request, error(), 'nodata', (object)[] ));
        }
    }

    public function MainCategoriesList(Request $request){
        if(isset($request->search)){
            $data = MainCategory::where('name_ar','like','%'.$request->search.'%')->orwhere('name_en','like','%'.$request->search.'%')->select('id','name_ar','name_en')->get();

        }else{
            $data = MainCategory::select('id','name_ar','name_en')->get();
        }
        if(count($data)>0){
            return response()->json(msgdata($request, success(), 'success', $data ));
        }else{
            return response()->json(msgdata($request, error(), 'nodata', (object)[] ));
        }
    }

    public function SubCategories(Request $request){
        if(isset($request->search)){
            $data = SubCategory::select('id','name_ar','name_en')->where('main_category_id',$request->mainCategory_id)->where('name_ar','like','%'.$request->search.'%')->orwhere('name_en','like','%'.$request->search.'%')->get();
        }else{
            $data = SubCategory::select('id','name_ar','name_en')->where('main_category_id',$request->mainCategory_id)->get();
        }
        if(count($data)>0){
            return response()->json(msgdata($request, success(), 'success', $data ));

        }else{
            return response()->json(msgdata($request, error(), 'nodata', (object)[] ));


        }
    }

}
