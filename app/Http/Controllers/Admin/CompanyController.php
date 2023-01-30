<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $Users = Company::OrderBy('id', 'desc')->get();
        return view('Admin.Company.index', compact('Users'));

    }


    public function Search(Request $request)
    {
        $query = DB::table('companies')->OrderBy('id', 'desc');
        if ($request->name != null) {
            $query
                ->where('name_ar', 'like', '%' . $request->name . '%')
                ->where('name_en', 'like', '%' . $request->name . '%');
        }

        $Users = $query->get();

        return view('Admin.Company.index', compact('Users'));

    }

    public function store(Request $request)
    {

        $this->validate(request(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',


        ]);

        $User = new Company();
        $User->name_ar = $request->name_ar;
        $User->name_en = $request->name_en;


        try {
            $User->save();
        } catch (\Exception $e) {
            return back()->with('error_message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try {
            Company::whereIn('id', $request->id)->delete();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }


    public function edit(Request $request)
    {
        $User = Company::find($request->id);
        return view('Admin.Company.model', compact('User'));
    }


    public function update(Request $request)
    {

        $this->validate(request(), [
            'name_ar' => 'required|string',
            'name_en' => 'required|string',
        ]);


        $User = Company::find($request->id);
        $User->name_ar = $request->name_ar;
        $User->name_en = $request->name_en;

        $User->save();


        try {

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }
        return redirect()->back()->with('message', 'Success');
    }
}
