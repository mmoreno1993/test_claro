@extends('layouts.master')
@section('title')
Lista de Emails
@endsection
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<a href="/profile" class="btn btn-info">Volver al perfil</a>
	<a href="/email/create" class="btn btn-primary">Nuevo Email</a>
    @empty ($emails)
        <div class="alert alert-warning">
            La lista de emails esta vacia
        </div>
    @else
	<h1>Lista de emails</h1>
		<div class="table-responsive">
			<table id="table-responsive" class="display" style="width:100%">
				<thead class ="thead-light">
					<tr>
						<th>Para</th>
						<th>Título</th>
						<th>Enviado</th>
					</tr>
				</thead>
				<tbody>
                    @foreach ($emails as $email)
                    <tr>
                        <td>{{ $email->to }}</td>
                        <td>{{ $email->subject }}</td>
                        <td>{{ (($email->sent == 1)?'Sí':'No') }}</td>
                    </tr>
                    @endforeach
				</tbody>
			</table>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#table-responsive').DataTable({
			        "oLanguage": {
						"sSearch": "Busqueda:"
					}
			    });
			});
		</script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
	@endempty
@endsection