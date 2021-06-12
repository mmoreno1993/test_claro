@extends('layouts.master')
@section('title')
Creación de correo
@endsection
@section('content')
	<a href="/email" class="btn btn-primary">Inicio</a>
	<h1>Crear nuevo usuario</h1>
	<form action="{{ route('email.store') }}" method="POST">
		@csrf
		<div class="form-row">
			<label for="to">Para</label>
			<input type="email" class="form-control" id="to" name="to" placeholder="Correo">
		</div>
		<div class="form-row">
			<label for="subject">Titulo</label>
			<input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
		</div>
		<div class="form-row">
			<label for="body">Cuerpo</label>
			<input type="text" class="form-control" maxlength="1000" id="body" name="body" placeholder="body">
		</div>
		<button id="submit" type="submit" class="btn btn-primary">Guardar</button>
	</form>
@endsection