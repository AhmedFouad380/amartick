<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Wallet;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index($id){
        $Users = Project::where('employee_id',$id)->orWhere('manager_id',$id)->get();
        return view('Admin.Projects.index',compact('Users','id'));
    }

    public function Wallet($id){
        $Users = Wallet::where('project_id',$id)->get();
        return view('Admin.Projects.wallet',compact('Users','id'));

    }

    public function store(Request $request){
        $this->validate(request(),[
            'type' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'project_id' => 'required',

        ]);


        $wallet = new Wallet;
        $wallet->type=$request->type;
        $wallet->price=$request->amount;
        $wallet->description=$request->description;
        $wallet->project_id=$request->project_id;
        $wallet->save();

        return redirect()->back()->with('message', 'Success');
    }
}
