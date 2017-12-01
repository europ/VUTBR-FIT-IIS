@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                
                <div class="panel-heading">Výdej léku {{$lek->nazev}}</div>
                <div class="panel-body">
                
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('leky.vydat', $lek->id_leku) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('mnozstvi') ? ' has-error' : '' }}">
                            <label for="mnozstvi" class="col-md-4 control-label">Vydávané množství</label>

                            <div class="col-md-6">
                                <input id="mnozstvi" type="number" class="form-control" name="mnozstvi" value="{{ old('mnozstvi') }}" min="1" max="{{$max}}" required autofocus>

                                @if ($errors->has('mnozstvi'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mnozstvi') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Vydat lék
                                </button>
                                @include('parts.backButton')
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
