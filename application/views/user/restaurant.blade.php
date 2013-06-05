@layout('master')
@section('content')
<div class="span5">
	<p class="lead">Restaurantes</p>
	{{ Form::open_for_files('home/restaurant', 'POST', array('class'=>'well')); }}
        {{ Form::token() }}
        @if (Session::has('error_create_restaurants'))
            {{ Alert::error("Error al crear el restaurante") }}
        @endif
        @if (Session::has('yaTiene'))
            {{ Alert::error("Ups.! Ya tienes creado un restaurante") }}
        @endif
        {{ $errors->first('name', Alert::error(":message")) }}
        {{ Form::text('name', Input::old('name'), array('class' => 'span3', 'placeholder' => 'Nombre'));}}

        {{ $errors->first('description', Alert::error(":message")) }}
        {{ Form::textarea('description', Input::old('description'), array('class' => 'span3', 'placeholder' => 'Descripción'));}}
        
        {{ $errors->first('image', Alert::error(":message")) }}
		{{ Form::file('image'); }}

		{{ $errors->first('address', Alert::error(":message")) }}
        {{ Form::text('address', Input::old('address'), array('class' => 'span3', 'placeholder' => 'Dirección'));}}

		{{ $errors->first('telephone', Alert::error(":message")) }}
		{{ Form::text('telephone', Input::old('telephone'), array('class' => 'span3', 'placeholder' => 'Teléfono'));}}
		
		<select name="type" id="type">
			<optgroup label="Tipo de Comida">
			<option value="ComidaRapida">Comida Rapida</option>
			<option value="Buffet">Buffet</option>
			<option value="Grill ">Grill </option>
			<option value="Temático">Temático</option>
			<option value="Gourmet">Gourmet</option>
		</select>
		<br />

        {{ Form::submit('Crear', array('class'=>'btn-success'));}}
  	{{ Form::close() }}
</div>
@endsection