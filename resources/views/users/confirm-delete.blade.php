@extends('layouts.app')

@section('content')
<div class="col-md-12">
	
	<h1>Users</h1>
	<p>Do you really want to delete user <b>{{$user->name}}</b> with email <b>{{$user->email}}</b>?</p>
	<form class="form-inline" method="POST" action="{{ route('users.destroy', $user->id) }}">
		{{method_field('DELETE')}}
		{{ csrf_field() }}
		<button class="btn btn-danger" type="submit">Delete</button>
		<a class="btn btn-success" href="{{route('users')}}" role="button">Cancel</a>
	</form>

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
   		{ "bSortable": false }
   		] } );
   } );
</script>

@endsection