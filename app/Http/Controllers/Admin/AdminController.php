<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Log;
use App\Models\Admin;
use App\Models\LoginLog;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {

        $Users = Admin::OrderBy('id', 'desc')->get();
        return view('Admin.Admin.index', compact('Users'));

    }


    public function Search(Request $request)
    {
        $query = DB::table('admins')->OrderBy('id', 'desc');
        if ($request->name != null) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->phone != null) {
            $query->where('phone', $request->phone);
        }
        $Users = $query->get();
        return view('Admin.Admin.index', compact('Users'));

    }

    public function Profile()
    {
        if (Auth::guard('admins')->check()){
            $User = Admin::find(Auth::guard('admins')->user()->id);
        }elseif (Auth::guard('suppliers')->check()){
            $User = Supplier::find(Auth::guard('suppliers')->user()->id);

        }else{
            return redirect()->back();
        }

        return view('Admin.Admin.profile', compact('User'));

    }

    public function view($id)
    {
        $User = Admin::find($id);
        return view('Admin.Admin.view', compact('User'));

    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'string|email|unique:admins',
            'phone' => 'required|string|unique:admins',

        ]);

        $User = new Admin;
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->address = $request->address;
        $User->type = 'Admin';
        $User->password = $request->password;

        if ($request->file('image')) {
            $User->image = $request->image;
        }
        try {
            $User->save();
            $User->roles()->sync([$request->role]);
        } catch (Exception $e) {
            return back()->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try {
            Admin::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }


    public function edit(Request $request)
    {
        $User = Admin::find($request->id);
        return view('Admin.Admin.model', compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(), [
            'name' => 'required|string',
            'email' => 'string|email',
            'phone' => 'required|string',
        ]);


        if (Admin::where('phone', $request->phone)->where('id', '!=', $request->id)->count() > 0) {
            return back()->with('message', 'phone');

        }
        if (Admin::where('email', $request->email)->where('id', '!=', $request->id)->count() > 0) {
            return back()->with('message', 'email');

        }

        $User = Admin::find($request->id);
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->address = $request->address;
        $User->password = Hash::make($request->password);


        if ($request->file('image')) {
            $User->image = $request->image;

        }

        try {
            $User->save();
            $User->roles()->sync([$request->role]);

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }




        public function logout()
        {
            if (Auth::guard('admins')->check() || Auth::guard('suppliers')->check()) {
                auth_login()->logout();
                return redirect('/admin/login');
            }else {
                return redirect('/admin/login');
            }
        }


    public function Update_Profile(Request $request)
    {

        $this->validate(request(), [

        ]);


        if (Auth::guard('admins')->check()){
            $User = Admin::find($request->id);
        }elseif (Auth::guard('suppliers')->check()){
            $User = Supplier::find($request->id);

        }else{
            return redirect()->back();
        }

        $User->name = $request->name;
        $User->phone = $request->phone;

        if ($request->password) {
            $User->password = $request->password;
        }
        if ( $request->file('image')) {
            $User->image = $request->image;

        }

        try {
            $User->save();

        } catch (\Exception $e) {
            return back()->with('error_message', 'هناك خطأ ما فى عملية الاضافة');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function UpdateStatusUser(Request $request)
    {
        $User = Admin::find($request->id);
        if ($User->is_active == 1) {
            $User->is_active = 0;
        } else {
            $User->is_active = 1;

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

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'required',
        ]);

        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->with('message', 'Failed');
        }


        if (Auth::guard('admins')->attempt(['phone' => $request->phone, 'password' => $request->password, 'is_active' => 1])) {


            $ip = $request->ip();
            $dd = LoginLog::create([
                'user_id' => Auth::guard('admins')->user()->id,
                'ip' => $ip,
            ]);
            return redirect('/Admin-Panel');
        }

        if (Auth::guard('suppliers')->attempt(['phone' => $request->phone, 'password' => $request->password, 'is_active' => 1])) {

            return redirect('/Admin-Panel');
        }


        return redirect()->back()->with('message', 'Failed');


    }


    public function changePass()
    {
        $Users = User::all();
        foreach ($Users as $User) {
            $data = User::find($User->id);
            $data->password = Hash::make('123456');
            $data->save();
        }
        print_r('ss');
        die();

    }
}
