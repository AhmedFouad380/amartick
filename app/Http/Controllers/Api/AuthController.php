<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ForgetPass;
use App\Models\Project;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;
use JWTAuth;
use IlluminateHttpRequest;
use AppHttpRequestsRegisterAuthRequest;
use TymonJWTAuthExceptionsJWTException;
use SymfonyComponentHttpFoundationResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        $user = User::find(auth()->id());
        if ($user) {
            $user->device_token = null;
            $user->save();
        }
        auth()->logout(true);
        return response()->json(msgdata($request, token_expired(), 'unauthrized', (object)[]));

    }

    public function unauthrized(Request $request)
    {

        return response()->json(msgdata($request, token_expired(), 'unauthrized', null));

    }

    public function index(Request $request)
    {

        $data = User::Orderby('created_at', 'desc')->paginate(10);

        return response()->json(msgdata($request, success(), 'success', $data));

    }

    public function Profile(Request $request)
    {
        $data = User::where('id', $request->id)->with('Projects')->first();
        return response()->json(msgdata($request, success(), 'success', $data));

    }

    public function UpdateProfile(Request $request)
    {
        $data = User::find($request->id)->with('Projects');

        return response()->json(msgdata($request, success(), 'success', $data));

    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/',
            'password' => 'required|min:6',
                'device_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        $count = User::where('phone', $request->phone)->count();
        $first = User::where('phone', $request->phone)->first();
        $input = $request->only('phone', 'password');
        $jwt_token = null;
//        ِAuth::logout($first);

        if ($count == 0) {
            return response()->json(msgdata($request, error(), 'phone_wrong', (object)[]));

        } elseif (!$jwt_token = JWTAuth::attempt($input, ['exp' => Carbon::now()->addDays(7)->timestamp])) {
            return response()->json(msgdata($request, error(), 'password_wrong', (object)[]));

        } else {

            $user = Auth::user();
            $user->device_token = $request->device_token;
            $user->save();
            $user->token = $jwt_token;
            if (isset($request->device_id)) {
                Cart::where('device_id', $request->device_id)->update(['user_id' => $user->id, 'device_id' => null]);
            }
            return response()->json(msgdata($request, success(), 'success', $user));

        }
    }

    public function Update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'min:12||regex:/(966)[0-9]{8}/',
            'name' => 'required',
            'email' => 'email',
            'user_id' => 'required|exists:users,id',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = User::find($request->user_id);
        $data->name = $request->name;
        if (isset($request->phone)) {
            $data->phone = $request->phone;
        }
        if (isset($request->image)) {
            $data->image = $request->image;
        }
        $data->address = $request->address;
        if (isset($request->password)) {
            $data->password = Hash::make($request->password);
        }
        $data->save();


        return response()->json(msgdata($request, success(), 'success', $data));


    }

    public function UpdateProject(Request $request)
    {

        $validator = Validator::make($request->all(), [
//            'name' => 'required',
            'project_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        $Project = Project::find($request->project_id);
        $Project->name = $request->projectname;
        $Project->area = $request->area;
        $Project->description = $request->description;
        $Project->lat = $request->lat;
        $Project->lng = $request->lng;
        $Project->save();

        return response()->json(msgdata($request, success(), 'success', $Project));

    }

    public function Store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'projectname' => 'required',
            'area' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric|min:12|unique:users,phone|regex:/(966)[0-9]{8}/',
            'manager_phone' => 'regex:/(966)[0-9]{8}/',
            'manager_email' => 'email',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6',
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'flat_area' => 'required',
            'device_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = new User;
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->parent_id = $request->parent_id;
        $data->device_token = $request->device_id;
//        $data->device_id = $request->device_id;
        $data->is_active = 1;
        $data->type = 'Manager';
        if ($request->image) {
            $data->image = $request->image;
        }
        $data->password = Hash::make($request->password);
        $data->save();

        if (isset($request->manager_name) && isset($request->manager_password)) {
            if (User::where('phone', $request->manager_phone)->count() == 0) {
                $employee = new User;
                $employee->name = $request->manager_name;
                $employee->phone = $request->manager_phone;
                if ($request->email) {
                    $employee->email = $request->manager_email;
                }
                $employee->address = $request->manager_address;
                $employee->parent_id = $data->id;
                $employee->is_active = 1;
                $employee->type = 'Employee';
                $employee->password = Hash::make($request->manager_password);
                $employee->save();
            } else {
                $employee = User::where('phone', $request->manager_phone)->first();
            }


            $Project = new Project();
            $Project->name = $request->projectname;
            $Project->area = $request->area;
            $Project->description = $request->description;
            $Project->lat = $request->lat;
            $Project->lng = $request->lng;
            $Project->country_id = $request->country_id;
            $Project->city_id = $request->city_id;
            $Project->flat_area = $request->flat_area;
            $Project->manager_id = $data->id;
            $Project->employee_id = $employee->id;
            $Project->save();
        }
        else {

            $Project = new Project();
            $Project->name = $request->projectname;
            $Project->area = $request->area;
            $Project->description = $request->description;
            $Project->lat = $request->lat;
            $Project->lng = $request->lng;
            $Project->country_id = $request->country_id;
            $Project->city_id = $request->city_id;
            $Project->flat_area = $request->flat_area;

            $Project->manager_id = $data->id;
            $Project->save();
        }

        $User = User::find($data->id);
        $input = $request->only('phone', 'password');
        $jwt_token = JWTAuth::attempt($input);
        $User->token = $jwt_token;
        if (isset($request->device_id)) {
            Cart::where('device_id', $request->device_id)->update(['user_id' => $User->id, 'device_id' => null]);
        }
        return response()->json(msgdata($request, success(), 'register_success', $User));


    }

    public function forget_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:12',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        if (User::where('phone', $request->phone)->count() > 0) {
            $User = User::where('phone', $request->phone)->first();
            ForgetPass::where('user_id', $User->id)->delete();
            $data = new ForgetPass();
            $data->user_id = $User->id;
            $data->code = rand(1111, 9999);
            $data->save();
            $User->code = $data->code;
            $ch = curl_init();
            $url = "http://basic.unifonic.com/rest/SMS/messages";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "AppSid=ngKAr3bTdAMthOzNZumtHX3DaEuJEx&Body=كود التحقق :" . $data->code . "&SenderID=AMAR-TICK&Recipient=" . $User->phone . "&encoding=UTF8&responseType=json"); // define what you want to post
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            $user_id = array('user_id' => $User->id);

            return response()->json(msgdata($request, success(), 'code_sent', $user_id));


        } else {
            return response()->json(msgdata($request, error(), 'phone_wrong', (object)[]));

        }
    }

    public function ChangePass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        $User = User::find($request->user_id);
        $User->password = Hash::make($request->password);
        $User->save();
        ForgetPass::where('user_id', $request->user_id)->delete();
        return response()->json(msgdata($request, success(), 'success', $User));


    }

    public function confirm_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        if (ForgetPass::where('user_id', $request->user_id)->where('code', $request->code)->count() > 0) {
            $User = User::find($request->user_id);
            return response()->json(msgdata($request, success(), 'success', (object)[]));

        } else {
            return response()->json(msgdata($request, error(), 'code_expire', (object)[]));

        }
    }

    public function Setting(Request $request)
    {
        $data = Setting::find(1);
        return response()->json(msgdata($request, success(), 'success', $data));

    }


}
