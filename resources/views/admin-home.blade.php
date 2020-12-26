@extends('layouts.single')

@section('title')Админка@endsection

@section('content')
<div class="col-12">
	<center><h1>Телеканалы</h1></center>
</div>


@foreach($channels as $channel)
	<div class="col-md-3">
		<h5>
			<img class = "logo" src="{{ asset('/storage/' . $channel->path) }}" alt=""> {{ $channel->name }}
		</h5>
	</div>


@endforeach

@endsection
