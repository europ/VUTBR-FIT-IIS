@extends('layouts.app')

@section('content')
<div class="col-md-12">
	<div class="row">
		<div class="col-md-9">
			<h1>
				Rezervace
			</h1>
		</div>
		<div class="col-md-3 text-right">
			<a href="{{ route('rezervace.create') }}" class="btn btn-primary" style="margin-top: 20px;">
				<span class="pficon-add-circle-o"></span> Přidat rezervace
			</a>
		</div>
	</div>

	@include('alerts.status')

	<!-- Table HTML -->
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Jméno</th>
				<th>Datum vytvoření</th>
				<th>Datum úpravy</th>
				<th>Akce</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Jméno</th>
				<th>Datum vytvoření</th>
				<th>Datum úpravy</th>
				<th>Akce</th>
			</tr>
		</tfoot>
		<tbody>
			@foreach($rezervace as $rez)
			<tr>
				<td>{{ $rez->id_rezervace }}</td>
				<td>{{ $rez->jmeno_zakaznika }}</td>
				<td>{{ $rez->created_at }}</td>
				<td>{{ $rez->updated_at }}</td>
				<td class="text-center">
					<a href="{{ route('rezervace.edit', $rez->id_rezervace) }}" class="btn btn-primary">
						<span class="pficon-edit"></span>					
					</a>
					<a href="{{ route('rezervace.confirmDelete', $rez->id_rezervace) }}" class="btn btn-primary">
						<span class="pficon-delete"></span>
					</a>
	                <a href="{{ route('rezervace.show', $rez->id_rezervace) }}" class="btn btn-primary">
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


   // Using aoColumns
   $(document).ready( function() {
   	$('#example').dataTable( {
   		"aoColumns": [ 
   		null,
   		null,
   		null,
   		null,
   		{ "bSortable": false }
   		] } );
   } );
</script>

@endsection