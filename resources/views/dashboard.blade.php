{{--     <body class="cards-pf">
    	...
    	<div class="container-fluid container-cards-pf">
    		<div class="row row-cards-pf">
    			<div class="col-xs-6 col-sm-4 col-md-4">
    				<div class="card-pf card-pf-accented card-pf-aggregate-status">
    					<h2 class="card-pf-title">
    						<span class="fa fa-shield"></span><span class="card-pf-aggregate-status-count">0</span> Ipsum
    					</h2>
    					<div class="card-pf-body">
    						<p class="card-pf-aggregate-status-notifications">
    							<span class="card-pf-aggregate-status-notification"><a href="#" class="add" data-toggle="tooltip" data-placement="top" title="Add Ipsum"><span class="pficon pficon-add-circle-o"></span></a></span>
    						</p>
    					</div>
    				</div>

    			</div>
    			<div class="col-xs-6 col-sm-4 col-md-4">
    				<div class="card-pf card-pf-accented card-pf-aggregate-status">
    					<h2 class="card-pf-title">
    						<a href="#"><span class="fa fa-shield"></span><span class="card-pf-aggregate-status-count">20</span> Amet</a>
    					</h2>
    					<div class="card-pf-body">
    						<p class="card-pf-aggregate-status-notifications">
    							<span class="card-pf-aggregate-status-notification"><a href="#"><span class="pficon pficon-error-circle-o"></span>4</a></span>
    							<span class="card-pf-aggregate-status-notification"><a href="#"><span class="pficon pficon-warning-triangle-o"></span>1</a></span>
    						</p>
    					</div>
    				</div>

    			</div>
    			<div class="col-xs-6 col-sm-4 col-md-4">
    				<div class="card-pf card-pf-accented card-pf-aggregate-status">
    					<h2 class="card-pf-title">
    						<a href="#"><span class="fa fa-shield"></span><span class="card-pf-aggregate-status-count">9</span> Adipiscing</a>
    					</h2>
    					<div class="card-pf-body">
    						<p class="card-pf-aggregate-status-notifications">
    							<span class="card-pf-aggregate-status-notification"><span class="pficon pficon-ok"></span></span>
    						</p>
    					</div>
    				</div>

    			</div>
    		</div><!-- /row -->
    	</div><!-- /container -->
    	<script src="/components/jquery-match-height/dist/jquery.matchHeight-min.js"></script>
    	<script>
    		$(function() {
        // matchHeight the contents of each .card-pf and then the .card-pf itself
        $(".row-cards-pf > [class*='col'] > .card-pf .card-pf-title").matchHeight();
        $(".row-cards-pf > [class*='col'] > .card-pf > .card-pf-body").matchHeight();
        $(".row-cards-pf > [class*='col'] > .card-pf > .card-pf-footer").matchHeight();
        $(".row-cards-pf > [class*='col'] > .card-pf").matchHeight();
        // initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body> --}}










@extends('layouts.app')

@section('content')
<div class="container-fluid container-cards-pf">
	<div class="row row-cards-pf">
		<div class="col-xs-6 col-sm-4 col-md-4">
			<div class="card-pf card-pf-accented card-pf-aggregate-status card-pf-aggregate-status-mini">
				<h2 class="card-pf-title">
					<span class="fa fa-users"></span>
					<span class="card-pf-aggregate-status-count">{{$users_count}}</span> Uživatelů
				</h2>
			</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-4">
			<div class="card-pf card-pf-accented card-pf-aggregate-status card-pf-aggregate-status-mini">
				<h2 class="card-pf-title">
					<span class="fa fa-hospital-o"></span>
					<span class="card-pf-aggregate-status-count">{{$pobocky_count}}</span> Poboček
				</h2>
			</div>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-4">
			<div class="card-pf card-pf-accented card-pf-aggregate-status card-pf-aggregate-status-mini">
				<h2 class="card-pf-title">
					<span class="fa fa-ambulance"></span>
					<span class="card-pf-aggregate-status-count">{{$dodavatele_count}}</span> Dodavatelů
				</h2>
			</div>
		</div>
	</div><!-- /row -->
</div><!-- /container -->



<canvas id="myChart"></canvas>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
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
<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: [20, 10, 15],
    });
</script>


@endsection
