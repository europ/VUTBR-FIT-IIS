@extends('layouts.app')

@section('content')
<div class="col-md-12">
	
	<h1>Smazat lék</h1>
	<p>Určitě si přejete smazat lék <b>{{$lek->nazev}}</b>?</p>
	<form class="form-inline" method="POST" action="{{ route('leky.destroy', $lek->id_leku) }}">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('leky')}}" role="button">Vrátit se zpět</a>
	</form>

</div>
@endsection
