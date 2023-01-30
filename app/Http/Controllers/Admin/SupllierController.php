<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Attachment;
use App\Models\Inbox;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class SupllierController extends Controller
{
    public function index()
    {
        $Users = Supplier::OrderBy('id', 'desc')->paginate(10);
        return view('Admin.Supplier.index', compact('Users'));

    }

    public function supplier($id)
    {
        $Supplier = Supplier::find($id);
        $Branch = Supplier::where('parent_id', $id)->OrderBy('id', 'asc')->first();
        $attachments = Attachment::where('supplier_id', $id)->get();
        return view('Admin.Supplier.view', compact('Supplier', 'Branch', 'attachments'));

    }

    public function Branches()
    {
        $Users = Supplier::where('parent_id', Auth::guard('suppliers')->user()->id)->paginate(10);
        return view('Admin.Supplier.index', compact('Users'));

    }


    public function suppliersSearch(Request $request)
    {
        $query = DB::table('suppliers')->OrderBy('id', 'desc');
        if ($request->name != null) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->phone != null) {
            $query->where('phone', $request->phone);
        }
        $Users = $query->paginate(10);
        return view('Admin.Supplier.index', compact('Users'));

    }

    public function Profile()
    {
        $User = Admin::find(Auth::user()->id);
        return view('Admin.Supplier.profile', compact('User'));

    }

    public function view($id)
    {
        $User = Admin::find($id);
        return view('Admin.Supplier.view', compact('User'));

    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'string|email|unique:suppliers',
            'phone' => 'required|string|unique:suppliers',
            'password' => 'required|string',
            'address' => 'required|string',

        ]);

        $User = new Supplier;
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->address = $request->address;
        if (Auth::guard('suppliers')->user()) {
            $User->parent_id = Auth::guard('suppliers')->user()->id;
            $User->type = "Employee";
        } else {
            $User->type = "Manager";

        }
        $User->password = $request->password;
        $User->lat = $request->lat;
        $User->lng = $request->lng;

        if ($request->file('image')) {
            $User->image = $request->image;
        }
        try {
            $User->save();
        } catch (Exception $e) {
            return redirect('/suppliers')->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try {
            Supplier::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }


    public function edit(Request $request)
    {
        $User = Supplier::find($request->id);
        return view('Admin.User.model', compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'string|email',
            'phone' => 'required|string',
        ]);


        if (User::where('phone', $request->phone)->where('id', '!=', $request->id)->count() > 0) {
            return back()->with('message', 'phone');

        }
        if (User::where('email', $request->email)->where('id', '!=', $request->id)->count() > 0) {
            return back()->with('message', 'email');

        }

        $User = Supplier::find($request->id);
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->address = $request->address;
        if (isset($request->type)) {
            $User->type = $request->type;
        }
        if (isset($request->parent_id)) {
            $User->parent_id = $request->parent_id;
        }
        if (isset($request->password)) {
            $User->password = $request->password;
        }
        if (isset($request->image)) {
            $User->image = $request->image;
        }
        $User->lat = $request->lat;
        $User->lng = $request->lng;
        try {
            $User->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function Update_User_Notation(Request $request)
    {

        $User = User::find($request->id);
        if ($file = $request->file('signature_img')) {
            $name = time() . '.' . $file->getClientOriginalName();
            $file->move('Upload/UserFiles', $name);
            $User->signature_img = $name;

        }
        if ($file = $request->file('notation_img')) {
            $name = time() . '.' . $file->getClientOriginalName();
            $file->move('Upload/UserFiles', $name);
            $User->notation_img = $name;

        }
        try {
            $User->save();

        } catch (Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function logout()
    {

        Auth::logout();

        return redirect('/login');
    }

    public function Update_Profile(Request $request)
    {

        $this->validate(request(), [

        ]);


        $User = User::find($request->id);
        $User->name = $request->name;
        $User->en_name = $request->en_name;
        $User->phone = $request->phone;
        $User->fpuid = $request->fpuid;

        if ($request->password) {
            $User->password = $request->password;
        }
        if ($file = $request->file('img')) {
            $name = time() . '.' . $file->getClientOriginalName();
            $file->move('Upload/User', $name);
            $User->img = $name;

        }


        try {
            $User->save();

        } catch (\Exception $e) {
            return back()->with('error_message', 'هناك خطأ ما فى عملية الاضافة');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function SupplierActive(Request $request)
    {
        $User = Supplier::find($request->id);
        $User->is_active = $request->is_active;
        $User->save();
        if ($request->is_active == 0) {
            $sup_supplier = Supplier::where('parent_id', $request->id)->first();
            try {
                $sup_supplier->delete();
                $User->delete();

            } catch (\Exception $e) {
                return redirect('/suppliers')->with('message', 'Failed');

            }
        }
        Supplier::where('parent_id', $request->id)->update(['is_active' => $request->is_active]);
        return redirect('/suppliers')->with('message', 'Success');

    }

    public function UpdateStatusSupplier(Request $request)
    {
        $User = Supplier::find($request->id);
        if ($User->is_active == 1) {
            $User->is_active = 0;
            Supplier::where('parent_id', $request->id)->update(['is_active' => 0]);

        } else {
            $User->is_active = 1;
            Supplier::where('parent_id', $request->id)->update(['is_active' => 1]);
        }
        $User->save();
        return response($User);

    }

    public function UserUpdateContractDate(Request $request)
    {

        $User = User::find($request->id);
        $User->contract_status = $request->contract_status;
        if ($request->type == 1) {
            $User->end_contract_date = \Carbon\Carbon::parse($request->end_contract_date)->addYear(1);
        } else {
            $User->end_contract_date = \Carbon\Carbon::parse($request->end_contract_date)->addYear(2);
        }
        $User->save();

        return redirect()->back()->with('message', 'Success');
    }

    public function login(Request $request)
    {

        $this->validate(request(), [
            'national_id' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt(['national_id' => $request->national_id, 'password' => $request->password, 'isActive' => 1])) {
            $data = new Log;
            $data->ip_address = \Request::ip();
            $data->description = 'قام المستخدم ' . $request->email . 'بتسجيل الدخول في يوم ' . date('Y-m-d') . '  ' . time();
            $data->user_id = Auth::user()->id;
            $data->save();
            return redirect('/');
        } else {
            $data = new Log;
            $data->ip_address = \Request::ip();
            $data->description = 'قام  بمحاولة تسجيل فاشلة للمستخدم ' . $request->email . ' في يوم ' . date('Y-m-d') . '  ' . time();
            $data->user_id = null;
            $data->save();
            return redirect()->back()->with('message', 'Failed');


        }
    }

    public function changePass()
    {
        $Users = User::all();
        foreach ($Users as $User) {
            $data = User::find($User->id);
            $data->password = Hash::make('123456');
            $data->save();
        }
        return redirect()->back()->with('message', 'Success');

    }


    public function Register(Request $request)
    {
        $this->validate(\request(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/|unique:suppliers,phone',
            'password' => 'required',
            'address' => 'required|string',
            'attachments' => 'required',
            'attachments.*' => 'required|mimes:jpg,jpeg,png,gif,bmp,pdf,doc,docx',
            'branch_name' => 'required|string',
            'branch_email' => 'required|email|unique:suppliers,email|different:email',
            'branch_phone' => 'required|min:12|regex:/(966)[0-9]{8}/|unique:suppliers,phone|different:phone',
            'branch_password' => 'required',
            'branch_address' => 'required|string',
            'category' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'desc' => '',

        ]);
        $category = MainCategory::whereIn('id', $request->category)->pluck('name_ar');

        $supplier_manager = new Supplier();
        $supplier_manager->name = $request->name;
        $supplier_manager->email = $request->email;
        $supplier_manager->phone = $request->phone;
        $supplier_manager->address = $request->address;
        $supplier_manager->type = "Manager";
        $supplier_manager->password = $request->password;
        $supplier_manager->is_active = 0;
        $supplier_manager->lat = $request->lat;
        $supplier_manager->lng = $request->lng;
        $supplier_manager->categories = implode(" - ", $category->toArray());
        $supplier_manager->save();

        $supplier_branch = new Supplier();
        $supplier_branch->name = $request->branch_name;
        $supplier_branch->email = $request->branch_email;
        $supplier_branch->phone = $request->branch_phone;
        $supplier_branch->password = $request->branch_password;
        $supplier_branch->address = $request->branch_address;
        $supplier_branch->type = "Employee";
        $supplier_branch->parent_id = $supplier_manager->id;
        $supplier_branch->is_active = 0;
        $supplier_branch->lat = $request->lat;
        $supplier_branch->lng = $request->lng;
        $supplier_branch->save();


        $inbox = new Inbox();
        $inbox->message = " تم ارسال طلب تسجيل مورد جديد يعمل فى  " . implode(" - ", $category->toArray()) . "<br>" . $request->desc;
        $inbox->receiver_id = Admin::first()->id;
        $inbox->receiver_type = "admin";
        $inbox->type = "notification";
        $inbox->sender_id = $supplier_manager->id;
        $inbox->sender_type = "supplier";
        $inbox->supplier_id = $supplier_manager->id;
        $inbox->save();
        foreach (Product::whereIn('main_category_id', $request->category)->get() as $item) {

            $supplierProducts = new SupplierProduct();
            $supplierProducts->supplier_id = $supplier_branch->id;
            $supplierProducts->product_id = $item->id;
            $supplierProducts->status = 1;
            $supplierProducts->save();

        }

        foreach ($request->attachments as $attachment) {
            Attachment::create([
                'file' => $attachment,
                'supplier_id' => $supplier_manager->id
            ]);
        }


        return redirect()->back()->with('message', 'Success');


    }
}
