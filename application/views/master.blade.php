<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>RumbON</title>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/bootstrap-responsive.css') }}
	<style>
    .artwork {
      margin-top:30px;
      margin-bottom: 30px;
    }
    .masthead h1{
      font-size: 120px;
      line-height: 1;
      letter-spacing: -2px;
    }
  </style>
  {{ HTML::style('css/onoff.css') }}
</head>
<body>
	
	<div class="navbar">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          @if (Auth::guest())
            <a class="brand" href="{{ URL::base(); }}">RumbON</a>
          @else
            <a class="brand" href="{{ URL::base(); }}/user/index">RumbON</a>
          @endif
          <div class="nav-collapse">
            <ul class="nav pull-right">
              @if (Auth::guest())
                <li class="divider-vertical"></li>
                <li class="dropdown visible-desktop">
                  <a class="dropdown-toggle" href="#" data-toggle="dropdown">Ingresar <strong class="caret"></strong></a>
                  <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                    {{ Form::open('home/login', 'POST'); }}
	                    {{ Form::token() }}
	                    {{ Form::text('username', Input::old('username'), array('class' => 'span2', 'placeholder' => 'Email'));}}
	                    {{ Form::password('password', array('class' => 'span2', 'placeholder' => 'Contraseña'));}}
	                    {{ Form::submit('Entrar', array('class'=>'btn-info'));}}
                 	  {{ Form::close() }}
                  </div>
                </li>
              @else
             	<li class="divider-vertical"></li>
              <li class="dropdown visible-desktop">
                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
              		{{ e(Auth::user()->name) }} 
              		<strong class="caret"></strong>
              	</a>
               	<ul class="dropdown-menu" role="menu">
		              <li>{{ HTML::link_to_action('user@editUser', 'Editar Perfil', array(Auth::user()->id)) }}</li>
                  @if(Auth::user()->type == 2)
                    @if(isset(Auth::user()->club->id))
                    <li>{{ HTML::link_to_action('user@editdisco', 'Editar Discoteca', array(Auth::user()->club->id)) }}</li>
                    @endif
                  @elseif(Auth::user()->type == 3)
                    @if(isset(Auth::user()->restaurant->id))
                      <li>{{ HTML::link_to_action('user@editrest', 'Editar Restaurante', array(Auth::user()->restaurant->id)) }}</li>
                    @endif
                  @endif
	              	<li>{{ HTML::link_to_action('home@logout', 'Salir') }}</li>
	              </ul>
	          	</li>
              @endif
            </ul>
            <ul class="nav">
              @if (Auth::guest())
                <li class="active"><a id="aInicioInvitado" href="{{URL::base();}}">Inicio</a></li>
              @else
                <li><a href="{{URL::base();}}/user/index">Inicio</a><li>
                <li>{{ HTML::link_to_action('user@profile', "Perfil") }}</li>
              @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        @yield('content')
      </div>
    </div>
    <div class="container">
      @yield('contentshow')
    </div>
  {{ Asset::container('bootstrapper')->scripts(); }}
  {{ HTML::script('js/codigo.js') }}
  @section('scripts')
  @yield_section
</body>
</html>