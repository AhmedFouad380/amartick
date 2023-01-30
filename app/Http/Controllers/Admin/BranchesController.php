<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
{
    public function index(){
        $Users = Supplier::where('parent_id',Auth::guard('suppliers')->user()->id)->paginate(10);
        return view('Admin.Supplier.index',compact('Users'));

    }


    public function suppliersSearch(Request $request){
        $query = DB::table('suppliers')->OrderBy('id','desc');
        if($request->name != null ){
            $query->where('name','like','%'.$request->name.'%');
        }
        if($request->phone != null ){
            $query->where('phone',$request->phone);
        }
        $Users = $query->paginate(10);
        return view('Admin.Supplier.index',compact('Users'));

    }
    public function Profile(){
        $User = Admin::find(Auth::Supplier()->id);
        return view('Admin.Supplier.profile',compact('User'));

    }
    public function view($id){
        $User = Admin::find($id);
        return view('Admin.Supplier.view',compact('User'));

    }
    public function store(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|string',
            'email' => 'string|email|unique:suppliers',
            'phone' => 'required|string|unique:suppliers',
            'password' => 'required|string',
            'address' => 'required|string',

        ]);

        $User=new Supplier;
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->address=$request->address;
        if(Auth::guard('suppliers')->user()->id){
            $User->parent_id=Auth::guard('suppliers')->user()->id;
            $User->type="Employee";
        }else{
            $User->type="Manager";

        }
        $User->password=$request->password;
        $User->lat=$request->lat;
        $User->lng=$request->lng;

        if($request->file('image')){
            $User->image=$request->image;
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
        try{
            Supplier::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $User=Supplier::find($request->id);
        return view('Admin.User.model',compact('User'));
    }



    public function update(Request $request)
    {

        $this->validate(request(),[
            'name' => 'required|string',
            'email' => 'string|email',
            'phone' => 'required|string',
        ]);


        if(User::where('phone',$request->phone)->where('id','!=',$request->id)->count() > 0 ){
            return back()->with('message', 'phone');

        }
        if(User::where('email',$request->email)->where('id','!=',$request->id)->count() > 0 ){
            return back()->with('message', 'email');

        }

        $User= Supplier::find($request->id);
        $User->name=$request->name;
        $User->phone=$request->phone;
        $User->email=$request->email;
        $User->address=$request->address;
        if(isset($request->type)){
            $User->type=$request->type;
        }
        if(isset($request->parent_id)){
            $User->parent_id=$request->parent_id;
        }
        if(isset($request->password)){
            $User->password=Hash::make($request->password);
        }
        if(isset($request->image)){
            $User->image=$request->image;
        }
        $User->lat=$request->lat;
        $User->lng=$request->lng;
        try {
            $User->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

}
