@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Změna pojištovny</b></div>
                    <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('poistovny.update', $poistovna->id_dodavatele) }}">
                        
                        <input name="_method" type="hidden" value="PATCH">

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nazev') ? ' has-error' : '' }}">
                            <label for="nazev" class="col-md-4 control-label">Název pojištovny</label>

                            <div class="col-md-6">
                                <input id="nazev" type="text" class="form-control" name="nazev" value="{{ old('nazev', $poistovna->nazev_pojistovny) }}" required autofocus>

                                @if ($errors->has('nazev'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nazev') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        {{--
                        <!-- TODO -->
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Upravit pojištovnu
                                </button>
                            </div>
                        </div>
                        --}}

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
