<?php

class User_Controller extends Base_Controller {

	public $restful = true;    
	public function __construct()
	{
		$this->filter('before', 'auth');
	}
	public function get_index()
    {
    	//tomamos el tipo de usuario
    	$user_type = User::where('id','=',Auth::user()->id)->only('type');

    	if ($user_type == 1) {
	    	$promociones = Promotion::order_by('created_at','desc')->paginate(10);
	    	return View::make('user.index')
	    		->with('promotions', $promociones);
    	}elseif ($user_type == 2) {
    		$discotecas_Usu = Club::where('user_id','=',Auth::user()->id)->first();
    		return View::make('user.index')
	    		->with('club', $discotecas_Usu);
    	}elseif ($user_type == 3) {
	    	$restaurantes_Usu = Restaurant::where('user_id','=',Auth::user()->id)->first();
    		return View::make('user.index')
	    		->with('restaurant', $restaurantes_Usu);
    	}
    } 
    //Perfil del usuario   
    public function get_profile()
	{
		return View::make('user.profile');
	}
	//Club seleccionado por un usuario normal
	public function get_club($id)
	{
		$club = Club::where_id($id)->first();
		$promociones = Promotion::where('club_id','=',$id);
		$promocion = $promociones->order_by('created_at','desc')->paginate(10);

		return View::make('user.showclub')
			->with('club', $club)
			->with('promociones', $promocion);
	}

	//Administrar Restaurante
	public function get_adminrestaurant($id)
	{
		$restaurante_Usu = Restaurant::where('user_id','=',Auth::user()->id);
		$restaurante_Usu = $restaurante_Usu->where('id','=',$id)->first();
		return View::make('user.restaurante')
			->with('restaurant', $restaurante_Usu);
	}

	public function post_restaurantstatus($status)
	{
		$Restaurante_id = Restaurant::where('user_id','=',Auth::user()->id)->only('id');

		$restaurante_status = Restaurant::where('user_id','=',Auth::user()->id)->only('status');

		$ejec = Restaurant::update($Restaurante_id, array(
			'status' => $status
		));
		if ($ejec) {
			return "OK";
		}else{
			return "Error";
		}
		
	}	

	//Administrar Discoteca(Subir una nueva promocion)
	public function get_adminclub($id)
	{
		$discoteca_Usu = Club::where('user_id','=',Auth::user()->id);
		$discoteca_Usu = $discoteca_Usu->where('id','=',$id)->first();
		return View::make('user.discoteca')
			->with('club', $discoteca_Usu);
	}
	public function post_adminclub($id)
	{
		$new_promotion = array(
	        'image' => Input::file('image'),
	        'body'  => Input::get('body')
    	);
   
    	$rules = array(
	        'image' => 'required|image|mimes:jpg,png|max:2024',
	        'body' => 'required|match:/[a-z]+/|min:5|max:200'
    	);
    
	    $validation = Validator::make($new_promotion, $rules);

	    if ($validation->fails())
	    {   
	        return Redirect::to_action('user@adminclub/'.$id)
                ->with_errors($validation)
                ->with_input('except', array('image'))
                ->with('error_create_promotion', true);
	    }

		function generate_random_filename()
	    {
		    // create a random name
		    $filename = Str::random(30) .'.'. File::extension(Input::file('image.name'));

	    	//Validar si no existe ya ese nombre random el la DB
		    if (Promotion::where_image($filename)->first()) {
		    	generate_random_filename();
		    }
		    return $filename;
	    }
	    $filename = generate_random_filename();

		// Save all in the database
		$new_promotion['club_id'] = $id;
	    $promotion = new Promotion($new_promotion);
	    $promotion->image = $filename;
	    $promotion->save(); 
	    
	    // start bundle 'resizer'
		Bundle::start('resizer');
		// resize image		
		$img = Input::file('image');
		
		$success = Resizer::open($img)
			->resize(200 , 200 , 'auto' )
			->save('public/uploads/thumbnails/clubs/promotions/'.$filename , 100);

		// move uploaded file to public/uploads
		Input::upload('image', 'public/uploads/clubs/promotions', $filename);

	    return Redirect::to_action('user@index');
	}

    public function get_edituser($id)
    {
    	return View::make('user.edit')
    		->with('user', User::find($id));
    }
    public function put_edituser()
    {
    	$id = Auth::user()->id;
		$edit_user = array(
	        'name'		=> Input::get('name'),
	        'telephone'  => Input::get('telephone')
    	);
    	$rules = array(
            'name' => 'required|match:/[a-z]+/|min:3|max:20',
	        'telephone' => 'required|numeric'
        );
 
        $validation = Validator::make($edit_user, $rules);
        
 		if ($validation->fails())
	    {   
	        return Redirect::to_action('user@edituser/'.$id)
                ->with_errors($validation)
                ->with('error_edit', true);
	    }else{
		    // Save all in the database
		    User::update($id, array(
		        'name'=> $edit_user['name'],
		        'telephone'=> $edit_user['telephone']
			));

			return Redirect::to_action('user@index');
	    }
    }
    //Editar Discoteca
    public function get_editdisco($id)
    {
    	return View::make('user.editclub')
    		->with('club', Club::find($id));
    }
    public function put_editdisco()
    {
    	$id = Auth::user()->club->id;
		$edit_user_club = array(
	        'name'		=> Input::get('name'),
	        'description'  => Input::get('description'),
	        'horary'  => Input::get('horary'),
	        'address'  => Input::get('address'),
	        'telephone'  => Input::get('telephone'),
	        'type'  => Input::get('type')
    	);
    	$rules = array(
            'name' => 'required|match:/[a-z]+/|min:3|max:20',
	        'description' => 'required|match:/[a-z]+/|min:8|max:200',
	        'address' => 'required',
	        'telephone' => 'required|numeric',
	        'horary' => 'required|min:3|max:15',
	        'type' => 'required|match:/[a-z]+/|min:4|max:15'
        );
 
        $validation = Validator::make($edit_user_club, $rules);
        
 		if ($validation->fails())
	    {   
	        return Redirect::to_action('user@editdisco/'.$id)
                ->with_errors($validation)
                ->with('error_edit', true);
	    }else{
		    // Save all in the database
		    Club::update($id, array(
		        'name'=> $edit_user_club['name'],
		        'telephone'=> $edit_user_club['telephone'],
		        'description'=> $edit_user_club['description'],
		        'address'=> $edit_user_club['address'],
		        'horary'=> $edit_user_club['horary'],
		        'type'=> $edit_user_club['type']
			));

			return Redirect::to_action('user@index');
	    }
    }
    //Editar Restaurante
    public function get_editrest($id)
    {
    	return View::make('user.editrest')
    		->with('restaurant', Restaurant::find($id));	
    }
    public function put_editrest()
    {
    	$id = Auth::user()->restaurant->id;
		$edit_user_rest = array(
	        'name'		=> Input::get('name'),
	        'description'  => Input::get('description'),
	        'telephone'  => Input::get('telephone'),
	        'address'  => Input::get('address'),
	        'type'  => Input::get('type')
    	);
    	$rules = array(
            'name' => 'required|match:/[a-z]+/|min:3|max:20',
	        'description' => 'required|match:/[a-z]+/|min:8|max:200',
	        'address' => 'required',
	        'telephone' => 'required|numeric',
	        'type' => 'required|match:/[a-z]+/|min:4|max:15'
        );
 
        $validation = Validator::make($edit_user_rest, $rules);
        
 		if ($validation->fails())
	    {   
	        return Redirect::to_action('user@editrest/'.$id)
                ->with_errors($validation)
                ->with('error_edit', true);
	    }else{
		    // Save all in the database
		    Restaurant::update($id, array(
		        'name'=> $edit_user_rest['name'],
		        'telephone'=> $edit_user_rest['telephone'],
		        'description'=> $edit_user_rest['description'],
		        'address'=> $edit_user_rest['address'],
		        'type'=> $edit_user_rest['type']
			));

			return Redirect::to_action('user@index');
	    }
    }

    //Eliminar una Discoteca
    public function delete_club()
	{
		Club::find(Input::get('id'))->delete();
		return Redirect::to_action('user@index')
		->with('message', 'La Discoteca fue elminada exitosamente!');
	}
	//Eliminar un Restaurante
	public function delete_restaurant()
	{
		Restaurant::find(Input::get('id'))->delete();
		return Redirect::to_action('user@index')
		->with('message', 'El Restaurante fue elminado exitosamente!');
	}
}