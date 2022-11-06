<?php 

session_start();

$GLOBALS['config'] = array(

	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'db' => 'ripple'

	),
	'app' => array(
		'name' => '<span class="ex">X</span>TRIM</a>',
		'version' => 1.0,
		'developer' => 'MuhammadNuruddin'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800
	),
	'session' => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)

);



spl_autoload_register(function($class){
	require_once 'classes/'.$class.'.php';
});



require_once 'functions/sanitize.php';


if (Cookie::exists(Config::get('remember.cookie_name')) && !Session::exists(Config::get('session.session_name'))) {
	$hash = Cookie::get(Config::get('remember.cookie_name'));
	$hash_check = DB::connect()->select('users_session', array('hash', '=', $hash));
	if ($hash_check->count()) {
		$user = new User($hash_check->first()->user_id);		
		$user->login();
			Session::put('loggedIn', true);
			Session::put('username', $user->data()->username);
			Session::put('email', $user->data()->email);
			Session::put('userId', $user->data()->id);
	}
}
