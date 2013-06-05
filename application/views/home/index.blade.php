@layout('master')
@section('content')
<div class="span8 offset2">
    <div class="row artwork hidden-phone" style="font-size:80px; text-align: center;">
		<div class="masthead">
			<h1>RumbON<h1>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="span4">
		<p class="lead">Ingresar</p>
			{{ Form::open('home/login', 'POST',array('class'=>'well')); }}
				{{ Form::token() }}
				@if (Session::has('error_login'))
				{{ Alert::error("Email o contraseña incorrecta.") }}
				@endif
				{{ Form::text('username', Input::old('username'), array('class' => 'span3', 'placeholder' => 'Email'));}}
				{{ Form::password('password', array('class' => 'span3', 'placeholder' => 'Contraseña'));}}
				{{ Form::labelled_checkbox('remember', 'Recordarme');}}
				{{ Form::submit('Entrar', array('class'=>'btn-info'));}}
			{{ Form::close() }}
		</div>
		<div class="span4">
			<p class="lead">¿Aun no te registras? Regístrate!</p>
			@if (Session::has('error_register'))
	            {{ Alert::error("Error al registrate") }}
		    @endif
			{{ Form::open_for_files('/', 'POST',array('class'=>'well')); }}

			{{ Form::token(); }}

			{{ $errors->first('name', Alert::error(":message")) }}
			{{ Form::text('name', Input::old('name'), array('class' => 'span3', 'placeholder' => 'Nombre completo'));}}
			
			{{ $errors->first('email', Alert::error(":message")) }}
			{{ Form::text('email', Input::old('email'), array('class' => 'span3', 'placeholder' => 'Email'));}}

			{{ $errors->first('telephone', Alert::error(":message")) }}
			{{ Form::text('telephone', Input::old('telephone'), array('class' => 'span3', 'placeholder' => 'Telefono'));}}

			<select name="type" id="type">
				<optgroup label="Tipo de Usuario">
				<option value="rumbon">Usuario RumbON</option>
				<option value="adminDisco">Administrador Discoteca</option>
				<option value="adminRest">Administrador Restaurante</option>
			</select>
			
			{{ $errors->first('image', Alert::error(":message")) }}
			{{ Form::file('image'); }}

			{{ $errors->first('password', Alert::error(":message")) }}
			{{ Form::password('nuevo_password', array('class' => 'span3', 'placeholder' => 'Contraseña'));}}
			
			{{ Form::submit('Regístrate', array('class'=>'btn-success'));}}
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection