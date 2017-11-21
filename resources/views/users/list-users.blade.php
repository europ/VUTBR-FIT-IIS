@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Users
			</h1>
		</div>
		<div class="col-md-3 text-right">
			<a href="{{route('register')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Add user
			</a>
		</div>
	</div>
	@if (Session::has('status'))
	<div class="alert alert-success" role="alert">
		<span class="pficon pficon-error-circle-o"></span>
		{{Session::get('status')}}
	</div>
	@endif

	<!-- Table HTML -->
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Admin</th>
				<th>Name</th>
				<th>Email</th>
				<th>Pobočka</th>
				<th>Created at</th>
				<th>Updated at</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Admin</th>
				<th>Name</th>
				<th>Email</th>
				<th>Pobočka</th>
				<th>Created at</th>
				<th>Updated at</th>
				<th>Actions</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($users as $user)
			<tr>
				<td>{{ $user->id }}</td>
				<td>{{ $user->admin }}</td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->pobocka == NULL ? "-" : $user->pobocka->adresa_ulice}}</td>
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
   		{ "bSortable": false }
   		] } );
   } );
</script>

@endsection