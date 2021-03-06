@layout('master')
@section('content')
<div class="span5">
	<p class="lead">Discotecas</p>
	{{ Form::open_for_files('home/club', 'POST', array('class'=>'well')); }}
        {{ Form::token() }}
        @if (Session::has('error_create_club'))
            {{ Alert::error("Error al crear la discoteca") }}
        @endif 
        @if (Session::has('yaTiene'))
            {{ Alert::error("Ups.! Ya tienes creada una discoteca") }}
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
		
		{{ $errors->first('horary', Alert::error(":message")) }}
		{{ Form::text('horary', Input::old('horary'), array('class' => 'span3', 'placeholder' => 'Horario'));}}

		<select name="type" id="type">
			<optgroup label="Tipo de Musica">
			<option value="Salsa">Salsa</option>
			<option value="Vallenato">Vallenato</option>
			<option value="Reggaeton">Reggaeton</option>
			<option value="Karaoke">Karaoke</option>
			<option value="Crossover">Crossover</option>
		</select>
		<br />
        {{ Form::submit('Crear', array('class'=>'btn-success'));}}
  	{{ Form::close() }}
</div>
@endsection