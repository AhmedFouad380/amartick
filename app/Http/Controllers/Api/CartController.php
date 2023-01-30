<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\MainCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
class CartController extends Controller
{
    public function PayDetails(Request $request){


        $Categories = MainCategory::find($request->main_category_id);

        $Categories->cart = Cart::where('user_id',$request->user_id)
            ->where('main_category_id',$request->main_category_id)
            ->select('id','product_id','count','main_category_id')
            ->with('Product')->get();
        foreach($Categories->cart as $data){
            $price[] = Product::find($data->product_id)->price * $data->count;
        }
        $Categories->TotalPrice = array_sum($price);
        return response()->json(msgdata($request, success(), 'success', $Categories ));


    }

    public function CartCount(Request $request){
        if(isset($request->user_id)) {
            $count = Cart::where('user_id', $request->user_id)->sum('count');
            if($count > 0){
                $data['count']= $count;
            }else{
                $data['count']= '';
            }
            return response()->json(msgdata($request, success(), 'success', $data));

        }else if(isset($request->device_id)){
            $count = Cart::where('device_id', $request->device_id)->sum('count');
            if($count > 0){
            $data['count']= $count;
            }else{
                $data['count']= '';
            }

            return response()->json(msgdata($request, success(), 'success', $data ));

        }else{
            return response()->json(msgdata($request, error(), 'device_id', (object)[]));

        }


    }

    public function getCart(Request $request){
        if(isset($request->user_id)) {
            $Categories_id = Cart::where('user_id', $request->user_id)->pluck('main_category_id');


            $Categories = MainCategory::whereIn('id', $Categories_id)->with('DeliveryTime')->get();


            foreach ($Categories as $cat) {
                $cat->cart = Cart::where('main_category_id', $cat->id)
                    ->where('user_id', $request->user_id)
                    ->select('id', 'product_id', 'count', 'main_category_id')->with('Product')->get();
                $price = [];
                foreach($cat->cart as $data){
                    $Product = Product::find($data->product_id);
                    $data->total = $data->count * $Product->price;
                    $price[] = $data->count * $Product->price;
                }
                $cat->total_price = array_sum($price);
                $price = null;

            }

        }else if(isset($request->device_id)){
            $Categories_id = Cart::where('device_id',$request->device_id)->pluck('main_category_id');


            $Categories = MainCategory::whereIn('id', $Categories_id)->with('DeliveryTime')->get();


            foreach ($Categories as $cat) {
                $cat->cart = Cart::where('main_category_id', $cat->id)->where('device_id',$request->device_id)->select('id', 'product_id', 'count', 'main_category_id')->with('Product')->get();
                $price = [];
                foreach($cat->cart as $data){
                    $Product = Product::find($data->product_id);
                    $data->total = $data->count * $Product->price;

                    $price[] = $data->count * $Product->price;
                }
                $cat->total_price = array_sum($price);
                $price = null;
            }

        }

        if (count($Categories) > 0) {
            return response()->json(msgdata($request, success(), 'success', $Categories ));
        } else {
            return response()->json(msgdata($request, error(), 'nodata',[]));

        }


    }

    public function StoreCart(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'main_category_id'=> 'required',
            'count'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        if(isset($request->user_id)){
            if(Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->count() > 0){
                $data = Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->first();
                $data->count=$request->count;
                $data->save();

            }else{
                $data = new Cart();
                $data->user_id=$request->user_id + 0;
                $data->product_id=$request->product_id;
                $data->main_category_id=$request->main_category_id;
                $data->count=$request->count;
                $data->save();
            }
            $data->Cartcount = Cart::where('user_id',$request->user_id)->sum('count');
        }else if(isset($request->device_id)){
            if(Cart::where('device_id',$request->device_id)->where('product_id',$request->product_id)->count() > 0){
                $data = Cart::where('device_id',$request->device_id)->where('product_id',$request->product_id)->first();
                $data->count=$request->count;
                $data->save();

            }else{
                $data = new Cart();
                $data->device_id=$request->device_id;
                $data->product_id=$request->product_id;
                $data->main_category_id=$request->main_category_id;
                $data->count=$request->count;
                $data->save();
            }
            $data->Cartcount = Cart::where('device_id',$request->device_id)->sum('count');

        }else{
            return response()->json(msgdata($request, error(), 'device_id', (object)[]));

        }
        return response()->json(msgdata($request, success(), 'success', (object)[] ));

    }
    public function StoreCart2(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'main_category_id'=> 'required',
            'count'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        if(isset($request->user_id)){
            if(Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->count() > 0){
                $data = Cart::where('user_id',$request->user_id)->where('product_id',$request->product_id)->first();
                $data->count=$data->count + $request->count;
                $data->save();

            }else{
                $data = new Cart();
                $data->user_id=$request->user_id + 0;
                $data->product_id=$request->product_id;
                $data->main_category_id=$request->main_category_id;
                $data->count=$request->count;
                $data->save();
            }
            $data2= Cart::find($data->id);

            $data2->Cartcount = Cart::where('user_id',$request->user_id)->sum('count');

        }else if(isset($request->device_id)){
            if(Cart::where('device_id',$request->device_id)->where('product_id',$request->product_id)->count() > 0){
                $data = Cart::where('device_id',$request->device_id)->where('product_id',$request->product_id)->first();
                $data->count=$data->count + $request->count;
                $data->save();

            }else{
                $data = new Cart();
                $data->device_id=$request->device_id;
                $data->product_id=$request->product_id;
                $data->main_category_id=$request->main_category_id;
                $data->count=$request->count;
                $data->save();
            }
            $data2= Cart::find($data->id);
            $data2->Cartcount = Cart::where('device_id',$request->device_id)->sum('count');


        }else{
            return response()->json(msgdata($request, error(), 'device_id', (object)[]));

        }
        return response()->json(msgdata($request, success(), 'success', $data2 ));

    }
    public function DeleteCart(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        Cart::find($request->id)->delete();

        return response()->json(msgdata($request, success(), 'success', (object)[] ));

    }
}
