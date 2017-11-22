@if (Session::has('status-fail'))
<div class="alert alert-danger" role="alert">
	<span class="pficon pficon-error-circle-o"></span>
	{!!Session::get('status-fail')!!}
</div>
@endif

@if (Session::has('status-success'))
<div class="alert alert-success" role="alert">
	<span class="pficon pficon-ok"></span>
	{!!Session::get('status-success')!!}
</div>
@endif