@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Léky dodávané dodavatelem <b>{{ $dodavatel->nazev }}</b>
			</h1>
		</div>
	</div>

	@include('alerts.status')

	<!-- Table HTML -->
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
   		null
   		] } );
   } );
</script>

@endsection