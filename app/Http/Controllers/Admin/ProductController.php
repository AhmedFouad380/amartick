<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use DB;
class ProductController extends Controller
{
    public function index(){
        $Users = Product::OrderBy('id','desc')->paginate(10);
        return view('Admin.Product.index',compact('Users'));

    }

    public function Search(Request $request){
        $query = Product::OrderBy('id', 'desc');
        if ($request->main_category_id != 0) {
            $query->where('main_category_id', $request->main_category_id);
        }
        if ($request->name_ar != null) {
            $query->where('name_ar', 'like', '%' . $request->name_ar . '%');
        }
        if ($request->name_en != null) {
            $query->where('name_en', 'like', '%' . $request->name_en . '%');
        }
        $Users = $query->paginate(10);
        return view('Admin.Product.index',compact('Users'));

    }



    public function store(Request $request)
    {

        $this->validate(request(),[
            'main_category_id' => 'required|string',
            'sub_category_id' => 'required|string',
            'image' => 'required',
            'name_ar' => 'required',
            'name_en' => 'required',
            'price' => 'required',
            'unit_ar' => 'required',
            'unit_en' => 'required',

        ]);

        $User=new Product;
        $User->main_category_id=$request->main_category_id;
        $User->sub_category_id=$request->sub_category_id;
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;
        $User->description_ar=$request->description_ar;
        $User->description_en=$request->description_en;
        $User->price=$request->price;
        $User->company_id=$request->company_id;
        $User->unit_ar=$request->unit_ar;
        $User->unit_en=$request->unit_en;
        $User->is_active=$request->is_active;


        try {
            $User->save();

            if($file=$request->file('image')){
                $Image = new ProductImage();
                $Image->image=$request->image;
                $Image->type='Main';
                $Image->product_id=$User->id;
                $Image->save();
            }
            if($file=$request->file('images')){
                foreach($file as $img){
                    $Image = new ProductImage();
                    $Image->image=$img;
                    $Image->type='Sub';
                    $Image->product_id=$User->id;
                    $Image->save();
                }
            }

        } catch (Exception $e) {
            return back()->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try{
            Product::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=Product::find($request->id);
        if(ProductImage::where('product_id',$request->id)->where('type','Main')->first()){
        $User->image=ProductImage::where('product_id',$request->id)->where('type','Main')->first()->image;
        }else{
            $User->image=null;
        }
        return view('Admin.Product.model',compact('User'));
    }

    public function ProductsImages($id)
    {
        $Users=ProductImage::where('type','Sub')->where('product_id',$id)->get();
        return view('Admin.Product.images',compact('Users','id'));
    }


    public function update(Request $request)
    {

        $this->validate(request(),[
            'main_category_id' => 'required|string',
            'sub_category_id' => 'required|string',
            'name_ar' => 'required',
            'name_en' => 'required',
            'price' => 'required',
            'unit_ar' => 'required',
            'unit_en' => 'required',

        ]);

        $User= Product::find($request->id);
        $User->main_category_id=$request->main_category_id;
        $User->sub_category_id=$request->sub_category_id;
        $User->name_ar=$request->name_ar;
        $User->name_en=$request->name_en;
        $User->description_ar=$request->description_ar;
        $User->description_en=$request->description_en;
        $User->price=$request->price;
        $User->is_active=$request->is_active;
        $User->company_id=$request->company_id;
        $User->unit_ar=$request->unit_ar;
        $User->unit_en=$request->unit_en;


        $User->save();

        if($file=$request->file('image')){
            $Image =  ProductImage::where('product_id',$request->id)->where('type','Main')->first();
            $Image->image=$request->image;
            $Image->save();
        }
        if($file=$request->file('images')){
            foreach($file as $img){
            $Image = new ProductImage();
            $Image->image=$img;
            $Image->type='Sub';
            $Image->product_id=$User->id;
            $Image->save();
            }
        }
        try {

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

        public function Create_ProductsImages(Request $request){

            if($file=$request->file('image')){
                $Image = new ProductImage();
                $Image->image=$request->image;
                $Image->type='Sub';
                $Image->product_id=$request->product_id;
                $Image->save();
            }
            return redirect()->back()->with('message', 'Success');

        }
        public function Edit_ProductsImages(Request $request)
        {
            $User=ProductImage::find($request->id);
            return view('Admin.Product.ImageModel',compact('User'));
        }
        public function Update_ProductsImages(Request $request){

            if($file=$request->file('image')){
                $Image =  ProductImage::find($request->id);
                $Image->image=$request->image;
                $Image->save();
            }
            return redirect()->back()->with('message', 'Success');

        }
        public function Delete_ProductsImages(Request $request)
        {
            try{
                ProductImage::whereIn('id',$request->id)->delete();
            } catch (\Exception $e) {
                return response()->json(['message'=>'Failed']);
            }
            return response()->json(['message'=>'Success']);
        }

    public function UpdateStatusProduct(Request $request){
        $User = Product::find($request->id);
        if($User->is_active == 1 ){
            $User->is_active = 0;
        }else{
            $User->is_active = 1;

        }
        $User->save();
        return response($User);
    }
}
