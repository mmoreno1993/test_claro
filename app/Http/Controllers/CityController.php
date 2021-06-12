<?php

namespace App\Http\Controllers;
use App\Models\City;
class CityController extends Controller
{
    public function index($state)
    {
    	$cities = City::where('state_id', $state)->get();
    	return json_encode($cities);
    }
}
