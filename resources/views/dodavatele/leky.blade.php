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
				@if (\Auth::user()->isAdmin())
				<th>Akce</th>
				@endif
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Název léku</th>
				<th>Cena</th>
				@if (\Auth::user()->isAdmin())
				<th>Akce</th>
				@endif
			</tr>
		</tfoot>
		<tbody>
			@foreach($leky as $lek)
			<tr>
				<td>{{ $lek->id_leku }}</td>
				<td>{{ $lek->nazev }}</td>
				<td>{{ $lek->cena }}</td>
				@if (\Auth::user()->isAdmin())
				<td class="text-center">
					{{-- <a href="{{ route('leky.edit', $lek->id_leku) }}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>
					<a href="{{ route('leky.confirmDelete', $lek->id_leku) }}" class="btn btn-primary">
						<span class="pficon-delete"></span>
					</a>
					<a href="{{ route('naskladnit-lek-form', $lek->id_leku) }}" class="btn btn-primary">
						<span class="fa fa-arrow-right"></span>
						<span class="fa fa-hospital-o"></span>
					</a> --}}
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
   		null,
   		{ "bSortable": false }
   		] } );
   	}
   	else{
   		$('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		null
   		] } );
   	}
   } );
</script>

@endsection