@layout('master')
@section('content')
<h3>{{ e($restaurant->name) }}</h3>
<br />
<img src="{{ URL::base(); }}/uploads/thumbnails/restaurants/{{ $restaurant->image }}">
<br/>
<p>Estado</p>
<small>Cambiar a</small>
@if($restaurant->status == 1)
	<a id="estado" value="0" href="javascript: save();">OFF</a>
@else
	<a id="estado" value="1" href="javascript: save();">ON</a>
@endif
<script type="text/javascript">
	function save(){
		var status = $("#estado").attr("value");
		$.ajax({
			url: "{{ URL::base(); }}/user/restaurantstatus/"+status,
			type: "post",
			success: function(msj){
				location.reload();
			},
			error: function(error) {
				//alert(error);
			}
		});
	}
</script>
@endsection