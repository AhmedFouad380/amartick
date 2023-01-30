<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function CreateProject(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'projectname' => 'required',
            'area' => 'required',
            'description' => '',
            'lat' => 'required',
            'lng' => 'required',
            'user_id' => 'required|exists:users,id',
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'flat_area' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        if (isset($request->manager_name) && isset($request->manager_password)) {
            if (User::where('phone', $request->manager_phone)->where('parent_id', $request->user_id)->where('email', $request->manager_email)->count() == 0) {
                $validator = Validator::make($request->all(), [
                    'manager_phone' => 'regex:/(966)[0-9]{8}/|unique:users,phone',
                    'manager_email' => 'nullable|unique:users,email',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
                }
                $employee = new User;
                $employee->name = $request->manager_name;
                $employee->phone = $request->manager_phone;
                if ($request->manager_email) {
                    $employee->email = $request->manager_email;
                }
                $employee->address = $request->manager_address;
                $employee->parent_id = $request->user_id;
                $employee->is_active = 1;
                $employee->type = 'Employee';
                $employee->password = Hash::make($request->manager_password);
                $employee->save();

                $Project = new Project();
                $Project->name = $request->projectname;
                $Project->area = $request->area;
                $Project->description = $request->description;
                $Project->lat = $request->lat;
                $Project->lng = $request->lng;
                $Project->country_id = $request->country_id;
                $Project->city_id = $request->city_id;
                $Project->flat_area = $request->flat_area;
                $Project->employee_id = $employee->id;
                $Project->manager_id = $request->user_id;
                $Project->save();
                return response()->json(msgdata($request, success(), 'success', $Project));

            } else {

                $employee = User::where('phone', $request->manager_phone)->first();
                $Project = new Project();
                $Project->name = $request->projectname;
                $Project->area = $request->area;
                $Project->description = $request->description;
                $Project->lat = $request->lat;
                $Project->lng = $request->lng;
                $Project->country_id = $request->country_id;
                $Project->city_id = $request->city_id;
                $Project->flat_area = $request->flat_area;
                $Project->employee_id = $employee->id;
                $Project->manager_id = $request->user_id;
                $Project->save();
                return response()->json(msgdata($request, success(), 'successAndAlreadyExsit', $Project));
            }

        } else {
            $Project = new Project();
            $Project->name = $request->projectname;
            $Project->area = $request->area;
            $Project->description = $request->description;
            $Project->lat = $request->lat;
            $Project->lng = $request->lng;
            $Project->country_id = $request->country_id;
            $Project->city_id = $request->city_id;
            $Project->flat_area = $request->flat_area;
            $request->user_id;
            $Project->manager_id = $request->user_id;
            $Project->save();
            return response()->json(msgdata($request, success(), 'success', $Project));
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'area' => 'required',
            'lat' => 'nullable',
            'lng' => 'nullable',
            'projectname' => 'required',
            'user_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'flat_area' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        // if is set manager i will delete old one and and this new user simply instead of this long code using
        // DB::beginTransaction();
        //and
        //  DB::rollBack();.......
        if (isset($request->manager_name) || isset($request->manager_password)
            || isset($request->manager_address) || isset($request->manager_phone) || isset($request->manager_email)) {
            if (User::where('phone', $request->manager_phone)->where('parent_id', $request->user_id)->count() == 0) {
                $validator = Validator::make($request->all(), [
                    'manager_phone' => 'regex:/(966)[0-9]{8}/|unique:users,phone',
                    'manager_email' => 'nullable|unique:users,email'
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
                }

                $employee = new User;
                $employee->name = $request->manager_name;
                $employee->phone = $request->manager_phone;
                $employee->email = $request->manager_email;
                $employee->address = $request->manager_address;
                $employee->parent_id = $request->user_id;
                $employee->is_active = 1;
                $employee->type = 'Employee';
                $employee->password = Hash::make($request->manager_password);
                $employee->save();

                $Project = Project::find($request->project_id);
                $Project->name = $request->projectname;
                $Project->area = $request->area;
                $Project->description = $request->description;
                if (Order::where('project_id', $Project->id)->where('type', 'Pending')
                        ->orWhere('type', 'ReOrder')->orWhere('type', 'Accepted')->count() > 0 ) {
                    $Project->lat = $request->lat;
                    $Project->lng = $request->lng;
                }
                $Project->country_id = $request->country_id;
                $Project->city_id = $request->city_id;
                $Project->flat_area = $request->flat_area;
                $Project->employee_id = $employee->id;
                $Project->manager_id = $request->user_id;
                $Project->save();
                return response()->json(msgdata($request, success(), 'success', $Project));
            } else {
                $Project = Project::find($request->project_id);
                if (User::where('phone', $request->manager_phone)->count() > 0) {
                    if (User::where('phone', $request->manager_phone)->first()->id == $Project->employee_id) {
                        $Project = Project::find($request->project_id);
                        $Project->name = $request->projectname;
                        $Project->area = $request->area;
                        $Project->description = $request->description;
                        if (Order::where('project_id', $Project->id)->where('type', 'Pending')
                                ->orWhere('type', 'ReOrder')->orWhere('type', 'Accepted')->count() > 0 ) {
                            $Project->lat = $request->lat;
                            $Project->lng = $request->lng;
                        }
                        $Project->country_id = $request->country_id;
                        $Project->city_id = $request->city_id;
                        $Project->flat_area = $request->flat_area;
                        $Project->manager_id = $request->user_id;
                        $Project->save();

                        $employee = User::find($Project->employee_id);
                        $employee->name = $request->manager_name;
                        $employee->phone = $request->manager_phone;
                        $employee->email = $request->manager_email;
                        $employee->address = $request->manager_address;
                        $employee->parent_id = $request->user_id;
                        if ($request->manager_password) {
                            $employee->password = Hash::make($request->manager_password);
                        }
                        $employee->save();
                        return response()->json(msgdata($request, success(), 'success', $Project));

                    } else {
                        $Project = Project::find($request->project_id);
                        $Project->name = $request->projectname;
                        $Project->area = $request->area;
                        $Project->description = $request->description;
                        if (Order::where('project_id', $Project->id)->where('type', 'Pending')
                                ->orWhere('type', 'ReOrder')->orWhere('type', 'Accepted')->count() > 0 ) {
                            $Project->lat = $request->lat;
                            $Project->lng = $request->lng;
                        }
                        $Project->country_id = $request->country_id;
                        $Project->city_id = $request->city_id;
                        $Project->flat_area = $request->flat_area;
                        $Project->manager_id = $request->user_id;
                        $Project->employee_id = User::where('phone', $request->manager_phone)->first()->id;
                        $Project->save();

                        $employee = User::find(User::where('phone', $request->manager_phone)->first()->id);
                        $employee->name = $request->manager_name;
                        $employee->phone = $request->manager_phone;
                        if ($request->manager_email) {
                            $employee->email = $request->manager_email;
                        }
                        $employee->address = $request->manager_address;
                        $employee->parent_id = $request->user_id;
                        if ($request->manager_password) {
                            $employee->password = Hash::make($request->manager_password);
                        }
                        $employee->save();
                        return response()->json(msgdata($request, success(), 'success', $Project));

                    }

                } else {
                    $employee = User::where('phone', $request->manager_phone)->first();
                    $Project = Project::find($request->project_id);
                    $Project->name = $request->projectname;
                    $Project->area = $request->area;
                    $Project->description = $request->description;
                    if (Order::where('project_id', $Project->id)->where('type', 'Pending')
                            ->orWhere('type', 'ReOrder')->orWhere('type', 'Accepted')->count() > 0 ) {
                        $Project->lat = $request->lat;
                        $Project->lng = $request->lng;
                    }
                    $Project->country_id = $request->country_id;
                    $Project->city_id = $request->city_id;
                    $Project->flat_area = $request->flat_area;
                    $Project->employee_id = $employee->id;
                    $Project->manager_id = $request->user_id;
                    $Project->save();
                    return response()->json(msgdata($request, success(), 'successAndAlreadyExsit', $Project));
                }
            }

        } else {
            $Project = Project::find($request->project_id);
            $Project->name = $request->projectname;
            $Project->area = $request->area;
            $Project->description = $request->description;
            if (Order::where('project_id', $Project->id)->where('type', 'Pending')
                    ->orWhere('type', 'ReOrder')->orWhere('type', 'Accepted')->count() > 0 ) {
                $Project->lat = $request->lat;
                $Project->lng = $request->lng;
            }
            $Project->country_id = $request->country_id;
            $Project->city_id = $request->city_id;
            $Project->flat_area = $request->flat_area;

            $request->user_id;
            $Project->manager_id = $request->user_id;
            $Project->save();
            return response()->json(msgdata($request, success(), 'success', $Project));

        }

    }

    public function GetProjects(Request $request)
    {
        $data = Project::where('manager_id', $request->user_id)->orwhere('employee_id', $request->user_id)->with('employee')->paginate(10);

        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));

        } else {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));


        }
    }

    public function GetProjectsNames(Request $request)
    {
        $data = Project::where('manager_id', $request->user_id)->orwhere('employee_id', $request->user_id)->select('id', 'name')->get();


        if (count($data) > 0) {
            return response()->json(msgdata($request, success(), 'success', $data));

        } else {
            return response()->json(msgdata($request, error(), 'nodata', []));
        }
    }

    public function GetProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]], 401);
        }

        $data = Project::where('id', $request->project_id)->with('Employee')->first();
        $Deposit = Wallet::where('type', 'deposit')->where('project_id', $data->id)->sum('price');
        $withdrawal = Wallet::where('type', 'withdrawal')->where('project_id', $data->id)->sum('price');

        $data->wallet = $Deposit - $withdrawal;
        return response()->json(msgdata($request, success(), 'success', $data));

    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]], 401);
        }
        $project = Project::find($request->project_id);
        if (Order::where('project_id', $request->project_id)->count() > 0) {
            return response()->json(msgdata($request, error(), 'projectDelete', (object)[]));

        } elseif (Project::where('manager_id', $project->manager_id)->count() < 2) {
            return response()->json(msgdata($request, error(), 'projectDelete', (object)[]));
        } else {
            Project::where('id', $request->project_id)->delete();
            return response()->json(msgdata($request, success(), 'success', (object)[]));
        }
    }
}

