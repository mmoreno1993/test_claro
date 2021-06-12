<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
	function __construct()
	{
    	$this->response = [
    		'error' => false,
    		'field' => '',
    		'message' => '',
    	];
	}
    public function index()
    {
    	return view('users.list');
    }
    public function pagination()
    {
    	$rows = request()->length;
    	$currentPage = (request()->start / $rows)+1;
    	$search = ((request()->search['value'] == null)?'':request()->search['value']);
    	$order = 'id';
    	$orderDir = request()->order[0]['dir'];
    	switch (request()->order[0]['column']) {
    		case 0:
    			$order = 'nombre';
    			break;
    		case 1:
    			$order = 'cedula';
    			break;
    		case 2:
    			$order = 'email';
    			break;
    		case 3:
    			$order = 'celular';
    			break;
    		case 4:
    			$order = 'age';
    			break;
    		default:
    			$order = 'id';
    			break;
    	}
    	$users = User::select('*', DB::raw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age"), DB::raw("
    			CONCAT('<a href=\"users/', id , '\"><span class=\"glyphicon glyphicon-pencil\"></span></a> ',
    			'<a class=\"remove-confirm\" href=\"users/delete/', id , '\"><span class=\"glyphicon glyphicon-remove\"></span></a>'
    			) as action
    		"))
    		->where('deleted', 0)
			->where(function ($query) use ($search) {
			    $query->where('nombre', 'LIKE','%'.$search.'%')
		    		->OrWhere('cedula', 'LIKE','%'.$search.'%')
		    		->OrWhere('email', 'LIKE','%'.$search.'%')
		    		->OrWhere('celular', 'LIKE','%'.$search.'%');
			})
			->orderBy($order, $orderDir)
    		->skip(($currentPage-1)*$rows)->take($rows)->get();
    	$quantity = User::where('deleted', 0)->get()->count();
    	$pages = $quantity / $rows;
    	$response = [
    		'draw' => request()->draw,
    		'recordsTotal' => $quantity,
    		'recordsFiltered' => (($search == '')?$quantity:$users->count()),
    		'data' => $users,
    	];
    	return json_encode($response);
    }
    public function create()
    {
    	$countries = Country::get();
    	return view('users.create')->with([
    		'now' => date('Y-m-d'),
    		'countries' => $countries,
    	]);
    }
    public function store()
    {
    	User::create([
	        'nombre' => request()->txtNombre,
	        'email' => request()->txtEmail,
	        'cedula' => request()->txtCedula,
	        'email_verified_at' => now(),
	        'password' => request()->txtPassword,
	        'celular' => request()->txtTelefono, 
	        'birthdate' => request()->txtNacimiento, 
	        'city_id' => request()->txtCiudad, 
	        'deleted' => 0,
    	]);
    	return redirect()->route('user.list');
    }
    public function storeValidation()
    {
    	if(request()->txtNacimiento == null)
    	{
			$this->response['field'] = 'txtNacimiento';
    		$this->response['message'] = 'La fecha ingresada no es válida';
    		$this->response['error'] = true;
    		return json_encode($this->response);
    	}
    	$array_date = explode('-', request()->txtNacimiento);
    	if(!checkdate(@$array_date[1], @$array_date[2], @$array_date[0]))
    	{
			$this->response['field'] = 'txtNacimiento';
    		$this->response['message'] = 'La fecha ingresada no es válida';
    		$this->response['error'] = true;
    		return json_encode($this->response);
    	}
		$diff = date_diff(date_create(request()->txtNacimiento), date_create(date('Y-m-d H:i:s')));
		$age = $diff->format('%y');
    	if($age < 18)
    	{
    		$this->response['field'] = 'txtNacimiento';
    		$this->response['message'] = 'Debe ser mayor de 18 años';
    		$this->response['error'] = true;
    		return json_encode($this->response);
    	}
    	if(strlen(request()->txtPassword) < 8)
    	{
    		$this->response['field'] = 'txtPassword';
    		$this->response['message'] = 'El password debe ser minimo de 8 carácteres';
    		$this->response['error'] = true;
    		return json_encode($this->response);
    	}
    	$user = User::where('deleted', 0)
    		->where('email', request()->txtEmail)
    		->where('id', '<>' , request()->txtId)
    		->first();
    	if(!empty($user)){
    		$this->response['field'] = 'txtEmail';
    		$this->response['message'] = 'El email se encuentra en uso';
    		$this->response['error'] = true;
    		return json_encode($this->response);
    	}
    	return json_encode($this->response);
    }
    public function storeUpdate()
    {
    	$user = User::findOrFail(request()->txtId);
    	Log::info('User before :'.json_encode($user));
    	if(empty($user))
    		return redirect()->route('user.list');
    	$user['nombre'] = request()->txtNombre;
	    $user['password'] = md5(request()->txtPassword);
	    $user['celular'] = request()->txtTelefono;
	    $user['city_id'] = request()->txtCiudad;
    	$user->save();
    	Log::info('User after :'.json_encode($user));
    	return redirect()->route('user.list');
    }
    public function update($user)
    {
    	$users = User::where('users.id', $user)
    		->leftJoin('cities', 'cities.id', '=', 'users.city_id')
    		->leftJoin('states', 'states.id', '=', 'cities.state_id')
    		->leftJoin('countries', 'countries.id', '=', 'states.country_id')
    		->select('users.id', DB::raw("DATE_FORMAT(users.birthdate, '%d/%m/%Y') as birthdate"), 'users.nombre', 'users.email', 'users.cedula', 'users.email_verified_at', 'users.password', 'users.celular', 'states.country_id', 'cities.state_id', 'users.city_id')
    		->first();
    	$countries = Country::get();
    	return view('users.update')->with([
    		'now' => date('d/m/Y'),
    		'user' => $users,
    		'countries' => $countries,
    	]);
    }
    public function delete($user)
    {
    	$user = User::findOrFail($user);
    	if(empty($user))
    		return redirect()->route('user.list');
    	$user['deleted'] = 1;
    	$user->save();
    	return redirect()->route('user.list');
    }
    public function login()
    {
    	if(!isset(request()->_token))
    		return view('login');
    	$user = User::where('email', request()->username)
    		->where('deleted', 0)
    		->first();
    	if(empty($user))
    		return view('login');
    	//if($user->password != md5(request()->password))
    		//return view('login');
    	Session::put('token', 'fdsafdhasfkjdashdkjashfkjas');
    	Session::put('user_id', $user->id);
    	return redirect()->route('user.profile');
    }
    public function profile()
    {
    	$user = User::where('id', Session::get('user_id'))
    		->select('*', DB::raw("TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS age"))->first();
    	return view('users.profile')->with([
    		'user' => $user,
    	]);
    }
    public function logout()
    {
    	Session::forget('token');
    	Session::forget('user_id');
    	return redirect()->route('user.profile');
    }
}
