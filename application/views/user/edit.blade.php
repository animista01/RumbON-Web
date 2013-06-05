@layout('master')
@section('content')
	{{ Form::open_for_files('user/edituser', 'PUT') }}

	{{ Form::token() }}
	@if (Session::has('error_edit'))
        {{ Alert::error("Error al editar") }}
    @endif
	<p>
		{{ Form::label('name', 'Nombre:') }}<br />
		{{ $errors->first('name', Alert::error(":message")) }}
		<input type="text" value="{{ $user->name }}" name="name" />
	</p>

	<p>
		{{ Form::label('telephone', 'Telefono:') }}<br />
		{{ $errors->first('telephone', Alert::error(":message")) }}
		<input type="number" value="{{ $user->telephone }}" name="telephone" />
	</p>

	<p>{{ Form::submit('Editar', array('class'=>'btn-warning'));}}</p>
		
	{{ Form::close() }}
@endsection