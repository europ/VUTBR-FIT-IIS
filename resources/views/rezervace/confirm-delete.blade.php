@extends('layouts.app')

@section('content')

<div class="col-md-12">
	
	<h1>Smazat rezervaci</h1>

	<p>Určitě si přejete smazat rezervaci?</p>

	<table class="table">

		<thead>
			<tr>
				<th>ID</th>
				<th>Jméno</th>
				<th>Datum vytvoření</th>
				<th>Datum úpravy</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{$rezervace->id_rezervace}}</td>
				<td>{{$rezervace->jmeno_zakaznika}}</td>
				<td>{{$rezervace->created_at}}</td>
				<td>{{$rezervace->updated_at}}</td>
			</tr>
		</tbody>

	  </table>

	<form class="form-inline" method="POST" action="{{ route('rezervace.destroy', $rezervace->id_rezervace) }}">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('rezervace.index')}}" role="button">Vrátit se zpět</a>
	</form>

</div>

@endsection
