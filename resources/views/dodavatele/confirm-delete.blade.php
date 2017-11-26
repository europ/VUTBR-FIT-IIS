@extends('layouts.app')

@section('content')
<div class="col-md-12">
	
	<h1>Smazat dodavatele</h1>
	<p>Určitě si přejete smazat dodavatele <b>{{$dodavatel->nazev}}</b>?</p>
	<form class="form-inline" method="POST" action="{{ route('dodavatele.destroy', $dodavatel->id_dodavatele) }}">
		{{ csrf_field() }}
		{{method_field('DELETE')}}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('dodavatele.index')}}" role="button">Vrátit se zpět</a>
	</form>

</div>
@endsection
