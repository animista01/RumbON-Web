@layout('master')
@section('contentshow')
<div class="span6" id="content">
	<div id="details" class="span6">
		<div>
			<p><img src="{{ URL::base(); }}/uploads/thumbnails/clubs/{{ $club->image }}" width="160" height="160"></p>
			<h3>{{ e($club->name) }}</h3>
			<h4>{{ e($club->description) }}</h4>
			<br>
				
	        <table class="table table-striped">
	            <tbody>
		            <tr>
		                <td>Celular:</td>
		                <td><i class="icon-headphones"></i> {{e($club->telephone)}}</td>
		            </tr>
		            <tr>
		                <td>Horario:</td>
		                <td><i class="icon-time"></i> {{e($club->horary)}}</td>
		            </tr>
		            <tr>
		                <td>Tipo de Musica:</td>
		                <td><i class="icon-music"></i> {{e($club->type)}}</td>
		            </tr>
		            <tr>
		                <td>Direccion:</td>
		                <td><i class="icon-calendar"></i> {{e($club->address)}}</td>
		            </tr>
	        	</tbody>
	    	</table>
		</div>
	</div>
</div>
<div class="span12"><hr></div>
<div class="span7">
	<h3>Promociones de {{ e($club->name) }}</h3>
	@foreach($promociones -> results as $promocion)
		<img src="{{ URL::base(); }}/uploads/thumbnails/clubs/promotions/{{ $promocion->image }}">
		<p>{{ e($promocion->body) }}</p>
		<br />
	@endforeach	
</div>
@endsection