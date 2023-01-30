<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\InboxFile;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Database\Transaction;
use Kreait\Firebase\Factory;
use Carbon\Carbon;

class InboxController extends Controller
{
    public function index()
    {

        if (Auth::guard('admins')->check()) {
            $Users = Inbox::Where('receiver_type', 'admin')->OrderBy('id', 'desc')
                ->root()->paginate(10);
        } else {
            $Users = Inbox::Where('receiver_type', 'supplier')
                ->Where('receiver_id', supplier_parent())->OrderBy('id', 'desc')
                ->root()->paginate(10);
        }

        return view('Admin.Inbox.index', compact('Users'));

    }

    public function outbox()
    {

        if (Auth::guard('admins')->check()) {
            $Users = Inbox::Where('sender_type', 'admin')->OrderBy('id', 'desc')
                ->root()->paginate(10);
        } else {
            $Users = Inbox::Where('sender_type', 'supplier')
                ->Where('sender_id', supplier_parent())->OrderBy('id', 'desc')
                ->root()->paginate(10);;
        }

        return view('Admin.Inbox.outbox', compact('Users'));

    }

    public function Replies($id)
    {
        $Users = Inbox::whereId($id)->with('childreninboxes')->first();
        if (Auth::guard('admins')->check() && $Users->receiver_type == "admin") {
            $Users->is_read = 1;
            $Users->save();
            $firebase = (new Factory)
                ->withServiceAccount(app_path('amartech-69196-firebase-adminsdk-q996n-4cb7b7513a.json'))
                ->withDatabaseUri('https://amartech-69196-default-rtdb.firebaseio.com/')
                ->createDatabase();
            $toBeDeleted = $firebase->getReference('amar/inboxes/' . $id);
            $firebase->runTransaction(function (Transaction $transaction) use ($toBeDeleted) {
                $transaction->snapshot($toBeDeleted);
                $transaction->remove($toBeDeleted);
            });
        } elseif (!Auth::guard('admins')->check() && $Users->receiver_type == "supplier") {
            $Users->is_read = 1;
            $Users->save();
            $firebase = (new Factory)
                ->withServiceAccount(app_path('amartech-69196-firebase-adminsdk-q996n-4cb7b7513a.json'))
                ->withDatabaseUri('https://amartech-69196-default-rtdb.firebaseio.com/')
                ->createDatabase();
            $toBeDeleted = $firebase->getReference('amar/inboxes/' . $id);
            $firebase->runTransaction(function (Transaction $transaction) use ($toBeDeleted) {
                $transaction->snapshot($toBeDeleted);
                $transaction->remove($toBeDeleted);
            });
        }





        return view('Admin.Inbox.replies', compact('Users'));

    }

    public function getUsers($type)
    {

        if ($type == "user") {
            $Users = User::all();
        } else {
            $Users = Supplier::all();
        }

        return response()->json(['users' => $Users]);
    }

    public function SingleInbox($id)
    {
        $data = Inbox::whereId($id)->first();
        if($data){

            if ($data->inbox_id !=null ){
                $Users = Inbox::whereId($data->inbox_id)->get();
            }else{
                $Users = Inbox::whereId($id)->get();
            }
            if (Auth::guard('admins')->check() && $data->receiver_type == "admin") {
                $data->is_read = 1;
                $data->save();
                $firebase = (new Factory)
                    ->withServiceAccount(app_path('amartech-69196-firebase-adminsdk-q996n-4cb7b7513a.json'))
                    ->withDatabaseUri('https://amartech-69196-default-rtdb.firebaseio.com/')
                    ->createDatabase();
                $toBeDeleted = $firebase->getReference('amar/inboxes/' . $id);
                $firebase->runTransaction(function (Transaction $transaction) use ($toBeDeleted) {
                    $transaction->snapshot($toBeDeleted);
                    $transaction->remove($toBeDeleted);
                });
            } elseif (!Auth::guard('admins')->check() && $data->receiver_type == "supplier") {
                $data->is_read = 1;
                $data->save();
                $firebase = (new Factory)
                    ->withServiceAccount(app_path('amartech-69196-firebase-adminsdk-q996n-4cb7b7513a.json'))
                    ->withDatabaseUri('https://amartech-69196-default-rtdb.firebaseio.com/')
                    ->createDatabase();
                $toBeDeleted = $firebase->getReference('amar/inboxes/' . $id);
                $firebase->runTransaction(function (Transaction $transaction) use ($toBeDeleted) {
                    $transaction->snapshot($toBeDeleted);
                    $transaction->remove($toBeDeleted);
                });
            }




            return view('Admin.Inbox.index', compact('Users'));
        }else{
            return back()->with('message', 'Failed');
        }

    }


    public function store(Request $request)
    {

        $this->validate(request(), [
            'message' => 'required|string',
            'file' => 'sometimes|array',
            'file.*' => 'mimes:jpg,jpeg,png,gif,bmp,pdf,doc,docx',
            'receiver_id' => 'required',
            'receiver_type' => 'required',
            'type' => 'required',

        ]);
        $inbox = new Inbox();
        $inbox->message = $request->message;
        $inbox->receiver_id = $request->receiver_id;
        $inbox->receiver_type = $request->receiver_type;
        $inbox->type = $request->type;
        if (Auth::guard('admins')->check()) {
            $inbox->sender_id = Auth::guard('admins')->user()->id;
            $inbox->sender_type = "admin";
        } else {
            $inbox->sender_id = Auth::guard('suppliers')->user()->id;
            $inbox->sender_type = "supplier";
        }
        $inbox->created_at=Carbon::now('Asia/Riyadh');
        $inbox->save();
        try {
            $inbox->save();

        } catch (\Exception $e) {
            return back()->with('message', 'Failed');
        }

        if ($request->file != null) {
            foreach ($request->file as $file) {
                InboxFile::create([
                    'inbox_id' => $inbox->id,
                    'file' => $file
                ]);
            }
        }

        return redirect()->back()->with('message', 'Success');
    }


    public function StoreReply(Request $request)
    {

        $this->validate(request(), [
            'message' => 'required|string',
            'file' => 'sometimes|array',
            'file.*' => 'mimes:jpg,jpeg,png,gif,bmp,pdf,doc,docx',


        ]);
        $parent_inbox = Inbox::whereId($request->inbox_id)->first();


        $inbox = new Inbox();
        $inbox->message = $request->message;
        $inbox->inbox_id = $request->inbox_id;

        if (Auth::guard('admins')->check()) {
            $inbox->sender_id = Auth::guard('admins')->user()->id;
            $inbox->sender_type = "admin";
            if ($parent_inbox->sender_type != "admin") {
                $inbox->receiver_id = $parent_inbox->sender_id;
                $inbox->receiver_type = $parent_inbox->sender_type;
            } else {
                $inbox->receiver_id = $parent_inbox->receiver_id;
                $inbox->receiver_type = $parent_inbox->receiver_type;
            }

        } else {
            $inbox->sender_id = Auth::guard('suppliers')->user()->id;
            $inbox->sender_type = "supplier";
            if ($parent_inbox->sender_type != "supplier") {
                $inbox->receiver_id = $parent_inbox->sender_id;
                $inbox->receiver_type = $parent_inbox->sender_type;
            } else {
                $inbox->receiver_id = $parent_inbox->receiver_id;
                $inbox->receiver_type = $parent_inbox->receiver_type;
            }
        }


        try {
            $inbox->save();

        } catch (\Exception $e) {
            return back()->with('message', 'error');
        }

        if ($request->file != null) {
            foreach ($request->file as $file) {
                InboxFile::create([
                    'inbox_id' => $inbox->id,
                    'file' => $file
                ]);
            }
        }

        return redirect()->back()->with('message', 'Success');
    }


}
