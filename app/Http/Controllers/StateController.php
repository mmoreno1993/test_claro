<?php

namespace App\Http\Controllers;
use App\Models\State;
class StateController extends Controller
{
    public function index($country)
    {
    	$states = State::where('country_id', $country)->get();
    	return json_encode($states);
    }
}
