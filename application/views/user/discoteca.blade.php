@layout('master')
@section('contentshow')
<div class="row-fluid">
	<div class="span12" id="content">
		<div id="details" class="span6">
			<div>
				<p><img src="{{ URL::base(); }}/uploads/thumbnails/clubs/{{ $club->image }}" width="160" height="160"></p>
				<h3>{{ e($club->name) }}</h3>
				<br>
		        <table class="table table-striped">
		            <tbody>
			            <tr>
			                <td>Celular:</td>
			                <td><i class="icon-headphones"></i> {{e(Auth::user()->telephone)}}</td>
			            </tr>
			            <tr>
			                <td>Email:</td>
			                <td><i class="icon-envelope"></i> {{e(Auth::user()->email)}}</td>
			            </tr>
		        	</tbody>
		    	</table>
			</div>
		</div>
		<br><br>
		<div id="details" class="span4">
			<form class="well" enctype="multipart/form-data" method="POST" action="http://localhost/DiscoTK/public/user/adminclub/{{ $club->id }}" accept-charset="UTF-8">
				{{ Form::token(); }}

				@if (Session::has('error_create_promotion'))
		            {{ Alert::error("Error al crear la promoción") }}
		        @endif
				
				{{ $errors->first('body', Alert::error(":message")) }}
				{{ Form::textarea('body', Input::old('body'), array('placeholder' => 'Promoción', 'rows' => '4', 'cols' => '50'))}}
				<br>
				{{ $errors->first('image', Alert::error(":message")) }}
				{{ Form::file('image'); }}
				<br>
				{{ Form::submit('Subir promoción', array('class'=>'btn-success'));}}
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection