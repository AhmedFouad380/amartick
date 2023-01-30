<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request){

            $query = Product::where('is_active',1);
                if($request->main_category_id != 0){
                    $query->where('main_category_id',$request->main_category_id);
                }
                if($request->sub_category_id != 0){
                    $query->where('sub_category_id',$request->sub_category_id);
                }
                if(isset($request->delivery_time)){
                    $query->where('delivery_time','<=',$request->delivery_time);
                }
                if(isset($request->from_price)){
                    $query->where('price','>=',$request->from_price);
                }
                if(isset($request->to_price)){
                    $query->where('price','<=',$request->to_price);
                }
                if(isset($request->search)){
                    $query->where('name_ar','like','%'.$request->search.'%')->orwhere('name_en','like','%'.$request->search.'%');
                }

                $data= $query->with('images')->with(['image' => function ($query) {
                    $query->where('type', 'like', '%Main%');
                }])->with('Company')->withCasts([
                'price'=>'float'
                ])->paginate(10);



            if(count($data)>0){
                return response()->json(msgdata($request, success(), 'success', $data ));

            }else{
                return response()->json(msgdata($request, error(), 'nodata', (object)[] ));
            }

    }
}
