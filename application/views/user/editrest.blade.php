@layout('master')
@section('content')
{{ Form::open_for_files('user/editrest', 'PUT') }}

	{{ Form::token() }}
	@if (Session::has('error_edit'))
        {{ Alert::error("Error al editar el restaurante") }}
    @endif
	<p>
		{{ Form::label('name', 'Nombre:') }}<br />
		{{ $errors->first('name', Alert::error(":message")) }}
		<input type="text" value="{{ $restaurant->name }}" name="name" />
	</p>
	{{ Form::label('description', 'Bio:') }}<br />
		{{ $errors->first('description', Alert::error(":message")) }}
		<textarea name="description">{{$restaurant->description}}</textarea>

	<p>
		{{ Form::label('telephone', 'Telefono:') }}<br />
		{{ $errors->first('telephone', Alert::error(":message")) }}
		<input type="number" value="{{ $restaurant->telephone }}" name="telephone" />
	</p>
	<p>
		{{ Form::label('address', 'Direccion:') }}<br />
		{{ $errors->first('address', Alert::error(":message")) }}
		<input type="text" value="{{ $restaurant->address }}" name="address" />
	</p>
	<select name="type" id="type">
		<optgroup label="Actual">
		<option value="{{$restaurant->type}}">{{$restaurant->type}}</option>
		<optgroup label="Opciones">
		<option value="ComidaRapida">Comida Rapida</option>
		<option value="Buffet">Buffet</option>
		<option value="Grill ">Grill </option>
		<option value="Temático">Temático</option>
		<option value="Gourmet">Gourmet</option>
	</select>
	<p>{{ Form::submit('Editar', array('class'=>'btn-warning'));}}</p>
		
{{ Form::close() }}
@endsection