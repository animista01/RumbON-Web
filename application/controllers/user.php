<?php

class User_Controller extends Base_Controller {

	public $restful = true;    
	public function __construct()
	{
		$this->filter('before', 'auth');
	}
	public function get_index()
    {
    	$discotecas_Usu = Club::where('user_id','=',Auth::user()->id)->first();
    	$restaurantes_Usu = Restaurant::where('user_id','=',Auth::user()->id)->first();
    	return View::make('user.index')
    		->with('club', $discotecas_Usu)
    		->with('restaurant', $restaurantes_Usu);
    }    
    public function get_profile()
	{
		return View::make('user.profile');
	}

	public function get_adminrestaurant($id)
	{
		$restaurante_Usu = Restaurant::where('user_id','=',Auth::user()->id);
		$restaurante_Usu = $restaurante_Usu->where('id','=',$id)->first();
		return View::make('user.restaurante')
			->with('restaurant', $restaurante_Usu);
	}
	public function get_adminclub($id)
	{
		$discoteca_Usu = Club::where('user_id','=',Auth::user()->id);
		$discoteca_Usu = $discoteca_Usu->where('id','=',$id)->first();
		return View::make('user.discoteca')
			->with('club', $discoteca_Usu);
	}

    public function get_configUser()
    {
    	return View::make('user.configUser');
    }
    public function post_configUser()
    {
    	$rules = array(
            'image' => 'image|mimes:jpg,png|max:1024',
        );
 
        $validation = Validator::make(Input::file('image'), $rules);
 
        // create random filename
		$filename = Str::random(20) .'.'. File::extension(Input::file('image.name'));
 
		// Save logo in the database
		$event = Events::where('user_id', '=', $id)->first();
		$event->image = $filename;
		$event->save();
		
		// start bundle 'resizer'
		Bundle::start('resizer');
		// resize image		
		$img = Input::file('image');
		
		$success = Resizer::open($img)
			->resize(120 , 120 , 'auto' )
			->save('public/uploads/images/'.$filename , 100 );
 
		// move uploaded file to public/uploads
		Input::upload('image', 'public/uploads', $filename);
    }
	

}