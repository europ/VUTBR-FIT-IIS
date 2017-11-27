@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Změna pojištovny</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('poistovny.update', ['id' => $poistovna->id_pojistovny]) }}">
                        {{ csrf_field() }}

                        <input name="_method" type="hidden" value="PATCH">

                        
                        <div class="form-group{{ $errors->has('nazev') ? ' has-error' : '' }}">
                            <label for="nazev" class="col-md-4 control-label">Název pojištovny</label>

                            <div class="col-md-6">
                                <input id="nazev_pojistovny" type="text" class="form-control" name="nazev_pojistovny" value="{{ old('nazev_pojistovny', $poistovna->nazev_pojistovny) }}" required autofocus>

                                @if ($errors->has('nazev'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nazev_pojistovny') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Upravit pojištovnu
                                </button>
                                <a class="btn btn-default" href="{{ route('poistovny.index') }}">
                                    Cancel
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

@section('scripts')
<script>



</script>
@endsection
