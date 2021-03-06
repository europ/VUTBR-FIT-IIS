@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Přidání nové pojištovny</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('poistovny.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nazev_pojistovny') ? ' has-error' : '' }}">
                            <label for="nazev_pojistovny" class="col-md-4 control-label">Název pojištovny <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="nazev_pojistovny" type="text" class="form-control" name="nazev_pojistovny" value="{{ old('nazev_pojistovny') }}" required autofocus>

                                @if ($errors->has('nazev_pojistovny'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nazev_pojistovny') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Vytvořit pojišťovnu
                                </button>
                                <a class="btn btn-default" href="{{ route('poistovny.index') }}">
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
