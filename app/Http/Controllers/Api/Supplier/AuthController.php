<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Attachment;
use App\Models\Cart;
use App\Models\ForgetPass;
use App\Models\Inbox;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;
use JWTAuth;
use IlluminateHttpRequest;
use AppHttpRequestsRegisterAuthRequest;
use TymonJWTAuthExceptionsJWTException;
use SymfonyComponentHttpFoundationResponse;
use Illuminate\Support\Facades\Hash;

class   AuthController extends Controller
{
    public function logout(Request $request)
    {
        $user = Supplier::find(supplier_parent());
        if ($user) {
            $user->device_token = null;
            $user->save();
        }
        auth('suppliers-api')->logout(true);
        return response()->json(msgdata($request, token_expired(), 'unauthrized', (object)[]));

    }

    public function unauthrized(Request $request)
    {

        return response()->json(msgdata($request, token_expired(), 'unauthrized', null));

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
        $count = Supplier::where('phone', $request->phone)->count();
        $input = $request->only('phone', 'password');
        $jwt_token = null;
        if ($count == 0) {
            return response()->json(msgdata($request, error(), 'phone_wrong', (object)[]));
        } elseif( Supplier::where('phone', $request->phone)->where('is_active',1)->count() == 0 ) {
            return response()->json(msgdata($request, error(), 'not_active', (object)[]));
        }elseif (!$jwt_token = auth('suppliers-api')->attempt($input,['exp' => Carbon::now()->addDays(7)->timestamp])) {
            return response()->json(msgdata($request, error(), 'password_wrong', (object)[]));
        } else {
            $user = Auth::guard('suppliers-api')->user();
            $user->device_token = $request->device_token;
            $user->save();
            $user->token = $jwt_token;

            return response()->json(msgdata($request, success(), 'success', $user));

        }
    }

    public function Register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/|unique:suppliers,phone',
            'password' => 'required',
            'address' => 'required|string',
            'attachments' => 'required',
            'attachments.*' => 'required|mimes:jpg,jpeg,png,gif,bmp,pdf,doc,docx',
            'branch_name' => 'required|string',
            'branch_email' => 'required|email|unique:suppliers,email|different:email',
            'branch_phone' => 'required|min:12|regex:/(966)[0-9]{8}/|unique:suppliers,phone|different:phone',
            'branch_password' => 'required',
            'branch_address' => 'required|string',
            'category' => 'required|exists:main_categories,id',
            'lat' => 'required',
            'lng' => 'required',
            'desc' => '',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $category = MainCategory::whereIn('id',$request->category)->pluck('name_ar');
        $supplier_manager = new Supplier();
        $supplier_manager->name = $request->name;
        $supplier_manager->email = $request->email;
        $supplier_manager->phone = $request->phone;
        $supplier_manager->address = $request->address;
        $supplier_manager->type = "Manager";
        $supplier_manager->password =  $request->password;
        $supplier_manager->is_active = 0;
        $supplier_manager->lat = $request->lat;
        $supplier_manager->lng = $request->lng;
        $supplier_manager->categories = implode(" - ", $category->toArray());
        $supplier_manager->save();

        $supplier_branch = new Supplier();
        $supplier_branch->name = $request->branch_name;
        $supplier_branch->email = $request->branch_email;
        $supplier_branch->phone = $request->branch_phone;
        $supplier_branch->password =  $request->branch_password ;
        $supplier_branch->address = $request->branch_address;
        $supplier_branch->type = "Employee";
        $supplier_branch->parent_id = $supplier_manager->id;
        $supplier_branch->is_active = 0;
        $supplier_branch->lat = $request->lat;
        $supplier_branch->lng = $request->lng;
        $supplier_branch->save();


        $inbox = new Inbox();

        $inbox->message = " تم ارسال طلب تسجيل مورد جديد يعمل فى  " . implode(" - ", $category->toArray()) . "<br>" . $request->desc;
        $inbox->receiver_id = Admin::first()->id;
        $inbox->receiver_type = "admin";
        $inbox->type = "notification";
        $inbox->sender_id = $supplier_manager->id;
        $inbox->sender_type = "supplier";
        $inbox->supplier_id = $supplier_manager->id;
        $inbox->save();
        foreach(Product::whereIn('main_category_id',$request->category)->get() as $item){
            $supplierProducts = new SupplierProduct();
            $supplierProducts->supplier_id=$supplier_branch->id;
            $supplierProducts->product_id = $item->id;
            $supplierProducts->status = 0;
            $supplierProducts->save();
        }
        foreach ($request->attachments as $attachment) {
            Attachment::create([
                'file' => $attachment,
                'supplier_id' => $supplier_manager->id
            ]);
        }


        return response()->json(msgdata($request, success(), 'registers_success', (object)[]));


    }


    public function forget_pass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:12',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        if (Supplier::where('phone', $request->phone)->count() > 0) {
            $User = Supplier::where('phone', $request->phone)->first();
            ForgetPass::where('supplier_id', $User->id)->delete();
            $data = new ForgetPass();
            $data->supplier_id = $User->id;
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
            'supplier_id' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }
        $User = Supplier::find($request->supplier_id);
        $User->password =  $request->password ;
        $User->save();
        ForgetPass::where('supplier_id', $request->supplier_id)->delete();
        return response()->json(msgdata($request, success(), 'success', $User));


    }

    public function confirm_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        if (ForgetPass::where('supplier_id', $request->supplier_id)->where('code', $request->code)->count() > 0) {
            $User = Supplier::find($request->supplier_id);
            return response()->json(msgdata($request, success(), 'success', $User));
        } else {
            return response()->json(msgdata($request, error(), 'code_expire', (object)[]));

        }
    }

    public function Profile()
    {
        $User = Supplier::find(supplier_parent_api());

        return response()->json(msgdata($User, success(), 'success', $User));

    }


    public function Update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'min:12||regex:/(966)[0-9]{8}/',
            'name' => 'required',
            'supplier_id' => 'required|exists:suppliers,id',
            'lng' => 'required',
            'lat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = Supplier::find($request->supplier_id);
        $data->name = $request->name;
        if (isset($request->phone)) {
            $data->phone = $request->phone;
        }
        if (isset($request->lng)) {
            $data->lng = $request->lng;
        }
        if (isset($request->lat)) {
            $data->lat = $request->lat;
        }
        if (isset($request->image)) {
            $data->image = $request->image;
        }
        if (isset($request->email)) {
            $data->email = $request->email;
        }
        if (isset($request->password)) {
            $data->password =  $request->password ;
        }
        $data->save();


        return response()->json(msgdata($request, success(), 'success', $data));


    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'min:12||regex:/(966)[0-9]{8}/|unique:suppliers',
            'name' => 'required|string',
            'email' => 'string|email|unique:suppliers',
            'password' => 'required|string',
            'address' => 'required|string',
            'lng' => 'required',
            'lat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $User = new Supplier;
        $User->name = $request->name;
        $User->phone = $request->phone;
        $User->email = $request->email;
        $User->address = $request->address;
        $User->type = "Manager";
        $User->password = $request->password;
        $User->lat = $request->lat;
        $User->lng = $request->lng;

        if ($request->file('image')) {
            $User->image = $request->image;
        }

        try {
            $User->save();
            $input = $request->only('phone', 'password');
            $jwt_token = auth('suppliers-api')->attempt($input);
            $User->token = $jwt_token;


        } catch (Exception $e) {
            return response()->json(msgdata($request, error(), 'error', (object)[]));
        }
        return response()->json(msgdata($request, success(), 'success', $User));

    }

}
