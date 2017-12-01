@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <body class="cards-pf">
      <div class="container-fluid container-cards-pf">
        <div class="row row-cards-pf">
          <div class="col-xs-12">
            <div class="card-pf card-pf-utilization">
              <div class="card-pf-heading">
                <h2 class="card-pf-title">
                  Předpis <b>{{$predpis->id_predpisu}}</b>
                </h2>
              </div>
              <div class="card-pf-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <h3 class="card-pf-subtitle">Rodné číslo</h3>
                    <p class="card-pf-utilization-details">
                      <span class="card-pf-utilization-card-details-count">{{$predpis->rodne_cislo}}</span>
                    </p>
                  </div>

                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <h3 class="card-pf-subtitle">Pojišťovna</h3>
                    <p class="card-pf-utilization-details">
                      <span class="card-pf-utilization-card-details-count">{{$poistovna->nazev_pojistovny}}</span>
                    </p>
                  </div>

                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <h3 class="card-pf-subtitle">Léky</h3>
                    <span class="card-pf-utilization-details">
                      <ul class="list-group">
                        @foreach($leky as $lek)
                        <li class="list-group-item text-center"><b>{{$lek->nazev}}</b></li>
                        @endforeach
                      </ul>
                    </span>
                    <div id="chart-pf-donut-7"></div>
                    <div class="chart-pf-sparkline" id="chart-pf-sparkline-7"></div>

                  </div>
                </div>
              </div>
            </div>

          </div>
        </div><!-- /row -->
      </div><!-- /container -->
    </body>
    
  </div>
</div>
@endsection
