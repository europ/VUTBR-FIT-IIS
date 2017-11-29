@extends('layouts.app')

@section('content')

<div class="col-md-12">
	
	<h1>Smazat předpis</h1>

	<p>Určitě si přejete smazat předpis?</p>

	<table class="table">

		<thead>
			<tr>
				<th>ID predpisu</th>
				<th>Rodné číslo</th>
				<th>ID pojišťovny</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td>{{$predpis->id_predpisu}}</td>
				<td>{{$predpis->rodne_cislo}}</td>
				<td>{{$pojistovna->nazev_pojistovny}}</td>
			</tr>
		</tbody>

	  </table>

	<form class="form-inline" method="POST" action="{{ route('predpisy.destroy', $predpis->id_predpisu) }}">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('predpisy.index')}}" role="button">Vrátit se zpět</a>
	</form>

</div>

@endsection
