@extends('layouts.app')

@section('content')

<div class="container">	
	<div class="row">
	<h3> Maintenance Report Received </h31>
	<br>
	<a href="{{ url('/maintenance/display') }}" class="btn btn-primary active" role="button">View</a>
	</div>
</div>

@endsection
