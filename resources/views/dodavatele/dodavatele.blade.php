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
                <th>Akce</th>
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
                <th>Akce</th>
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
                
                <td class="text-center">
                    @if (\Auth::user()->isAdmin())
                    <a href="{{route('dodavatele.edit', $dodavatel->id_dodavatele)}}" class="btn btn-primary">
                        <span class="pficon-edit"></span>                   
                    </a>
                    <a href="{{route('dodavatele.confirmDelete', $dodavatel->id_dodavatele)}}" class="btn btn-primary">
                        <span class="pficon-delete"></span>
                    </a>
                    @endif
                    <a href="{{route('dodavatele.show', $dodavatel->id_dodavatele)}}" class="btn btn-primary">
                        <span class="fa fa-eye"></span>
                    </a>
                </td>
                
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


   // Using aoColumns
$(document).ready( function() {
 
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


} );
</script>

@endsection