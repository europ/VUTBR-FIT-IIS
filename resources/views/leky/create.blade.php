@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                
                <div class="panel-heading">Přidání nového léku</b></div>
                <div class="panel-body">
                

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('leky.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nazev') ? ' has-error' : '' }}">
                            <label for="nazev" class="col-md-4 control-label">Název léku</label>
                            <div class="col-md-6">
                                <input id="nazev" type="text" class="form-control" name="nazev" value="{{ old('nazev') }}" required autofocus>

                                @if ($errors->has('nazev'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nazev') }}</strong>
                                </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cena') ? ' has-error' : '' }}">
                            <label for="cena" class="col-md-4 control-label">Cena</label>

                            <div class="col-md-6">
                                <input id="cena" type="text" class="form-control" name="cena" value="{{ old('cena') }}" required autofocus>

                                @if ($errors->has('cena'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cena') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Vložit lék
                                </button>
                                <a class="btn btn-default" href="{{ route('leky') }}">
                                    Zrušit
                                </a>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
