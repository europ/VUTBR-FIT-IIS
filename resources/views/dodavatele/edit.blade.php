@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Změna dodavatele</b></div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('dodavatele.update', $dodavatel->id_dodavatele) }}">
                        
                        <input name="_method" type="hidden" value="PATCH">

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('nazev') ? ' has-error' : '' }}">
                            <label for="nazev" class="col-md-4 control-label">Název dodavatele</label>

                            <div class="col-md-6">
                                <input id="nazev" type="text" class="form-control" name="nazev" value="{{ old('nazev', $dodavatel->nazev) }}" required autofocus>

                                @if ($errors->has('nazev'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nazev') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="jednorazovy" class="col-md-4 control-label">Jednorázový</label>
                            <div class="col-md-6">
                                <input id="jednorazovy" type="checkbox" class="form-check-input" name="jednorazovy" {{ $dodavatel->typ ? "checked" : "" }}>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('datum_dodani') ? ' has-error' : '' }}" id="jednorazovy-block">
                            <label for="datum_dodani" class="col-md-4 control-label">Datum jednorázového dodání</label>

                            <div class="col-md-6">
                                <div id="date-2" class="input-group date">
                                    <input id="datum_dodani" type="text" class="form-control form-control bootstrap-datepicker" name="datum_dodani" value="{{ old('datum_dodani', $dodavatel->datum_dodani) }}">
                                    <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                </div>
                                @if ($errors->has('datum_dodani'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('datum_dodani') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('platnost_smlouvy_do') ? ' has-error' : '' }}" id="od-do-block">
                            <label for="platnost_smlouvy_od" class="col-md-4 control-label">Platnost smlouvy od - do</label>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div id="date-3" class="input-group date">
                                            <input id="platnost_smlouvy_od" type="text" class="form-control form-control bootstrap-datepicker" name="platnost_smlouvy_od" value="{{ old('platnost_smlouvy_od', $dodavatel->platnost_smlouvy_od) }}">
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>
                                        @if ($errors->has('platnost_smlouvy_od'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('platnost_smlouvy_od') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2 text-center">
                                        -
                                    </div>
                                    <div class="col-md-5">
                                        <div id="date-4" class="input-group date">
                                            <input id="platnost_smlouvy_do" type="text" class="form-control form-control bootstrap-datepicker" name="platnost_smlouvy_do" value="{{ old('platnost_smlouvy_do', $dodavatel->platnost_smlouvy_do) }}">
                                            <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                        </div>
                                        @if ($errors->has('platnost_smlouvy_do'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('platnost_smlouvy_do') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Upravit dodavatele
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

@section('scripts')
<script>
  datepickerSettings = {
    autoclose: true,
    orientation: "bottom auto",
    todayBtn: "linked",
    todayHighlight: true,
    format: 'yyyy-mm-dd'
};
$('#date-2').datepicker(datepickerSettings);
$('#date-3').datepicker(datepickerSettings);
$('#date-4').datepicker(datepickerSettings);
@if ($dodavatel->typ)
$('#od-do-block').hide();
@else
$('#jednorazovy-block').hide();
@endif
$('#jednorazovy').click(function() {
    $("#od-do-block").toggle();
    $("#jednorazovy-block").toggle();
});

</script>
@endsection
