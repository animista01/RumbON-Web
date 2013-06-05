<?php
class Api_Controller extends Base_Controller{
	public $restful = true;
	public function __construct()
    {
    	//header("content-type: application/json"); 
    	header('Access-Control-Allow-Origin: *'); // allow cross domain origin access
    }

	public function get_clubs(){
		//Traer todas las discotecas 
		$all_clubs = Club::order_by('created_at','desc')->get();

		//Variable que se exportará en JSON
		$clubs = array();

		//Recorremos todos los nimkus para extraer solo los datos que nos importan
		foreach($all_clubs as $club){
			//Almacenando los datos necesarios en el arreglo a exportar
			$clubs["datos"][]  = array(
				'name' => $club->name,
				'description' => $club->description,
				'image' => $club->image,
				'address' => $club->address,
				'telephone' => $club->telephone,
				'horary' => $club->horary
			);
		}
		//Mostrar el JSON
		return Response::json($clubs);
	}

	public function get_clubyname($nombre)
	{
		//Traer un restaurante por nombre 
		$club_sql = Club::where('name','=',$nombre)->get();
		//Variable que se exportará en JSON
		$club = array();
		//Recorremos todos los nimkus para extraer solo los datos que nos importan
		foreach($club_sql as $clubfor){
			//Almacenando los datos necesarios en el arreglo a exportar
			$club["datos"][] = array(
				'name' => $clubfor->name,
				'description' => $clubfor->description,
				'image' => $clubfor->image,
				'address' => $clubfor->address,
				'telephone' => $clubfor->telephone,
				'horary' => $clubfor->horary
			);
		}
		//Mostrar el JSON
		return Response::json($club);
	}

	public function get_clubytype($type)
	{
		//Traer un restaurante por nombre 
		$clubtype_sql = Club::where('type','=',$type)->get();
		//Variable que se exportará en JSON
		$club = array();
		//Recorremos todos los nimkus para extraer solo los datos que nos importan
		foreach($clubtype_sql as $clubfor){
			//Almacenando los datos necesarios en el arreglo a exportar
			$club['datos'][] = array(
				'id' => $clubfor->id,
				'name' => $clubfor->name,
				'description' => $clubfor->description,
				'image' => $clubfor->image,
				'telephone' => $clubfor->telephone,
				'address' => $clubfor->address
			);
		}
		//Mostrar el JSON
		return Response::json($club);
	}

	public function get_restaurants()
	{
		//Traer todos los restaurantes ordenado por el mas reciente
		$all_restaurants = Restaurant::order_by('created_at','desc')->get();

		//Variable que se exportará en JSON
		$restaurants = array();

		//Recorremos todos los nimkus para extraer solo los datos que nos importan
		foreach($all_restaurants as $restaurant){
			//Almacenando los datos necesarios en el arreglo a exportar
			$restaurants['datos'][] = array(
				'id' => $restaurant->id,
				'name' => $restaurant->name,
				'description' => $restaurant->description,
				'image' => $restaurant->image,
				'address' => $restaurant->address,
				'telephone' => $restaurant->telephone,
				'status' => $restaurant->status
			);
		}
		//Mostrar el JSON
		return Response::json($restaurants);
	}

	public function get_restaurantsbytype($type)
	{
		//Traer un restaurante por tipo 
		$restaurant_sql = Restaurant::where('type','=',$type)->get();
		//Variable que se exportará en JSON
		$restaurant = array();
		//Recorremos todos los nimkus para extraer solo los datos que nos importan
		foreach($restaurant_sql as $restaurantfor){
			//Almacenando los datos necesarios en el arreglo a exportar
			$restaurant[] = array(
				'name' => $restaurantfor->name,
				'description' => $restaurantfor->description,
				'image' => $restaurantfor->image,
				'address' => $restaurantfor->address,
				'telephone' => $restaurantfor->telephone,
				'status' => $restaurantfor->status
			);
		}
		//Mostrar el JSON
		return Response::json($restaurant);
	}
	//Restaurantes abiertos
	public function get_restaurantbystatu()
	{
		$abiertos = Restaurant::where_status(1)->get();
		$restaurants = array();
		//Recorremos todos los nimkus para extraer solo los datos que nos importan
		foreach($abiertos as $restaurantfor){
			//Almacenando los datos necesarios en el arreglo a exportar
			$restaurants['datos'][]  = array(
				'id' => $restaurantfor->id,
				'name' => $restaurantfor->name,
				'description' => $restaurantfor->description,
				'image' => $restaurantfor->image,
				'telephone' => $restaurantfor->telephone,
				'address' => $restaurantfor->address
			);
		}
		//Mostrar el JSON
		return Response::json($restaurants);
	}

	public function post_register()
	{
		$nombre = filter_input(INPUT_POST,'name',FILTER_SANITIZE_STRING);
		$usuario = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$telefono = filter_input(INPUT_POST,'telephone',FILTER_SANITIZE_NUMBER_INT);
		$contrasena = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

		$new_user = array(
	        'name'		=> $nombre,
	        'telephone'  => $telefono,
	        'email'  => $usuario,
	        'password'  => $contrasena
    	);
    	$rules = array(
	        'name' => 'required|match:/[a-z]+/|min:3|max:20',
	        'telephone' => 'required|min:7|max:12',
	        'email' => 'required|unique:users|email',
	        'password' => 'required|min:5|max:60'
    	);
    
		$resultado = array();
	    $validation = Validator::make($new_user, $rules);
	    if ($validation->fails())
	    {   
	    	$resultado[] = array(
				'status' => "Error"
 			);
 			$resultado[] = array(
				'type' => $validation
 			);
	    }else{
    		// Save all in the database
		    $new_user['password'] = Hash::make($new_user['password']);
		    
		    //Crear la API_KEY
		    function createApiKey()
			{
				$key = Str::random(32);
				//Validar si no existe ya ese nombre random el la DB
			    if (User::where('api_key','=',$key)->first()) {
			    	createApiKey();
			    }
				return $key;
			}
			$api_key = createApiKey();

		    $user = new User($new_user);
			$user->api_key = $api_key;
	 		$user->type = 1;
	 		$user->image = 'default.jpg';
		    $user->save(); 

		    $user_id = User::where('api_key','=',$api_key)->only('id');

		    //Mandamos los datos del nuevo usuario
		    $resultado[] = array(
				'status' => "Ok"
 			);
		    $resultado['datos'][] = array(
		    	'id' => $user_id,
				'name' => $nombre,
	        	'telephone' => $telefono,
	        	'email' => $usuario,
	        	'type' => 1,
	        	'api_key' => $api_key
 			);
	    }
		return Response::json($resultado);
	}//end Register

	public function post_loginuser()
	{
		$usuario = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
		$contrasena = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);

		$credentials = array('username' => $usuario, 'password' => $contrasena);

		$resultado = array();
		if (Auth::attempt($credentials))
		{
			$resultado[] = array(
				'status' => "Ok"
 			);
 			$resultado['datos'][] = array(
		    	'id' => Auth::user()->id,
	        	'api_key' => Auth::user()->api_key
        	);
		}else{
			$resultado[] = array(
				'status' => "Error"
 			);
		}
		return Response::json($resultado);
	}

	public function post_go()
	{
		$id = $_POST['id'];
		$club_id = $_POST['club_id'];

		$club = Club::where_id($club_id)->first();

		$new_go = array(
	        'user_id' => $id,
	        'club_id'  => $club_id
    	);

		$resultado = array();

		$go = new Go($new_go);
	    $go->save(); 

	    //Mandamos los datos del nuevo Go
	    $resultado['datos'][] = array(
	    	'id' => $club->id,
			'name' => $club->name,
			'description' => $club->description,
			'image' => $club->image,
			'address' => $club->address,
			'telephone' => $club->telephone
		);		
		return Response::json($resultado);
	}

}