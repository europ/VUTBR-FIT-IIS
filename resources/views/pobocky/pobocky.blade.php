@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Pobočky
			</h1>
		</div>
		<div class="col-md-3 text-right">
			@if (\Auth::user()->isAdmin())
			<a href="{{route('pobocky.create')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Přidat pobočku
			</a>
			@endif
		</div>
	</div>

	@include('alerts.status')
	
	<!-- Table HTML -->
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Název pobočky</th>
				<th>Adresa</th>
				<th>Akce</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Název pobočky</th>
				<th>Adresa</th>
				<th>Akce</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($pobocky as $pobocka)
			<tr>
				<td>{{ $pobocka->id_pobocky }}</td>
				<td>{{ $pobocka->nazev_pobocky }}</td>
				<td>{{ $pobocka->adresa_ulice . " " . $pobocka->adresa_cislo . ", " . $pobocka->adresa_psc . " " . $pobocka->adresa_mesto }}</td>
				<td class="text-center">
					
				@if (\Auth::user()->isAdmin())
					<a href="{{route('pobocky.edit', $pobocka->id_pobocky)}}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>

					<a href="{{route('pobocky.confirmDelete', $pobocka->id_pobocky)}}" class="btn btn-primary">
						<span class="pficon-delete"></span>
					</a>
				@endif

					<a href="{{route('pobocky.show', $pobocka->id_pobocky)}}" class="btn btn-primary">
						<span class="fa fa-eye"></span>
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


	//check if logged in user is admin
	var admin = "{{{ (Auth::user()->isAdmin()) ? Auth::user()->isAdmin() : null }}}";

   // Using aoColumns
   $(document).ready( function() {
   	if(admin){
   		 $('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		null,
   		{ "bSortable": false }
   		] } );
   	}
   	else{
   		$('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		null,
   		{ "bSortable": false }
   		] } );
   	}

   } );
</script>

@endsection