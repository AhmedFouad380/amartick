<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){

        $Setting = Setting::find(1);
        return view('Admin.Setting.index',compact('Setting'));

    }


    public function store(Request $request)
    {

        $this->validate(request(),[
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'phone' => 'required|string',
            'address' => 'image|mimes:png,jpg,jpeg|max:2048',
            'logo' => 'image|mimes:png,jpg,jpeg|max:2048',
            'signature' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $Setting=new Setting;


        if($file1=$request->file('logo')){
            $name='img' .time() . '.' .$file1->getClientOriginalExtension();
            $file1->move(public_path('Upload'), $name);
            $Setting->logo=$name;

        }

        if($file2=$request->file('seal')){
            $name='img' .time() . '.' .$file2->getClientOriginalExtension();
            $file2->move(public_path('Upload'), $name);
            $Setting->company_seal=$name;

        }

        if($file3=$request->file('signature')){
            $name='img' .time() . '.' .$file3->getClientOriginalExtension();
            $file3->move(public_path('Upload'), $name);
            $Setting->signature=$name;

        }

        try {
            $Setting->save();
        } catch (Exception $e) {
            return redirect('/Setting')->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try{
            Setting::whereIn('id',$request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message'=>'Failed']);
        }
        return response()->json(['message'=>'Success']);
    }


    public function edit(Request $request)
    {
        $Setting=Setting::find($request->id);
        return view('Admin.Setting.model',compact('Setting'));
    }


    public function update(Request $request)
    {

        $this->validate(request(),[

        ]);


        $Setting= Setting::find($request->id);

        $Setting->name_ar = $request->name_ar;
        $Setting->name_en = $request->name_en;
        $Setting->description_ar=$request->description_ar;
        $Setting->description_en=$request->description_en;
        $Setting->phone=$request->phone;
        $Setting->address=$request->address;
        $Setting->email=$request->email;
        $Setting->facebook=$request->facebook;
        $Setting->twitter=$request->twitter;
        $Setting->web=$request->web;
        $Setting->logo=$request->logo;
        $Setting->terms_policy=$request->terms_policy;
        $Setting->max_pay_time=$request->max_pay_time;
        $Setting->max_flexible_time=$request->max_flexible_time;

        try {
            $Setting->save();

        } catch (Exception $e) {
            return back()->with('error_message', 'هناك خطأ ما فى عملية الاضافة');
        }
        return redirect()->back()->with('message', 'Success');
    }


}
