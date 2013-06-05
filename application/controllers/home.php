<?php

class Home_Controller extends Base_Controller {
	public $restful = true;
	public function __construct() 
    {
        $this->filter('before', 'csrf')->on('post');
        $this->filter('before', 'auth')->only(array('club', 'restaurant'));
    }
	public function get_index()
	{
		if (Auth::guest()){
			return View::make('home.index');
		}else {
			$discotecas_Usu = Club::where('user_id','=',Auth::user()->id)->first();
    		$restaurantes_Usu = Restaurant::where('user_id','=',Auth::user()->id)->first();
			return View::make('user.index')
				->with('club', $discotecas_Usu)
    			->with('restaurant', $restaurantes_Usu);
			/*
			$nimkus = Nimku::with('user')->order_by('created_at','desc')->paginate(10) ;
			$count = Nimku::count() ;
				-> with('count', $count)
				-> with('nimkus', $nimkus);
			*/
		}
	}
	public function post_index()
	{
		$new_user = array(
	        'name'		=> Input::get('name'),
	        'telephone'  => Input::get('telephone'),
	        'email'  => Input::get('email'),
	        'type'=> Input::get('type'),
	        'image' => Input::file('image'),
	        'password'  => Input::get('nuevo_password')
    	);
   
    	$rules = array(
	        'name' => 'required|match:/[a-z]+/|min:3|max:20',
	        'telephone' => 'required|numeric',
	        'email' => 'required|unique:users|email',
	        'type' => 'required',
	        'image' => 'required|image|mimes:jpg,png|max:1024',
	        'password' => 'required|min:5|max:60'
    	);
    
	    $validation = Validator::make($new_user, $rules);

	    if ($validation->fails())
	    {   
	        return Redirect::home()
                ->with('user', Auth::user())
                ->with_errors($validation)
                ->with_input('except', array('nuevo_password','image'))
                ->with('error_register', true);
	    }
	    $new_user['password'] = Hash::make($new_user['password']);

	    //convertir de string a int el tipo de usuario elegido 
	    if (Input::get('type') == 'rumbon') {
	    	$tipo = 1;
	    }elseif(Input::get('type') == 'adminDisco'){
	    	$tipo = 2;
	    }elseif(Input::get('type') == 'adminRest'){
	    	$tipo = 3;
	    }

	    // create a random name
		function generate_random_filename()
	    {
		    // create a random name
			$filename = Str::random(20) .'.'. File::extension(Input::file('image.name'));

	    	//Validar si no existe ya ese nombre random el la DB
		    if (User::where_image($filename)->first()) {
		    	generate_random_filename();
		    }
		    return $filename;
	    }
	    $filename = generate_random_filename();

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

		// Save all in the database
	    $user = new User($new_user);
 		$user->type = $tipo;
	    $user->image = $filename;
	    $user->api_key = $api_key;
	    $user->save(); 
	    
	    // start bundle 'resizer'
		Bundle::start('resizer');
		// resize image		
		$img = Input::file('image');
		
		$success = Resizer::open($img)
			->resize(120 , 120 , 'auto' )
			->save('public/uploads/thumbnails/users/'.$filename , 100 );

		// move uploaded file to public/uploads
		Input::upload('image', 'public/uploads/users', $filename);

	    return Redirect::to_action('home@login')
	    	->with('success_message', true);
	}

	public function get_login()
	{
    	return View::make('home.login');
	}

	public function post_login()
	{
		$remember = Input::get('remember');
 		$credentials = array(
 			'username' => Input::get('username'), 
 			'password' => Input::get('password'),
 			'remember' => !empty($remember) ? $remember : null
 		);
 		
    	if(Auth::attempt($credentials)){
		 	return Redirect::to_action('user@index');
		}else{
			return Redirect::to_action('home@login')
				->with_input('only', array('username')) 
				->with('error_login', true);
        }
	}

	public function get_club()
	{
		return View::make('user.club');
	}
	public function post_club()
	{
		$Validar_si_tiene_club = Club::where('user_id','=',Auth::user()->id)->first();
		if (is_null($Validar_si_tiene_club)) {
			$new_club = array(
		        'name'		=> Input::get('name'),
		        'description'  => Input::get('description'),
		        'image' => Input::file('image'),
		        'address'  => Input::get('address'),
		        'telephone'  => Input::get('telephone'),
		        'horary'  => Input::get('horary'),
		        'type'  => Input::get('type')
	    	);
	   
	    	$rules = array(
		        'name' => 'required|unique:users|match:/[a-z]+/|min:3|max:20',
		        'description' => 'required|match:/[a-z]+/|min:8|max:200',
		        'image' => 'required|image|mimes:jpg,png|max:1024',
		        'address' => 'required',
		        'telephone' => 'required|numeric',
		        'horary' => 'required|min:3|max:15',
		        'type' => 'required|match:/[a-z]+/|min:4|max:15'
	    	);
	    
		    $validation = Validator::make($new_club, $rules);

		    if ($validation->fails())
		    {   
		        return Redirect::to_action('home@club')
	                ->with('user', Auth::user())
	                ->with_errors($validation)
	                ->with_input('except', array('image'))
	                ->with('error_create_club', true);
		    }

			function generate_random_filename()
		    {
			    // create a random name
			    $filename = Str::random(20) .'.'. File::extension(Input::file('image.name'));

		    	//Validar si no existe ya ese nombre random el la DB
			    if (Restaurant::where_image($filename)->first()) {
			    	generate_random_filename();
			    }
			    return $filename;
		    }
		    $filename = generate_random_filename();

			$new_club['user_id'] = Auth::user()->id;
			// Save all in the database
		    $user = new Club($new_club);
		    $user->image = $filename;
		    $user->save(); 
		    
		    // start bundle 'resizer'
			Bundle::start('resizer');
			// resize image		
			$img = Input::file('image');
			
			$success = Resizer::open($img)
				->resize(120 , 120 , 'auto' )
				->save('public/uploads/thumbnails/clubs/'.$filename , 100 );

			// move uploaded file to public/uploads
			Input::upload('image', 'public/uploads/clubs', $filename);

		    return Redirect::to_action('user@index');
	    }else{
    		return Redirect::to_action('home@club')
            	->with('yaTiene', true);
	    }
	}

	public function get_restaurant()
	{
		return View::make('user.restaurant');
	}
	public function post_restaurant()
	{
		$Validar_si_tiene_restau = Restaurant::where('user_id','=',Auth::user()->id)->first();
		if (is_null($Validar_si_tiene_restau)) {
			$new_restaurants = array(
		        'name'		=> Input::get('name'),
		        'description'  => Input::get('description'),
		        'image' => Input::file('image'),
		        'address'  => Input::get('address'),
		        'telephone'  => Input::get('telephone'),
		        'type'  => Input::get('type')
	    	);
	   
	    	$rules = array(
		        'name' => 'required|unique:users|match:/[a-z]+/|min:3|max:20',
		        'description' => 'required|match:/[a-z]+/|min:8|max:200',
		        'image' => 'required|image|mimes:jpg,png|max:1024',
		        'address' => 'required',
		        'telephone' => 'required|numeric',
		        'type' => 'required|match:/[a-z]+/|min:4|max:15'
	    	);
	    
		    $validation = Validator::make($new_restaurants, $rules);

		    if ($validation->fails())
		    {   
		        return Redirect::to_action('home@restaurant')
	                ->with('user', Auth::user())
	                ->with_errors($validation)
	                ->with_input('except', array('image'))
	                ->with('error_create_restaurants', true);
		    }
		    function generate_random_filename()
		    {
		   	 	// create a random name
		    	$filename = Str::random(20) .'.'. File::extension(Input::file('image.name'));

		    	//Validar si no existe ya ese nombre random el la DB
			    if (Restaurant::where_image($filename)->first()) {
			    	generate_random_filename();
			    }
			    return $filename;
		    }
		    $filename = generate_random_filename();

		    $new_restaurants['user_id'] = Auth::user()->id;

			// Save all in the database
		    $user = new Restaurant($new_restaurants);
		    $user->image = $filename;
		    $user->save(); 
		    
		    // start bundle 'resizer'
			Bundle::start('resizer');
			// resize image		
			$img = Input::file('image');
			
			$success = Resizer::open($img)
				->resize(120 , 120 , 'auto' )
				->save('public/uploads/thumbnails/restaurants/'.$filename , 100 );

			// move uploaded file to public/uploads
			Input::upload('image', 'public/uploads/restaurants', $filename);

		    return Redirect::to_action('user@index');
	    }else{
	    	return Redirect::to_action('home@restaurant')
                ->with('yaTiene', true);
	    }
	}

	public function get_logout()
	{
		Auth::logout();
		return Redirect::to_action('home@login')->with('logout_message', true);
	}
}