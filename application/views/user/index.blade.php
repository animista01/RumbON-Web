@layout('master')
@section('content')
	<h2>{{ HTML::entities(Auth::user()->name) }}</h2>
	<img src="{{ URL::base(); }}/uploads/thumbnails/{{ Auth::user()->image }}" alt="e({{ Auth::user()->name }})" />
	<p>{{  e(Auth::user()->bio) }}</p>
@endsection