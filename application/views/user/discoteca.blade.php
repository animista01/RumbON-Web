@layout('master')
@section('content')
<h3>{{ e($club->name) }}</h3>
<br />
<img src="{{ URL::base(); }}/uploads/thumbnails/clubs/{{ $club->image }}">

<div>
	<form class="well" enctype="multipart/form-data" method="POST" action="http://localhost/DiscoTK/public/user/adminclub/{{ $club->id }}" accept-charset="UTF-8">

		{{ Form::token(); }}

		@if (Session::has('error_create_promotion'))
            {{ Alert::error("Error al crear la promoción") }}
        @endif

		{{ $errors->first('image', Alert::error(":message")) }}
		{{ Form::file('image'); }}

		{{ $errors->first('body', Alert::error(":message")) }}
		{{ Form::textarea('body', Input::old('body'), array('class' => 'span3', 'placeholder' => 'Promoción'));}}

		{{ Form::submit('Subir promoción', array('class'=>'btn-success'));}}
	{{ Form::close() }}
</div>
@endsection