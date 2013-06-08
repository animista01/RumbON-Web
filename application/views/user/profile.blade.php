@layout('master')
@section('contentshow')
	<div class="row-fluid">
		<div class="span12" id="content">
			<div id="details" class="span7">
				<div>
					<p><img src="{{ URL::base(); }}/uploads/thumbnails/users/{{ Auth::user()->image }}" width="160" height="160"></p>
					<h3>{{ HTML::entities(Auth::user()->name) }}</h3>
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
		</div>
	</div>
@endsection