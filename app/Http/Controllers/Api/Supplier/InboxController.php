<?php

namespace App\Http\Controllers\Api\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Admin;
use App\Models\Inbox;
use App\Models\InboxFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InboxController extends Controller
{
    public function index(Request $request)
    {

        $Users = Inbox::
//            where('sender_id', Auth::user()->id)->
            orWhere('receiver_id', supplier_parent_api())
            ->OrderBy('id', 'desc')
            ->with('order')
            ->root()
            ->paginate(10);

        foreach ($Users as $user) {
            if ($user->sender_type == "admin") {
                $sender = Admin::whereId($user->sender_id)->select('id', 'name')->first();
            } elseif ($user->sender_type == "user") {
                $sender = User::whereId($user->sender_id)->select('id', 'name')->first();
            } else {
                $sender = Supplier::whereId($user->sender_id)->select('id', 'name')->first();
            }

            $user->sender = $sender;

            if ($user->receiver_type == "admin") {
                $receiver = Admin::whereId($user->receiver_id)->select('id', 'name')->first();
            } elseif ($user->receiver_type == "user") {
                $receiver = User::whereId($user->receiver_id)->select('id', 'name')->first();
            } else {
                $receiver = Supplier::whereId($user->receiver_id)->select('id', 'name')->first();
            }

            $user->reciever = $receiver;
        }


        return response()->json(msgdata($request, success(), 'success', $Users));

    }

    public function Replies(Request $request, $id)
    {
        $Users = Inbox::whereId($id)->with('childreninboxes')->with('order')->first();
        if ($Users->receiver_type == "admin") {
            $receiver = Admin::whereId($Users->receiver_id)->select('id', 'name')->first();
        } elseif ($Users->receiver_type == "user") {
            $receiver = User::whereId($Users->receiver_id)->select('id', 'name')->first();
        } else {
            $receiver = Supplier::whereId($Users->receiver_id)->select('id', 'name')->first();
        }

        if ($Users->sender_type == "admin") {
            $sender = Admin::whereId($Users->sender_id)->select('id', 'name')->first();
        } elseif ($Users->sender_type == "user") {
            $sender = User::whereId($Users->sender_id)->select('id', 'name')->first();
        } else {
            $sender = Supplier::whereId($Users->sender_id)->select('id', 'name')->first();
        }

        if (Auth::user()->id == $Users->receiver_id) {
            $Users->is_read = 1;
            $Users->save();
        }


        $Users->sender = $sender;
        $Users->receiver = $receiver;

        foreach ($Users->childreninboxes as $child) {
            if ($child->receiver_type == "admin") {
                $receiver = Admin::whereId($child->receiver_id)->select('id', 'name')->first();
            } elseif ($child->receiver_type == "user") {
                $receiver = User::whereId($child->receiver_id)->select('id', 'name')->first();
            } else {
                $receiver = Supplier::whereId($child->receiver_id)->select('id', 'name')->first();
            }

            if ($child->sender_type == "admin") {
                $sender = Admin::whereId($child->sender_id)->select('id', 'name')->first();
            } elseif ($child->sender_type == "user") {
                $sender = User::whereId($child->sender_id)->select('id', 'name')->first();
            } else {
                $sender = Supplier::whereId($child->sender_id)->select('id', 'name')->first();
            }

            $child->sender = $sender;
            $child->receiver = $receiver;

        }
        return response()->json(msgdata($request, success(), 'success', $Users));


    }

    public function getAdmin(Request $request)
    {
        $Users = Admin::first();
        return response()->json(msgdata($request, success(), 'success', $Users));
    }

    public function Search(Request $request)
    {
        $rules =
            [
                'search' => 'required|string',

            ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }

        $result = Inbox::
//        where('sender_id', Auth::user()->id)->
        orWhere('receiver_id', supplier_parent_api())
            ->where('message', 'LIKE', "%$request->search%")
            ->orderBy('id', 'desc')->with('order')->paginate(10);

        if ($result->count() == 0) {
            return response()->json(msgdata($request, error(), 'nodata', (object)[]));
        }
        return response()->json(msgdata($request, success(), 'success', $result));
    }

    public function Read(Request $request, $id){
        $Users = Inbox::whereId($id)->with('order')->first();
        if (supplier_parent_api() == $Users->receiver_id) {
            $Users->is_read = 1;
            $Users->save();
        }
        return response()->json(msgdata($request, success(), 'success', $Users));
    }

    public function store(Request $request)
    {
        $rules =
            [
                'message' => 'required|string',
                'file' => 'sometimes|array',
                'file.*' => 'mimes:jpg,jpeg,png,gif,bmp,pdf,doc,docx',
                'receiver_id' => 'required|exists:admins,id',

            ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }

        $inbox = new Inbox();
        $inbox->message = $request->message;
        $inbox->receiver_id = $request->receiver_id;
        $inbox->receiver_type = $request->receiver_type;
        $inbox->sender_id = supplier_parent_api();
        $inbox->sender_type = "supplier";
        $inbox->receiver_type = "admin";


        $inbox->save();
        try {
            $inbox->save();

        } catch (\Exception $e) {

            return response()->json(msgdata($request, error(), 'error', $e));
        }

        if ($request->file != null) {
            foreach ($request->file as $file) {
                InboxFile::create([
                    'inbox_id' => $inbox->id,
                    'file' => $file
                ]);
            }
        }
        return response()->json(msgdata($request, success(), 'success', $inbox));
    }

    public function StoreReply(Request $request)
    {

        $rules =
            [
                'message' => 'required|string',
                'file' => 'sometimes|array',
                'file.*' => 'mimes:jpg,jpeg,png,gif,bmp,pdf,doc,docx',
                'inbox_id' => 'required|exists:inboxes,id'


            ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()
                ->first(), 'data' => (object)[]]);
        }

        $parent_inbox = Inbox::whereId($request->inbox_id)->first();

        if ($parent_inbox) {
            if ($parent_inbox->type != "notification") {
                $inbox = new Inbox();
                $inbox->message = $request->message;
                $inbox->inbox_id = $request->inbox_id;
                if ($parent_inbox->receiver_type == "user") {
                    $inbox->receiver_id = $parent_inbox->sender_id;
                    $inbox->receiver_type = $parent_inbox->sender_type;
                } else {
                    $inbox->receiver_id = $parent_inbox->receiver_id;
                    $inbox->receiver_type = $parent_inbox->receiver_type;
                }
                $inbox->sender_id = supplier_parent_api();
                $inbox->sender_type = "supplier";


                try {
                    $inbox->save();

                } catch (\Exception $e) {
                    return response()->json(msgdata($request, error(), 'error', (object)[]));
                }

                if ($request->file != null) {
                    foreach ($request->file as $file) {
                        InboxFile::create([
                            'inbox_id' => $inbox->id,
                            'file' => $file
                        ]);
                    }
                }

                return response()->json(msgdata($request, success(), 'success', $inbox));
            } else {
                return response()->json(msgdata($request, error(), 'error', (object)[]));

            }
        } else {
            return response()->json(msgdata($request, not_found(), 'not_found', (object)[]));
        }
    }


}
