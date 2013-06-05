@layout('master')
@section('content')
	<div>
		@if(Auth::user()->type == 1)
			@if (isset($promotions))
				@if($promotions)
					<h3>Promociones Timeline</h3>
					@foreach($promotions -> results as $promociones)
						<h4>{{ HTML::link_to_action('user@club', $promociones->club->name, array($promociones->club->id)) }}</h4>
						<img src="{{ URL::base(); }}/uploads/thumbnails/clubs/promotions/{{ $promociones->image }}">
						<p>{{ $promociones->body }}</p>
						<br />
					@endforeach	
				@endif
			@endif
		@endif
		
		@if(Auth::user()->type == 2)
			@if (isset($club)) 
				@if($club)
					<div class="disco">
						<p class="lead">Discoteca</p>
						{{ HTML::link_to_action('user@adminclub', e($club->name), array($club->id)); }}
					</div>			
				@endif
			@else
				<h3>No tienes Discoteca, Crea una ya.!</h3>
				{{ HTML::link_to_action('home@club', 'Crear Discoteca') }}
			@endif
		@endif

		@if(Auth::user()->type == 3)
			@if(isset($restaurant))
				@if($restaurant)
					<div class="restaurante">
						<p class="lead">Restaurante</p>	
						{{ HTML::link_to_action('user@adminrestaurant', e($restaurant->name), array($restaurant->id)); }}
					</div>					
				@endif
			@else
				<h3>No tienes Restaurante, Crea uno ya.!</h3>
					{{ HTML::link_to_action('home@restaurant', 'Crear Restaurante') }} 
			@endif
		@endif
	</div>
@endsection