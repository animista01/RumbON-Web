@layout('master')
@section('content')
	<div class="row">
		<div class="span5">
			@if($club != '' && $restaurant != '')
				<div class="disco">
					<p class="lead">Discoteca</p>
					{{ HTML::link_to_action('user@adminclub', e($club->name), array($club->id)); }}
				</div>
				<br />
				<div class="restaurante">
					<p class="lead">Restaurante</p>	
					{{ HTML::link_to_action('user@adminrestaurant', e($restaurant->name), array($restaurant->id)); }}
				</div>
			@elseif($club == '' && $restaurant != '')
				{{ HTML::link_to_action('home@club', 'Crear Discoteca') }}
				<br />
				<div class="restaurante">
					<p class="lead">Restaurante</p>	
					{{ HTML::link_to_action('user@adminrestaurant', e($restaurant->name), array($restaurant->id)); }}
				</div>
			@elseif($club != '' && $restaurant == '')
				{{ HTML::link_to_action('home@restaurant', 'Crear Restaurantes') }}
				<br />
				<div class="disco">
					<p class="lead">Discoteca</p>
					{{ HTML::link_to_action('user@adminclub', e($club->name), array($club->id)); }}
				</div>
			@else
				{{ HTML::link_to_action('home@club', 'Crear Discoteca') }}
				<br />
				{{ HTML::link_to_action('home@restaurant', 'Crear Restaurantes') }}
			@endif
		</div>
	</div>
@endsection