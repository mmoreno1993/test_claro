@extends('layouts.master')
@section('title')
Listado de usuarios
@endsection
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<a href="/" class="btn btn-info">Login</a><br>
	<a href="/users/create" class="btn btn-primary">Nuevo Usuario</a>
	<h1>Lista de usuarios</h1>
		<div class="table-responsive">
			<table id="table-responsive" class="display" style="width:100%">
				<thead class ="thead-light">
					<tr>
						<th>Nombre</th>
						<th>Cédula</th>
						<th>Email</th>
						<th>Celular</th>
						<th>Edad</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					
					<tr>
						
					</tr>
					
				</tbody>
			</table>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#table-responsive').DataTable({
					"destroy": true,
			        "processing": true,
			        "serverSide": true,
			        "timeout": 1500,
			        "ajax": {
			            "url": "users/pagination",
			            "data": {
				        "_token": "{{ csrf_token() }}"
				        },
			            "type": "POST"
			        },
			        //"order": [[ 3, "desc" ]],
			        "columns": [
			            { "data": "nombre" },
			            { "data": "cedula" },
			            { "data": "email" },
			            { "data": "celular" },
			            { "data": "age" },
			            { "data": "action" },
			        ],
			        "oLanguage": {
						"sSearch": "Busqueda(Nombre, Cédula, Email, Celular):"
					}
			    });
			});
		</script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
@endsection