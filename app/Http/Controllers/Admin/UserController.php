<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\Concerns\Has;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        $Users = User::OrderBy('id','desc')->get();

        return view('Admin.User.index',compact('Users'));

    }

    public function Search(Request $request){

        $query = User::OrderBy('id','desc');
        if ($request->has('name') && $request->name != null) {
            $query->where('name', $request->name);
        }
        if ($request->has('phone') && $request->phone != null) {
            $query->where('phone', $request->phone);
        }

        $Users = $query->get();
        return view('Admin.User.index',compact('Users'));


    }

    public function Profile(){
        $User = User::findOrFail(Auth::user()->id);
        return view('Admin.User.profile',compact('User'));

    }
    public function view($id){
        $User = User::findOrFail($id);
        return view('Admin.User.view',compact('User'));

    }
    public function store(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|string',
            'email' => 'string|email',
            'phone' => 'required|string|unique:users',
            'address' => 'required',
            'password' => 'required',

        ]);

        $User=new User;
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->address=$request->address;
        $User->type='Manager';
        $User->password=Hash::make($request->password);


        if($file=$request->file('image')){
            $User->image=$request->image;
        }
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
            User::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=User::find($request->id);
        return view('Admin.User.model',compact('User'));
    }

    public function show(Request $request)
    {
        $User = User::find($request->id);
        $project = Project::whereId($request->project_id)->first();

        return view('Admin.User.show',compact('User','project'));
    }



    public function update(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|string',
            'email' => 'string|email|unique:users,email,'.$request->id,
            'phone' => 'required|string|unique:users,phone,'.$request->id,
            'address' => 'required',
        ]);



        $User= User::find($request->id);
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->address=$request->address;
        $User->password=Hash::make($request->password);


        if($file=$request->file('img')){
            $name=time() . '.' .$file->getClientOriginalName();
            $file->move('Upload/User',$name);
            $User->img=$name;

        }
        $User->save();


        try {

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }


    public function logout(){

        Auth::logout();

        return redirect('/login');
    }

    public function Update_Profile(Request $request)
    {

        $this->validate(request(),[

        ]);


        $User= User::find($request->id);
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->address=$request->address;

        if($request->password){
            $User->password=Hash::make($request->password);
        }
        if($file=$request->file('img')){
            $name=time() . '.' .$file->getClientOriginalName();
            $file->move('Upload/User',$name);
            $User->img=$name;

        }


        try {
            $User->save();

        } catch (\Exception $e) {
            return back()->with('error_message', 'هناك خطأ ما فى عملية الاضافة');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function UpdateStatusUser(Request $request){
        $User = User::find($request->id);
        if($User->is_active == 1 ){
            $User->is_active = 0;
        }else{
            $User->is_active = 1;

        }
        $User->save();
        return response($User);

    }



    public function login(Request $request){

        $this->validate(request(),[
            'national_id' => 'required|string',
            'password' => 'required',
        ]);

        if(Auth::attempt(['national_id' => $request->national_id, 'password' => $request->password ,'isActive' => 1] ) ){
            return redirect('/');
        }else{
            return redirect()->back()->with('message', 'Failed');


        }
    }
    public function changePass(){
        $Users = User::all();
        foreach($Users as $User){
            $data = User::find($User->id);
            $data->password=Hash::make('123456');
            $data->save();
        }
        print_r('ss');die();

    }
}
