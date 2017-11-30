@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Užívatelé
			</h1>
		</div>
		<div class="col-md-3 text-right">
			<a href="{{route('register')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Přidat uživatele
			</a>
		</div>
	</div>

	@include('alerts.status')

	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Správce</th>
				<th>Jméno</th>
				<th>Email</th>
				<th>Pobočka</th>
				<th>Dátum vytvorenia</th>
				<th>Dátum úpravy</th>
				<th>Akce</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Správce</th>
				<th>Jméno</th>
				<th>Email</th>
				<th>Pobočka</th>
				<th>Dátum vytvorenia</th>
				<th>Dátum úpravy</th>
				<th>Akce</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->admin == 1 ? "Ano" : "Ne" }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->pobocka == NULL ? "-" : $user->pobocka->nazev_pobocky}}</td>
				<td>{{ $user->created_at }}</td>
				<td>{{ $user->updated_at }}</td>
				<td class="text-center">
					<a href="{{route('user-edit', $user->id)}}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>
					<a href="{{route('users.confirmDelete', $user->id)}}" class="btn btn-primary">
						<span class="pficon-delete"></span>
					</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection

@section('scripts')

<script>
	   // Using aoColumnDefs
	   $(document).ready( function() {
	   	$('#example').dataTable( {
	   		"aoColumnDefs": [ 
	   		{ "bSortable": false, "aTargets": [ 0 ] }
	   		] } );
	   } );


   // Using aoColumns
   $(document).ready( function() {
   	$('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		null,
   		null,
   		null,
   		null,
   		null,
   		{ "bSortable": false }
   		] } );
   } );
</script>

@endsection