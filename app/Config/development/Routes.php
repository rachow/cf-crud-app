<?php
/**
 *	@author: $rachow
 *	@copyright: CF Partners 2023
 *
 *	Custom Routing logics for developments.
*/

// verify the ini configs and ext paths only in development.
$routes->get('/dump', function(){
	phpinfo();
});

// $cmd = './spark routes' - grab routes.

// bypass login process.
/*
$routes->get('/user/rahel/dashboard', function(){
	$title = 'Dashboard'; 
	$body_class = 'ng-cfx';
	$firstname = 'Rahel';
	$lastname = 'Chowdhury';
	return view('user/dashboard', compact(['title', 'body_class', 'firstname', 'lastname']));
});
*/

$routes->get('/hash-password', function(){
	$request = \Config\Services::request();
	$pwd = $request->getVar('pwd');
	echo password_hash($pwd, PASSWORD_BCRYPT);
});


