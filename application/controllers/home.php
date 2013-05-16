<?php

class Home_Controller extends Base_Controller {
	public $restful = true;
	public function __construct() 
    {
        $this->filter('before', 'csrf')->on('post');
    }
	public function get_index()
	{
		if (Auth::guest()){
			return View::make('home.index');
		}else {
			return View::make('user.index');
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
	        'bio'  => Input::get('bio'),
	        'telephone'  => Input::get('telephone'),
	        'email'  => Input::get('email'),
	        'musictype'  => Input::get('musictype'),
	        'image' => Input::file('image'),
	        'password'  => Input::get('nuevo_password')
    	);
   
    	$rules = array(
	        'name' => 'required|match:/[a-z]+/|min:3|max:20',
	        'bio' => 'required|match:/[a-z]+/|min:8|max:200',
	        'telephone' => 'required|numeric',
	        'email' => 'required|unique:users|email',
	        'musictype' => 'required|match:/[a-z]+/',
	        'image' => 'image|mimes:jpg,png,jgeg|max:1024',
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

	    // create filename
	    $filename = Input::file('image.name');
 
		// Save all in the database
	    $user = new User($new_user);
	    $user->image = $filename;
	    $user->save(); 
	    
	    // start bundle 'resizer'
		Bundle::start('resizer');
		// resize image		
		$img = Input::file('image');
		
		$success = Resizer::open($img)
			->resize(120 , 120 , 'auto' )
			->save('public/uploads/thumbnails/'.$filename , 100 );

		// move uploaded file to public/uploads
		Input::upload('image', 'public/uploads', $filename);

	    return Redirect::to_action('home@login')->with('success_message', true);
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

	public function get_logout()
	{
		Auth::logout();
		return Redirect::to_action('home@login')->with('logout_message', true);
	}
}