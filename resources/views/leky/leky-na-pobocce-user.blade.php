@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Léky na pobočce <strong>{{$pobocka->nazev_pobocky}}</strong>
			</h1>
		</div>
		{{-- <div class="col-md-3 text-right">
			<a href="{{route('register')}}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Vydat lék
			</a>
		</div> --}}
	</div>
	
	@include('alerts.status')

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
				<td>{{ $lek->pivot->mnozstvi }}</td>
				<td>{{ $lek->cena }} Kč</td>
				<td class="text-center">
					<a href="{{ route('vydat-lek-form', $lek->id_leku) }}" class="btn btn-primary">
						Vydat lék
						<span class="fa fa-arrow-right"></span>
						<span class="fa fa-user"></span>
					</a>
					<a href="{{ route('naskladnit-lek-user-form', ['id_leku' => $lek->id_leku,'id_pobocky' => $pobocka->id_pobocky]) }}" class="btn btn-primary">
						Naskladnit lék
						<span class="fa fa-arrow-right"></span>
						<span class="fa fa-hospital-o"></span>
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
   		null
   		] } );
   } );
</script>

@endsection