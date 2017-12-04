@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                
                <div class="panel-heading">Naskladnit lék <b>{{ $lek->nazev }}</b> na pobočce <b>{{ $pobocka->nazev_pobocky}}</b></div>
                <div class="panel-body">
                

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('naskladnit-lek-user', ['id_leku' => $lek->id_leku, 'id_pobocky' => $pobocka->id_pobocky]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('mnozstvi') ? ' has-error' : '' }}">
                            <label for="mnozstvi" class="col-md-4 control-label">Množství</label>

                            <div class="col-md-6">
                                <input id="mnozstvi" type="text" class="form-control" name="mnozstvi" value="{{ old('mnozstvi') }}" required autofocus>

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
                                    Naskladnit
                                </button>
                                <a class="btn btn-default" href="{{ route('leky-na-pobocce') }}">
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
