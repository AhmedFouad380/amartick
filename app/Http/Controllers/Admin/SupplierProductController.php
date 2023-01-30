<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class SupplierProductController extends Controller
{
    public function index(Request $request)
    {

        $query = Product::OrderBy('id', 'desc')->with('MainCategory')->with('SubCategory');
        if ($request->has('name_ar') && $request->name_ar != null) {
            $query->where('name_ar', $request->name_ar);
        }
        if ($request->has('name_en') && $request->name_en != null) {
            $query->where('name_en', $request->name_en);
        }
        if ($request->has('main_category_id') && $request->main_category_id != null) {
            $query->where('main_category_id', $request->main_category_id);
        }
        $Users = $query->paginate(10);

        $SupplierProduct = SupplierProduct::where('supplier_id', supplier_parent())->pluck('product_id')->ToArray();
        $id = supplier_parent();
        return view('Admin.SupplierProduct.index', compact('Users', 'SupplierProduct', 'id'));
    }

    public function index2($id , Request $request)
    {
        $query = Product::OrderBy('id', 'desc')->with('MainCategory')->with('SubCategory');
        if ($request->has('name_ar') && $request->name_ar != null) {
          $query->where('name_ar', $request->name_ar);
        }
        if ($request->has('name_en') && $request->name_en != null) {
            $query->where('name_en', $request->name_en);
        }
        if ($request->has('main_category_id') && $request->main_category_id != null) {
           $query->where('main_category_id', $request->main_category_id);
        }
        $Users = $query->paginate(10);
        $SupplierProduct = SupplierProduct::where('supplier_id', $id)->pluck('product_id')->ToArray();
        return view('Admin.SupplierProduct.index', compact('Users', 'SupplierProduct', 'id'));
    }


    public function Search(Request $request)
    {

        $SupplierProduct = SupplierProduct::where('supplier_id', supplier_parent())->pluck('product_id')->ToArray();

        $Users = Product::OrderBy('id', 'desc');
        if ($request->has('name_ar') && $request->name_ar != null) {

            $Users = $Users->where('name_ar', $request->name_ar);
        }
        if ($request->has('name_en') && $request->name_en != null) {
            $Users = $Users->where('name_en', $request->name_en);
        }
        if ($request->has('main_category_id') && $request->main_category_id != null) {

            $Users = $Users->where('main_category_id', $request->main_category_id);

        }
        $id = $request->id;
        $Users = $Users->paginate(10);
        return view('Admin.SupplierProduct.index',compact('Users','SupplierProduct','id'));
     }

    public function ChangeStatus(Request $request)
    {

        if ($request->supplier) {
            $data = SupplierProduct::where('supplier_id', supplier_parent2($request->supplier))->where('product_id', $request->id)->count();
            if ($data > 0) {
                SupplierProduct::where('supplier_id', supplier_parent2($request->supplier))->where('product_id', $request->id)->delete();
            } else {
                $data = new SupplierProduct;
                $data->product_id = $request->id;
                $data->supplier_id = supplier_parent2($request->supplier);
                $data->save();
            }
            return response()->json(msgdata($request, success(), 'success', $data));

        } else {
            $data = SupplierProduct::where('supplier_id', supplier_parent())->where('product_id', $request->id)->count();
            if ($data > 0) {
                SupplierProduct::where('supplier_id', supplier_parent())->where('product_id', $request->id)->delete();
            } else {
                $data = new SupplierProduct;
                $data->product_id = $request->id;
                $data->supplier_id = supplier_parent();
                $data->save();
            }
            return response()->json(msgdata($request, success(), 'success', $data));


        }
    }

    public function ChangeStatus2(Request $request)
    {

        $data = SupplierProduct::where('supplier_id', supplier_parent2($request->supplier))->where('product_id', $request->id)->count();
        if ($data > 0) {
            SupplierProduct::where('supplier_id', supplier_parent2($request->supplier))->where('product_id', $request->id)->delete();
        } else {
            $data = new SupplierProduct;
            $data->product_id = $request->id;
            $data->supplier_id = supplier_parent2($request->supplier);
            $data->save();
        }
        return response()->json(msgdata($request, success(), 'success', $data));
    }
}
