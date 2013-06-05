@layout('master')
@section('content')
	<h2>{{ HTML::entities(Auth::user()->name) }}</h2>
	<img src="{{ URL::base(); }}/uploads/thumbnails/users/{{ Auth::user()->image }}" alt="{{ Auth::user()->name }}" />
@endsection