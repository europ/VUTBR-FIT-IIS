@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Změna předpisu č. <b>{{ $predpis->id_predpisu }}</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('predpisy.update', ['id' => $predpis->id_predpisu]) }}">
                       
                        {{ csrf_field() }}

                        <input name="_method" type="hidden" value="PATCH">

                        <div class="form-group{{ $errors->has('rodne_cislo') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Rodné číslo</label>

                            <div class="col-md-6">
                                <input id="rodne_cislo" type="text" class="form-control" name="rodne_cislo" value="{{ old('rodne_cislo', $predpis->rodne_cislo) }}" required autofocus>

                                @if ($errors->has('rodne_cislo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rodne_cislo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="pojistovna" class="col-md-4 control-label">Pojišťovna</label>
                            <div class="col-md-6">
                                <select name="pojistovna" id="">
                                    <option value="none">Žádná</option>
                                    @foreach ($pojistovny as $pojistovna)
                                    <option value="{{ $pojistovna->id_pojistovny }}">{{$pojistovna->nazev_pojistovny}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pojistovna'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pojistovna') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" >
                                    Upraviť předpis
                                </button>
                                <a class="btn btn-default" href="{{ route('predpisy.index') }}">
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
