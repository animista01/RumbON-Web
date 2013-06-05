@layout('master')
@section('content')
{{ Form::open_for_files('user/editdisco', 'PUT') }}

	{{ Form::token() }}
	@if (Session::has('error_edit'))
        {{ Alert::error("Error al editar la discoteca") }}
    @endif
	<p>
		{{ Form::label('name', 'Nombre:') }}<br />
		{{ $errors->first('name', Alert::error(":message")) }}
		<input type="text" value="{{ $club->name }}" name="name" />
	</p>
		{{ Form::label('description', 'Bio:') }}<br />
		{{ $errors->first('description', Alert::error(":message")) }}
		<textarea name="description">{{$club->description}}</textarea>
	<p>
		{{ Form::label('telephone', 'Telefono:') }}<br />
		{{ $errors->first('telephone', Alert::error(":message")) }}
		<input type="number" value="{{ $club->telephone }}" name="telephone" />
	</p>
	<p>
		{{ Form::label('address', 'Direccion:') }}<br />
		{{ $errors->first('address', Alert::error(":message")) }}
		<input type="text" value="{{ $club->address }}" name="address" />
	</p>
	<p>
		{{ Form::label('horary', 'Horario:') }}<br />
		{{ $errors->first('horary', Alert::error(":message")) }}
		<input type="text" value="{{ $club->horary }}" name="horary" />
	</p>
	
	<select name="type" id="type">
		<optgroup label="Actual">
		<option value="{{$club->type}}">{{$club->type}}</option>
		<optgroup label="Opciones">
		<option value="Salsa">Salsa</option>
		<option value="Vallenato">Vallenato</option>
		<option value="Reggaeton">Reggaeton</option>
		<option value="Karaoke">Karaoke</option>
		<option value="Crossover">Crossover</option>
	</select>

	<p>{{ Form::submit('Editar', array('class'=>'btn-warning'));}}</p>
		
{{ Form::close() }}
@endsection