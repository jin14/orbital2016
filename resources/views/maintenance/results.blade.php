@extends('layouts.app')

@section('content')

<div class="container">
	<form action="/search" method="POST" role="search">
		{{ csrf_field() }}
		<div class="input-group">
			<input type="text" class="form-control" name="q"
			placeholder="Search report by status or title"> 
			<span class="input-group-btn">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</span>
		</div>
	</form>
	@if (isset($results))
	<br>
	<table class="table table-bordered">
		<thead>
			<tr>
				
				<th>Name</th>
				<th>Room Number</th>
				<th>Title</th>
				<th>Date</th>
				<th>Status</th>
			</tr>
		</thead>
		
		@foreach ($results->all() as $detail)
		<tbody>
			<tr>
				
				<td>{{ $detail-> username }}</td>
				<td>{{ $detail -> currentRoom }}</td>
				<td><a href="/maintenance/display/{{$detail->id}}">{{ $detail -> title }}</a></td>
				<td>{{ $detail -> created_at -> format('Y-m-d')}}</td>
				
				 @if(Auth::user()->role_id==7)

				<td>{{ $detail->status }}<a href="/maintenance/{{$detail->id}}" class="pull-right"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
				</td>
				@else
				<td>{{ $detail->status}}</td>

				@endif
			</tr>
		</tbody>

		@endforeach
	</table>
	@endif
</div>


@endsection
