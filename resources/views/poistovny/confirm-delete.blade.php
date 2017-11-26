@extends('layouts.app')

@section('content')
<div class="col-md-12">
	
	<h1>Smazat pojišťovnu</h1>
	<p>Určitě si přejete smazat pojišťovnu <b>{{$poistovna->nazev_pojistovny}}</b>?</p>
	<form class="form-inline" method="POST" action="{{ route('poistovny.destroy', $poistovna->id_pojistovny) }}">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('poistovny.index')}}" role="button">Vrátit se zpět</a>
	</form>

</div>
@endsection
