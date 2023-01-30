<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class EventsController extends Controller
{
    public function store(Request $request){

        $data = new Event;
        $data->user_id=Auth::user()->id;
        $data->date=$request->date;
        $data->time=$request->time;
        $data->title=$request->title;
        $data->description=$request->description;
        $data->save();

        return redirect()->back()->with('message', 'Success');

    }
}
