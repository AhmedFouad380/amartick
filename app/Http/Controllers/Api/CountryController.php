<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function GetCities(Request $request){
        $data = Country::all();
        return response()->json(msgdata($request, success(), 'success', $data ));
    }

    public function  GetTowns(Request $request){
        $data = City::where('country_id',$request->city_id)->get();

        return response()->json(msgdata($request, success(), 'success', $data ));

    }
}
