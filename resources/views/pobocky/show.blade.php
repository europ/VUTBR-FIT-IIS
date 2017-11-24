@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<h1>
			Pobočka {{$pobocka->nazev_pobocky}}
		</h1>
	</div>

	<!-- Table HTML -->
	<div class="row">
		<h2>Léky</h2>
	</div>
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Název léku</th>
				<th>Cena</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Název léku</th>
				<th>Cena</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($leky as $lek)
			<tr>
				<td>{{ $lek->id_leku }}</td>
				<td>{{ $lek->nazev }}</td>
				<td>{{ $lek->cena }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<!-- Table HTML -->
	<div class="row">
		<h2>Zaměstnanci</h2>
	</div>
	<!-- Table HTML -->
	<table id="example2" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Name</th>
				<th>Email</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($zamestnanci as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				
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
	   	
	   } );



   // Using aoColumns
   $(document).ready( function() {
   	$('#example').dataTable( {
   		"aoColumnDefs": [ 
   		{ "bSortable": false, "aTargets": [ 0 ] }
   		] } );

   	$('#example2').dataTable( {
   		"aoColumnDefs": [ 
   		{ "bSortable": false, "aTargets": [ 0 ] }
   		] } );


   	$('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		null
   		] } );
   	
   	$('#example2').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		] } );

   } );
</script>

@endsection