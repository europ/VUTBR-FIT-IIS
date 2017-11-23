@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Pojištovny
			</h1>
		</div>
		<div class="col-md-3 text-right">
			@if (\Auth::user()->isAdmin())
			<a href="{{route('register')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Přidat pojištovňu
			</a>
			@endif
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
				<th>Název pojištovny</th>
				@if (\Auth::user()->isAdmin())
				<th>Akce</th>
				@endif
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Název pojištovny</th>
				@if (\Auth::user()->isAdmin())
				<th>Akce</th>
				@endif
			</tr>
		</tfoot>
		<tbody>
			@foreach($poistovny as $poistovna)
			<tr>
				<td>{{ $poistovna->id_pojistovny }}</td>
				<td>{{ $poistovna->nazev_pojistovny }}</td>
				@if (\Auth::user()->isAdmin())
				<td class="text-center">
					<a href="{{-- {{route('user-edit', $user->id)}} --}}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>
					<a href="{{-- {{route('users.confirmDelete', $user->id)}} --}}" class="btn btn-primary">
						<span class="pficon-delete"></span>
					</a>
				</td>
				@endif
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

	var admin = "{{{ (Auth::user()->isAdmin()) ? Auth::user()->isAdmin() : null }}}";


   // Using aoColumns
   $(document).ready( function() {
    if(admin){
   		 $('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		{ "bSortable": false }
   		] } );
   	}
   	else{
   		$('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null
   		] } );
   	}
   } );
</script>

@endsection