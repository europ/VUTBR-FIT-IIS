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
                  Rezervace <b>{{$rezervace->id_rezervace}}</b>
                </h2>
              </div>
              <div class="card-pf-body">
                <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <h3 class="card-pf-subtitle">Jmeno zákazníka</h3>
                    <p class="card-pf-utilization-details">
                      <span class="card-pf-utilization-card-details-count">{{$rezervace->jmeno_zakaznika}}</span>
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
                      {{-- <span class="card-pf-utilization-card-details-count">256</span>
                      <span class="card-pf-utilization-card-details-description">
                        <span class="card-pf-utilization-card-details-line-1">Available</span>
                        <span class="card-pf-utilization-card-details-line-2">of 432 GB</span>
                      </span> --}}
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
