@if (Session::has('status-fail'))
<div class="alert alert-danger alert-dismissable" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
		<span class="pficon pficon-close"></span>
	</button>
	<span class="pficon pficon-error-circle-o"></span>
	{!!Session::get('status-fail')!!}
</div>
@endif

@if (Session::has('status-success'))
<div class="alert alert-success alert-dismissable" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
		<span class="pficon pficon-close"></span>
	</button>
	<span class="pficon pficon-ok"></span>
	{!!Session::get('status-success')!!}
</div>
@endif
