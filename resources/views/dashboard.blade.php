@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="text-center">
            <div class="blank-slate-pf-icon">
                <img src="/img/logo.svg" alt="Logo"/>
            </div>
            <h1>
                <strong>
                    {{config('app.name')}}
                </strong>
            </h1>
        </div>
    </div>
</div>


<div class="text-center">
    <div class="col-sm-3">
        <div class="card-pf card-pf-accented card-pf-aggregate-status card-pf-aggregate-status-mini">
            <h2 class="card-pf-title">
                <span class="fa fa-users"></span>
                <span class="card-pf-aggregate-status-count">{{$users_count}}</span> Uživatelů
            </h2>
        </div>
    </div>
</div>



<div class="text-center">
    <div class="col-sm-3">
        <div class="card-pf card-pf-accented card-pf-aggregate-status card-pf-aggregate-status-mini">
            <h2 class="card-pf-title">
                <span class="fa fa-hospital-o"></span>
                <span class="card-pf-aggregate-status-count">{{$pobocky_count}}</span> Poboček
            </h2>
        </div>
    </div>
</div>



<div class="text-center">
    <div class="col-sm-3">
        <div class="card-pf card-pf-accented card-pf-aggregate-status card-pf-aggregate-status-mini">
            <h2 class="card-pf-title">
                <span class="fa fa-ambulance"></span>
                <span class="card-pf-aggregate-status-count">{{$dodavatele_count}}</span> Dodavatelů
            </h2>
        </div>
    </div>
</div>




@endsection

@section('scripts')

<script>
       // Using aoColumnDefs
       $(document).ready( function() {
        $('#example').dataTable( {
            "aoColumnDefs": [ 
            { "bSortable": false, "aTargets": [ 0 ] }
            ] } );
       } );


   // Using aoColumns
   $(document).ready( function() {
    $('#example').dataTable( {
        "aoColumns": [ 
        null,
        null,
        null
        ] } );
   } );
</script>

@endsection
