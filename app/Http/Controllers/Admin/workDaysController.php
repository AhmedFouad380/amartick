<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkDays;
use Illuminate\Http\Request;

class workDaysController extends Controller
{
    public function index(){
        $data = WorkDays::all();
        return view('Admin.WorkDays.index',compact('data'));
    }

    public function edit(Request $request)
    {
        $User=WorkDays::find($request->id);

        return view('Admin.WorkDays.model',compact('User'));
    }


    public function update(Request $request)
    {



        $User= WorkDays::find($request->id);
        $User->from=$request->from;
        $User->to=$request->to;
        $User->is_holiday=$request->is_holiday;


        try {

            $User->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }
}
