@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Přidání nové pobočky</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('pobocky.store') }}">
                        {{ csrf_field() }}

                        {{-- <input name="_method" type="hidden" value="PUT"> --}}

                        <div class="form-group{{ $errors->has('nazev_pobocky') ? ' has-error' : '' }}">
                            <label for="nazev_pobocky" class="col-md-4 control-label">Název pobočky</label>

                            <div class="col-md-6">
                                <input id="nazev_pobocky" type="text" class="form-control" name="nazev_pobocky" value="{{ old('nazev_pobocky') }}" required autofocus>

                                @if ($errors->has('nazev_pobocky'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nazev_pobocky') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-4 text-right">
                                <h2>Adresa</h2>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('adresa_ulice') ? ' has-error' : '' }}">
                            <label for="adresa_ulice" class="col-md-4 control-label">Ulice</label>

                            <div class="col-md-6">
                                <input id="adresa_ulice" type="text" class="form-control" name="adresa_ulice" value="{{ old('adresa_ulice') }}" required autofocus>

                                @if ($errors->has('adresa_ulice'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adresa_ulice') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('adresa_cislo') ? ' has-error' : '' }}">
                            <label for="adresa_cislo" class="col-md-4 control-label">Číslo ulice</label>

                            <div class="col-md-6">
                                <input id="adresa_cislo" type="text" class="form-control" name="adresa_cislo" value="{{ old('adresa_cislo') }}" required autofocus>

                                @if ($errors->has('adresa_cislo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adresa_cislo') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('adresa_mesto') ? ' has-error' : '' }}">
                            <label for="adresa_mesto" class="col-md-4 control-label">Město</label>

                            <div class="col-md-6">
                                <input id="adresa_mesto" type="text" class="form-control" name="adresa_mesto" value="{{ old('adresa_mesto') }}" required autofocus>

                                @if ($errors->has('adresa_mesto'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adresa_mesto') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('adresa_psc') ? ' has-error' : '' }}">
                            <label for="adresa_psc" class="col-md-4 control-label">PSČ</label>

                            <div class="col-md-6">
                                <input id="adresa_psc" type="text" class="form-control" name="adresa_psc" value="{{ old('adresa_psc') }}" required autofocus>

                                @if ($errors->has('adresa_psc'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('adresa_psc') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>                        

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Vytvořit pobočku
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
