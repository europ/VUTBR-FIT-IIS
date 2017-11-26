@extends('layouts.app')

@section('content')
<div class="col-md-12">
	
	<h1>Smazat pobočku</h1>
	<p>Určitě si přejete smazat pobočku <b>{{$pobocka->nazev_pobocky}}</b>?</p>
	<form class="form-inline" method="POST" action="{{ route('pobocky.destroy', $pobocka->id_pobocky) }}">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('pobocky.index')}}" role="button">Vrátit se zpět</a>
	</form>

</div>
@endsection
