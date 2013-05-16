<?php

class User_Controller extends Base_Controller {

	public $restful = true;    
	public function __construct()
	{
		$this->filter('before', 'auth');
	}
	public function get_index()
    {
    	return View::make('user.index');
    }    
    public function get_configUser()
    {
    	return View::make('user.configUser');
    }
    public function post_configUser()
    {
    	$rules = array(
            'image' => 'image|mimes:jpg,png,jgeg|max:1024',
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