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
			<a href="{{route('register')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Přidat pobočku
			</a>
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
				<th>Actions</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Název pobočky</th>
				<th>Adresa</th>
				<th>Actions</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($pobocky as $pobocka)
			<tr>
				<td>{{ $pobocka->id_pobocky }}</td>
				<td>{{ $pobocka->nazev_pobocky }}</td>
				<td>{{ $pobocka->adresa_ulice . " " . $pobocka->adresa_cislo . ", " . $pobocka->adresa_psc . " " . $pobocka->adresa_mesto }}</td>
				<td class="text-center">
					<a href="{{route('pobocky.edit', $pobocka->id_pobocky)}}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>
					<a href="{{route('pobocky.confirmDelete', $pobocka->id_pobocky)}}" class="btn btn-primary">
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