@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Přidaní rezervace</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('rezervace.store')}}">
                       
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('jmeno_zakaznika') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Jméno zákazníka <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <input id="jmeno_zakaznika" type="text" class="form-control" name="jmeno_zakaznika" value="{{ old('jmeno_zakaznika') }}" required autofocus>

                                @if ($errors->has('jmeno_zakaznika'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('jmeno_zakaznika') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="leky" class="col-md-4 control-label">Léky <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <select class="selectpicker" name="leky[]" multiple  id="" title="Vyberťe léky">

                                    @foreach ($leky as $lek)
                                    <option value="{{ $lek->id_leku }}">{{$lek->nazev}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('leky'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('leky') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" >
                                    Vytvoriť rezervace
                                </button>
                                <a class="btn btn-default" href="{{ route('rezervace.index') }}">
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
