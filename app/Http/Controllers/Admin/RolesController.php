<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ProductImage;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function index()
    {
        $Users = Role::OrderBy('id', 'desc')->paginate(10);
        return view('Admin.Roles.index', compact('Users'));

    }

    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name ,'guard_name'=>'admins']);
        $role->syncPermissions($request->permissions);
        return redirect()->back()->with('message', 'Success');
    }

    public function delete(Request $request)
    {
        try {
            Role::whereIn('id',$request->id)->delete();

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed']);
        }
        return response()->json(['message' => 'Success']);
    }


    public function edit(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $permissions = Permission::all();
        $r_permissions[] = null;
        $role_permissions = DB::table('role_has_permissions')
            ->where('role_id', $request->id)
            ->get();
        foreach ($role_permissions as $key => $permission) {
            $r_permissions[] = $permission->permission_id;
        }

        return view('Admin.Roles.model', compact('role', 'permissions', 'r_permissions'));
    }


    public function update(Request $request)
    {

        $role = Role::findOrFail($request->id);
        $role->name = $request->name;
        $role->save();
        if ($request->has('permissions')) {

            DB::delete("delete from role_has_permissions where role_id = ?", array($request->id));
            $role->syncPermissions($request->permissions);

            return redirect()->back()->with('message', 'Success');
        }
        return back()->with('message', 'Failed');
    }
}
