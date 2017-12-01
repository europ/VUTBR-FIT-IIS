@extends('layouts.app')

@section('content')


<div class="blank-slate-pf">
    <div class="panel-body">

        <div class="row">
            <div class="col-md-12">
                <h1>
                    <strong>HELP</strong>
                </h1>
                <p>
                    <br>
                    Informačný systém rozdeľuje osoby ktoré majú povolený vstup do systému do dvoch kategórií:
                    <br>
                    <br>
                <p>
            </div>
        </div>

        <div class="row">

            <div class="inline-block col-md-6">

                <h4>
                    <strong>Správce</strong> umí:
                </h4>

                <p>
                    <li>přidat, upravit, smazat užívatele</li>
                    <li>přidat, upravit, smazat, naskladnit lék</li>
                    <li>přidat, upravit, smazat, zobrazit pobočky/pobočku</li>
                    <li>přidat, upravit, smazat, zobrazit dodavatelov/dodavatele</li>
                    <li>přidat, upravit, smazat, zobrazit předpisy/předpis</li>
                    <li>přidat, upravit, smazat, zobrazit rezervace/rezervaci</li>
                    <li>přidat, upravit, smazat pojišťovnu</li>

                </p>

            </div>

            <div class="inline-block col-md-6">

                <h4>
                    <strong>Užívatel</strong> umí:
                </h4>

                <p>
                    <li>vydat lék</li>
                    <li>zobrazit pobočky/pobočku</li>
                    <li>zobrazit dodavatelov</li>
                    <li>přidat, upravit, smazat, zobrazit předpisy/předpis</li>
                    <li>přidat, upravit, smazat, zobrazit rezervace/rezervaci</li>
                    <li>zobrazit pojišťovny</li>

                </p>

            </div>

        </div>


    </div>
</div>

@endsection
