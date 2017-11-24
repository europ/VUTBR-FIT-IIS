@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-9">
            <h1>
                Dodavatelé
            </h1>
        </div>
        <div class="col-md-3 text-right">
            @if (\Auth::user()->isAdmin())
            <a href="{{route('dodavatele.create')}}" class="btn btn-primary" style="margin-top: 20px;">
                <span class="pficon-add-circle-o"></span> Přidat dodavatele
            </a>
            @endif
        </div>
    </div>

    @include('alerts.status')

    <!-- Table HTML -->
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Název dodavatele</th>
                <th>Typ</th>
                <th>Datum dodání</th>
                <th>Platnost smlouvy od</th>
                <th>Platnost smlouvy do</th>
                @if (\Auth::user()->isAdmin())
                <th>Akce</th>
                @endif
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Název dodavatele</th>
                <th>Typ</th>
                <th>Datum dodání</th>
                <th>Platnost smlouvy od</th>
                <th>Platnost smlouvy do</th>
                @if (\Auth::user()->isAdmin())
                <th>Akce</th>
                @endif
            </tr>
        </tfoot>
        <tbody>
            @foreach($dodavatele as $dodavatel)
            <tr>
                <td>{{ $dodavatel->id_dodavatele }}</td>
                <td>{{ $dodavatel->nazev }}</td>
                <td>{{ $dodavatel->typ == 1 ? "Jednorázový" : "Smluvný" }}</td>
                <td>{{ $dodavatel->datum_dodani }}</td>
                <td>{{ $dodavatel->platnost_smlouvy_od }}</td>
                <td>{{ $dodavatel->platnost_smlouvy_do }}</td>
                @if (\Auth::user()->isAdmin())
                <td class="text-center">
                    <a href="{{route('dodavatele.edit', $dodavatel->id_dodavatele)}}" class="btn btn-primary">
                        <span class="pficon-edit"></span>                   
                    </a>
                    <a href="{{route('dodavatele.destroy', $dodavatel->id_dodavatele)}}" class="btn btn-primary">
                        <span class="pficon-delete"></span>
                    </a>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
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

    var admin = "{{{ (Auth::user()->isAdmin()) ? Auth::user()->isAdmin() : null }}}";

   // Using aoColumns
   $(document).ready( function() {
    if(admin){
        $('#example').dataTable( {
        "aoColumns": [ 
        null,
        null,
        null,
        null,
        null,
        null,
        { "bSortable": false }
        ] } );
    }
    else {
        $('#example').dataTable( {
        "aoColumns": [ 
        null,
        null,
        null,
        null,
        null,
        null
        ] } );
    }
    } );
</script>

@endsection