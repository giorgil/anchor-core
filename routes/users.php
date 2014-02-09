<?php

use Ship\Routing\Route;

/*
 * List all
 */
$app['router']->add(new Route('admin/users', array(
	'conditions' => array($auth, $csrf),
	'requirements' => array('method' => 'GET'),
	'controller' => array($app['controllers']->backend('Users', $app), 'index')
)));



/*
$app['router']->register('GET', 'admin/amnesia', array('before' => 'guest', 'main' => function() {
	$vars['messages'] = Notify::read();
	$vars['token'] = Csrf::token();

	return View::create('users/amnesia', $vars)
		->partial('header', 'partials/header')
		->partial('footer', 'partials/footer');
}));

$app['router']->register('POST', 'admin/amnesia', array('before' => 'csrf', 'main' => function() {
	$email = Input::get('email');

	$validator = new Validator(array('email' => $email));
	$query = User::where('email', '=', $email);

	$validator->add('valid', function($email) use($query) {
		return $query->count();
	});

	$validator->check('email')
		->is_email(__('users.email_missing'))
		->is_valid(__('users.email_not_found'));

	if($errors = $validator->errors()) {
		Input::flash();

		Notify::error($errors);

		return Response::redirect('admin/amnesia');
	}

	$user = $query->fetch();
	Session::put('user', $user->id);

	$token = noise(8);
	Session::put('token', $token);

	$uri = Uri::full('admin/reset/' . $token);
	$subject = __('users.recovery_subject');
	$msg = __('users.recovery_message', $uri);

	mail($user->email, $subject, $msg);

	Notify::success(__('users.recovery_sent'));

	return Response::redirect('admin/login');
}));

$app['router']->register('GET', 'admin/reset/(:any)', array('before' => 'guest', 'main' => function($key) {
	$vars['messages'] = Notify::read();
	$vars['token'] = Csrf::token();
	$vars['key'] = ($token = Session::get('token'));

	if($token != $key) {
		Notify::error(__('users.recovery_expired'));

		return Response::redirect('admin/login');
	}

	return View::create('users/reset', $vars)
		->partial('header', 'partials/header')
		->partial('footer', 'partials/footer');
}));

$app['router']->register('POST', 'admin/reset/(:any)', array('before' => 'csrf', 'main' => function($key) {
	$password = Input::get('pass');
	$token = Session::get('token');
	$user = Session::get('user');

	if($token != $key) {
		Notify::error(__('users.recovery_expired'));

		return Response::redirect('admin/login');
	}

	$validator = new Validator(array('password' => $password));

	$validator->check('password')
		->is_max(6, __('users.password_too_short', 6));

	if($errors = $validator->errors()) {
		Input::flash();

		Notify::error($errors);

		return Response::redirect('admin/reset/' . $key);
	}

	User::update($user, array(
		'password' => password_hash($password, PASSWORD_BCRYPT)
	));

	Session::erase('user');
	Session::erase('token');

	Notify::success(__('users.password_reset'));

	return Response::redirect('admin/login');
}));

$app['router']->register('GET', 'admin/upgrade', function() {
	$vars['messages'] = Notify::read();
	$vars['token'] = Csrf::token();

	$version = Config::meta('update_version');
	$url = 'https://github.com/anchorcms/anchor-cms/archive/%s.zip';

	$vars['version'] = $version;
	$vars['url'] = sprintf($url, $version);

	return View::create('upgrade', $vars)
		->partial('header', 'partials/header')
		->partial('footer', 'partials/footer');
});

$app['router']->register('GET', 'admin/extend', array('before' => 'auth', 'main' => function($page = 1) {
	$vars['messages'] = Notify::read();
	$vars['token'] = Csrf::token();

	return View::create('extend/index', $vars)
		->partial('nav', 'extend/nav')
		->partial('header', 'partials/header')
		->partial('footer', 'partials/footer');
}));

*/