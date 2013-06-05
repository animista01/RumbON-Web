@layout('master')
@section('contentshow')
	<div class="jumbotron">
		<h2>{{ e($club->name) }}</h2>
		<img src="{{ URL::base(); }}/uploads/thumbnails/clubs/{{ $club->image }}">
		<p class="lead">{{ e($club->description) }}</p>
	</div>
	<hr>
	<h3>Promociones de {{ e($club->name) }}</h3>
	@foreach($promociones -> results as $promocion)
		<img src="{{ URL::base(); }}/uploads/thumbnails/clubs/promotions/{{ $promocion->image }}">
		<p>{{ e($promocion->body) }}</p>
		<br />
	@endforeach	

@endsection