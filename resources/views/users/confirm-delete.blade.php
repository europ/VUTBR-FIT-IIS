@extends('layouts.app')

@section('content')
<div class="col-md-12">
	
	<h1>Užívatele</h1>
	<p>Určitě si přejete smazat užívatela <b>{{$user->name}}</b> s e-mail adresou <b>{{$user->email}}</b>?</p>
	<form class="form-inline" method="POST" action="{{ route('users.destroy', $user->id) }}">
		{{method_field('DELETE')}}
		{{ csrf_field() }}
		<button class="btn btn-danger" type="submit">Smazat</button>
		<a class="btn btn-success" href="{{route('users')}}" role="button">Vrátit se zpět</a>
	</form>

</div>
@endsection
