<?php

namespace App\Http\Controllers;
use App\Models\SendEmail;
use Illuminate\Support\Facades\Session;
class EmailController extends Controller
{
    public function index()
    {
    	$sendEmail = SendEmail::where('user_id', Session::get('user_id'))->get();
    	return view('emails.list')->with([
    		'now' => date('Y-m-d'),
    		'emails' => $sendEmail,
    	]);
    }
    public function create()
    {
    	$sendEmail = SendEmail::where('user_id', Session::get('user_id'))->get();
    	return view('emails.create')->with([
    		'now' => date('Y-m-d'),
    		'emails' => $sendEmail,
    	]);
    }
    public function store()
    {
    	SendEmail::create([
	    	'user_id' => Session::get('user_id'),
	        'subject' => request()->subject,
	        'to' => request()->to,
	        'body' => request()->body,
	        'sent' => 0,
    	]);
		return redirect()->route('email.list');
    }
}
