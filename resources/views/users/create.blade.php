@extends('layouts.master')
@section('title')
Creación de usuario
@endsection
@section('content')
	<a href="/users" class="btn btn-primary">Inicio</a>
	<h1>Crear nuevo usuario</h1>
	<form action="{{ route('user.store') }}" method="POST">
		@csrf
		<input type="hidden" class="form-control" id="txtId" name="txtId" value="">
		<div class="form-row">
			<label for="txtNombre">Nombre</label>
			<input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre completo">
		</div>
		<div class="form-row">
			<label for="txtNacimiento">Fecha de Nacimiento</label>
			<input type="date" class="form-control" id="txtNacimiento" name="txtNacimiento" value="{{ $now }}" placeholder="Fecha de Nacimiento">
		</div>
		<div class="form-row">
			<label for="txtCedula">Cédula</label>
			<input type="text" class="form-control" maxlength="11" id="txtCedula" name="txtCedula" placeholder="Cédula">
		</div>
		<div class="form-row">
			<label for="txtTelefono">Teléfono</label>
			<input type="text" class="form-control" maxlength="10" id="txtTelefono" name="txtTelefono" placeholder="Teléfono">
		</div>
		<div class="form-row">
			<label for="txtEmail">Email</label>
			<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Email">
		</div>
		<div class="form-row">
			<label for="txtPassword">Password</label>
			<input type="password" minlength="8" maxlength="15" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password">
		</div>
		<div class="form-row">
			<label for="txtPassword2">Confirmación de password*</label>
			<input type="password" minlength="8" maxlength="15" required class="form-control" id="txtPassword2" name="txtPassword2" placeholder="Confirmar Password">
		</div>
		<div class="form-row">
			<label for="txtPais">País</label>
			<select class="form-control" id="txtPais" name="txtPais">
				@empty($countries)
					<option value="null" selected>Seleccione</option>
				@else
					<option value="null">Seleccione</option>
					@foreach($countries as $country)
						<option value="{{ $country->id }}">{{ $country->nombre }}</option>
					@endforeach
				@endempty
			</select>
		</div>
		<div class="form-row">
			<label for="txtEstado">Estado</label>
			<select class="form-control" id="txtEstado" name="txtEstado">
				<option value="null">Seleccione</option>
			</select>
		</div>
		<div class="form-row">
			<label for="txtCiudad">Ciudad</label>
			<select class="form-control" id="txtCiudad" name="txtCiudad">
				<option value="null">Seleccione</option>
			</select>
		</div><br>
		<button id="submit" type="submit" class="btn btn-primary">Guardar</button>
	</form>
	<script type="text/javascript">
		$('#submit').click(function (){
			var success = true;
			if($('#txtPassword').val() != $('#txtPassword2').val()){
				alert('La confirmación de password no coincide');
				$('#txtPassword').val('');
				$('#txtPassword2').val('');
				$('#txtPassword').focus();
				return false;
			}
			$.ajax({
				async: false,
				type: 'POST',
				url: '../users/store/validation',
				data: {
					"_token": "{{ csrf_token() }}",
					"txtId": $('#txtId').val(),
					"txtEmail": $('#txtEmail').val(),
					"txtPassword": $('#txtEmail').val(),
					"txtNacimiento": $('#txtNacimiento').val(),
				},
			}).done(function (response){
				console.log(response);
				var data = JSON.parse(response);
				if(data.error == true){
					alert(data.message)
					$('#'+data.field).focus();
					success = false;
				}
			});
			if(success === false)
				return false;
		});
		$('#txtPais').change(function(){
			var url = '../../state/'+$('#txtPais option:selected').val();
			$.ajax({
				type: 'GET',
				url: url,
			}).done(function (response){
				console.log(response);
				var states = JSON.parse(response);
				$('#txtEstado option').remove();
				$('#txtCiudad option').remove();
				$('#txtCiudad').append(new Option('Seleccione', 'null', true))
				$('#txtEstado').append(new Option('Seleccione', 'null', true))
				states.forEach(function(state) {
					$('#txtEstado').append(new Option(state.nombre, state.id))
				});
			});
		});
		$('#txtEstado').change(function(){
			var url = '../../city/'+$('#txtEstado option:selected').val();
			$.ajax({
				type: 'GET',
				url: url,
			}).done(function (response){
				console.log(response);
				var cities = JSON.parse(response);
				$('#txtCiudad option').remove();
				$('#txtCiudad').append(new Option('Seleccione', 'null', true))
				cities.forEach(function(city) {
					$('#txtCiudad').append(new Option(city.nombre, city.id))
				});
			});
		});
	</script>
@endsection