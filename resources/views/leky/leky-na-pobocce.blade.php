@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Léky na pobočce
			</h1>
		</div>
		<div class="col-md-3 text-right">
			<a href="{{route('register')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Přidat lék
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
				<th>Název léku</th>
				<th>Množství</th>
				<th>Cena</th>
				<th>Akce</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Název léku</th>
				<th>Množství</th>
				<th>Cena</th>
				<th>Akce</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($leky as $lek)
			<tr>
				<td>{{ $lek->id_leku }}</td>
				<td>{{ $lek->nazev }}</td>
				<td>{{ $lek->cena }} Kč</td>
				<td class="text-center">
					<a href="{{-- {{route('user-edit', $user->id)}} --}}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>
					<a href="{{-- {{route('users.confirmDelete', $user->id)}} --}}" class="btn btn-primary">
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
   		{ "bSortable": false }
   		] } );
   } );
</script>

@endsection