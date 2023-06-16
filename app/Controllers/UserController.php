<?php
/**
 * 	@author: $rachow
 * 	@copyright: CF Partners 2023
 *
 * 	Users CRUD Operation Logics Controller 
 */

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
	/*
	 * @var db
	 * database connection thread.
	*/
	protected $db;

	public function __construct()
	{
		$this->init();
	}

	/**
	 * Object init stuff goes here.
	 *
	 * @param  none
	 * @return void
	*/
	protected function init()
	{
		// grab the request object.
		$request = \Config\Services::request();

		// force secure app access for prod .!$
		// Note: better = this can actually also be done through Mod Rewrite Rule in HTACCESS,
		// for a Reverse Proxy like Nginx use a directive.

		if(!$request->isSecure() && ENVIRONMENT == 'production'){
			force_https();
		}

		/**
		 * make the DB connection available
		 * what about persistent connections/pool in high load setup ?
		*/

		$this->db = \Config\Database::connect();
	}

	public function before()
	{
		return redirect()->to('/');
	}

	/**
	 * Shifted this to a routine, for checks on logged in state.
	 *
	 * @param  none
	 * @return mixed
	*/
	protected function check_user_logged_in()
	{
		$session = \Config\Services::session(); // obtain session object (shared).

		$user_info = $session->get('user_info');
		$logged_in = @$user_info['logged_in'];	// surpress for any errors thrown.

		// verify the logged in state.

		if($logged_in !== true){

			/*
			 * BAM: is there a XHR incomming ? 
			 *    will work with X-Requested-With header!
			*/
			if($this->request->isAJAX()){

				header('HTTP/1.1 401 Unauthorized', true, 401);
				header('Content-Type: application/json');
				exit(json_encode([
					'msg'	=> 'Authentication failed. Please login.',
					'code'	=> 401
				]));
			}

			// solution to stop CI to continue running caller methods.

			header('HTTP/1.1 401 Unauthorized', true, 401);
			header('Location: /user/login');
			exit;
		}
	}

	/**
	 * Grab the user info for use by app.
	 *
	 * @param  none
	 * @return array
	*/
	protected function user_info()
	{
		$session = \Config\Services::session();

		// default the values
		$user_info = [
			'id' 		=> '000',
			'title' 	=> 'Mr',
			'firstname'	=> 'John',
			'lastname'	=> 'Brown',
		];

		if($session->has('user_info')) {
			$user_info = $session->get('user_info');
		}

		return $user_info;
	}

	/**
	 * Verify if the chosen username already exists on the platform.
	 * BAM: Do users choose to login using username or email, 
	 * 	we will check by pattern match decide ?
	 *
	 * @param  $username
	 * @return json
	 */
	public function check_username()
	{
		$this->check_user_logged_in();

		$method = strtoupper($this->request->getMethod());

		// verify an XHR request, expecting 'X-Requested-With' header.
		// consider permanent force of header for Axios, VueJS, React! :D

		if($method != 'GET' || !$this->request->isAJAX()) { 
			exit('Operation not allowed.');
		}

		$username = $this->request->getGet('username');

		$output = [
			'msg'  => 'Username is ok.',
			'code' => 200
		];

		// quick and dirty, ideally needs to go to model layer = MVC/HMVC !
		$sql = 'SELECT username FROM cf_users WHERE username=?';
		$result = $this->db->query($sql, $username);
		$db_error = $this->db->error();
		
		if(isset($db_error['code']) && $db_error['code'] > 0){

			// notify the ops team, stability centre ? - Bugsnag/Sentry
			// you will need to grab the DB backstrace and push to a pipeline for error reporting.
			// ELK stack.

			log_message('error', implode("\r\n", $db_error));
			$output['msg'] = 'Oops something went wrong.';
			$output['code'] = 400;
		}

		if($result->getNumRows() > 0) {
			$output['msg'] = 'Username already taken.';
			$output['code'] = 400;
		}

		// tamper the Respose object and fire JSON fast!

		return response()->setContentType('application/json')
		   ->setStatusCode(200)
	   		->setJSON($output);
	}

	/**
	 * Verify if the chosen email already exists on the platform.
	 *
	 * @param  $email
	 * @return json
	*/
	public function check_email()
	{
		$this->check_user_logged_in();

		$method = strtoupper($this->request->getMethod());

		if($method != 'GET' || !$this->request->isAJAX()) {
			exit('Operation not allowed.');
		}
		
		$email = $this->request->getGet('email');

		// let's go ahead and check, note that
		// when the system is heavy caching can be implemented !.$
		// tip: save the trip to resource = DB ~ QPS. What is the DB topology/cluster ..? 

		$output = [
			'msg'  => 'Email is ok.',
			'code' => 200		
		];

		// quick and dirty with query binding in place.

		$stmnt = 'SELECT email FROM cf_users WHERE email=?';	
		$results = $this->db->query($stmnt, $email);

		$db_error = $this->db->error(); // get a handle on the errors .!$

		/**
		 * for email checks and validity, filter validate
		 * but importantly do DNS MX record checks.
		 * 	go with a REST API endpoint !
		*/

		if(isset($db_error['code']) && $db_error['code'] > 0){

			// notify the ops team, stability centre ? - Bugsnag/Sentry
			// you will need to grab the DB backstrace and push to a pipeline for error reporting.
			// ELK stack.

			log_message('error', implode("\r\n", $db_error));
			$output['msg'] = 'Oops something went wrong.';
			$output['code'] = 400;
		}

		if($results->getNumRows() > 0) {
			$output['msg'] = 'Email already taken.';
			$output['code'] = 400;
		}

		// tamper with the Response (shared) object and fire JSON ridiculously fast!

		return response()->setContentType('application/json')
		   ->setStatusCode(200)
	   		->setJSON($output);
	}

	/**
	 * Searching the platform WIKI, dummy!
	 *
	 * @param  none
	 * @return \View
	*/
	public function search()
	{
		// check user logged in.

		$this->check_user_logged_in();
	
		$data = [
			'title'		=> 'Search results',
			'keywords'	=> 'Search',
			'description'	=> '',
		];
		
		$data += $this->user_info();

		return view('/user/search', $data);
	}

	/**
	 * App's default landing logic.
	 *
	 * @param  none
	 * @return \View 
	*/
	public function index()
	{
		/**
		 * redirect default landing to dashboard route.
		*/
		return redirect()->to('/user/dashboard');
	}

	/**
	 * Render the dashboard that displays the users in app.
	 *
	 * @param none
	 * @return \View
	*/
	public function dashboard()
	{
		// check user logged in.

		$this->check_user_logged_in();

		$data = [
			'title'		=> 'Dashboard',
			'keywords'	=> '',
			'description'	=> '',
		];

		$data += $this->user_info();

		// render users dashboard.

		return view('user/dashboard', $data);
	}

	/**
	 * App's login logic and redirect to dashboard.
	 * 
	 * @param  mixed
	 * @return mixed
	*/
	public function login()
	{	
		/**
		 * verify if the user already logged in, if so
		 * then redirect to dashboard route.
		*/

		$session = \Config\Services::session();

		$user_info = $session->get('user_info');
		$logged_in = @$user_info['logged_in'];

		if($logged_in === true) {
			
			return redirect()->to('/user/dashboard'); // already logged in, goto dashboard.
		}

		$username = $password = null;
		$remember = $check_by_email = false;
	
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');
		$remember = $this->request->getPost('remember');
		$check_fld = 'username';
		$check_val = $username;

		$method = strtoupper($this->request->getMethod());

		// SEO related tags. Manage ideally through CMS <3 .!
		// things like, Canonical URL, Robots, OGP tags can be managed.

		$data = [
			'title' 	=> 'Login',
			'keywords' 	=> 'login',
			'description' 	=> 'CF app account login.'
		];

		if($method == 'GET') {

			return view('user/login', $data); // render the login view.
		}

		if(preg_match("/\@.+/", $username)) {

			$check_by_email = true; // flag for email check based on pattern match.
			$check_fld = 'email'; 
		}

		$userModel = new UserModel(); // ORM based approach.

		// grab user details based on field + value.
	
		$user_data = $userModel->where($check_fld, $check_val)->first();
		
		if(!$user_data) {
	
			$session->setFlashData('error', 'Credentials are invalid.');
			return redirect()->to('/user/login');
		}

		$pwd = $user_data['password'];

		$authenticated = password_verify($password, $pwd); // password verification on PASSWORD_BCRYPT.

		// dd($user_data); - any buggery here :S!

		if(!$authenticated) {
			$session->setFlashData('error', 'Credentials are invalid.');
			return redirect()->to('/user/login');
		}
		
		$user_info = [
			'id' 		=> $user_data['id'],
			'title' 	=> $user_data['title'],
			'firstname' 	=> $user_data['firstname'],
			'lastname' 	=> $user_data['lastname'],
			'email' 	=> $user_data['email'],
			'logged_in' 	=> true,
		];

		$session->set('user_info', $user_info);

		// user has been verified, redirect to dashboard.

		return redirect()->to('/user/dashboard');
	}

	/**
	 * App's logout logic and redirect to login.
	 *
	 * @param  none
	 * @return none
	*/
	public function logout()
	{
		$session = \Config\Services::session();

		// delete entire session.
		$session->destroy();

		// force request redirection to login page.
		return redirect()->to('/user/login');
	}

	/**
	 * *******************************************************************
	 * 	13-06-2023	
	 * 	Users CRUD Operations from this section onward.
	 *
	 * ********************************************************************
	*/	

	/**
	 * Create a new user in the app.
	 *
	 * @param  mixed 
	 * @return \View
	*/
	public function create_user()
	{
		$this->check_user_logged_in();

		// ensure data is safe, things like XSS attacks
		// should be handled by the MVC itself.

		// HTTP method spoofing also incorported here if needed in future!
		// e.g. _method=PUT etc = RESTful not Browserful - haha :D

		$method = strtoupper($this->request->getMethod());

		$data = [
			'title' 	=> 'Add User',
			'keywords' 	=> 'Add User',
			'description'	=> 'Add a new user to the CF platform.'
		];

		$data += $this->user_info();

		if($method == 'POST')
		{
			helper(['form']);

			$rules = [
				'title' 	=> 'required',
				'firstname'	=> 'required|min_length[3]|max_length[100]',
				'lastname'	=> 'required|min_length[3]|max_length[100]',
				'username'	=> 'required|min_length[8]|max_length[255]',
				'mobile'	=> 'max_length[14]',
				'email'		=> 'required|min_length[3]|max_length[255]|valid_email|is_unique[cf_users.email]',
				'password'	=> 'required|min_length[8]|max_length[50]',
				'confirm'	=> 'matches[password]',
			];

			if(!$this->validate($rules)) { 
				
				// validate early and flush!
				// redirect here and add error in session

				return redirect()->to('/user/create')
		     			->withInput()->with('validation', $this->validator);
			}

			// rock'n roll, we can proceed to save!

			$post_data = $this->request->getPost();

			$title 		= $post_data['title'];
			$firstname	= $post_data['firstname'];
			$lastname	= $post_data['lastname'];
			$username	= $post_data['username'];
			$email		= $post_data['email'];
			$mobile		= $post_data['mobile'];
			$password	= $post_data['password'];

			// use bcrypt algo for securing passwords.
			// salting was a way.

			$password = password_hash($password, PASSWORD_BCRYPT);

			/**
			 * Transaction based handling. DB := InnoDB (MySQL)
			 * allows us to rollback when things are tits up!
			 * 	check procs, threads, deadlocks, setup issue's ? master/slave replica ..
			*/

			$this->db->transBegin();
			$sql = "INSERT INTO cf_users (title,firstname,lastname,mobile,email,username,password) VALUES (?,?,?,?,?,?,?)";
			$this->db->query($sql, [
				$title, $firstname, $lastname, $mobile, $email,
				$username, $password
			]);
		
			if($this->db->transStatus() === FALSE)
			{	
				/**
				 * Push error stack/bugtrace to stability centre, devops need
				 * to be aware!
				 * 	Options +=
				 * 		1. Write to log file in FS/S3 = cloud, etc
				 * 		2. Integrate Bug Reporting tools like Bugsnag/Sentry
				 * 		   which handle alerting the teams
				*/

				$this->db->transRollback(); // rollback changes.
				$db_error = $this->db->error();

				log_message('critical', implode("\r\n", $db_error));

				// redirect with a flash message to user.
				
				return redirect()->to('/user/create')
		     			->with('error', 'Something went wrong. Try again.');

			}else{
				$this->db->transCommit(); // commit

				return redirect()->to('/user/dashboard')
		    			->with('message', 'User has been added succesfully.');
			}
		}

		return view('user/add', $data);
	}

	/**
	 * Grab a specific app user for view/edit identified by
	 * record id.
	 *
	 * @param  $user_id
	 * @return \View
	*/
	public function edit_user($user_id)
	{
		// check user logged in.

		$this->check_user_logged_in();

		/**
		 * Grab a specific user for edit purposes, URL injected id
		 * consider use of UUID in future. 
		*/

		// verify that the user exists.
		
		$userModel = new UserModel();

		if(!$user_id || !($user = $userModel->find($user_id))){
			return redirect()->to('/user/dashboard');
		}

		$data = [
			'title'		=> 'Edit User',
			'keywords'	=> 'Edit User',
			'description'	=> 'Edit current user on the CF platform.',
			'user'		=> $user,			
		];

		$data += $this->user_info();
		return view('user/edit', $data);
	}

	/**
	 * Grab all the users in the app and apply filters.
	 *
	 * @param mixed
	 * @param filter[x]=x
	*/
	public function get_users()
	{
		$this->check_user_logged_in();

		// verify request is XHR, remember based on 'X-Requested-With' header.
		// for others like fetch API in browser, enforce header, even beacon.

		if(!$this->request->isAJAX()) {
			exit('No direct access allowed.');
		}

		// prefer ORM approach, and fact of data modelling separation .!$

		$userModel = new UserModel();

		$users = $userModel->findAll();	

		// get shared Response object, and tamper for speedy JSON response.

		// hey slow down here, just for demo ;)
		usleep(300000);
			
		$response = [
			'code' 		=> 200,
			'total_rows'	=> 0,
			'per_page'	=> 0,
			'page'		=> 1,
			'data'	=> $users
		];

		return response()->setContentType('application/json')
		   ->setStatusCode(200)
	   		->setJSON($response);
	}

	/**
	 * Update specific user identified by record id.
	 *
	 * @param  $user_id
	 * @return mixed
	*/
	public function update_user($user_id)
	{
		$this->check_user_logged_in();

		/**
		 * Updating of user in the app.
		 * For simplicity we include the AUTO_INCREMENT ID in URL, /edit/[:id], explore UUID
		 * for better approach and consider storing as binary in DB for less DSK usage.
		 */

		$userModel = new UserModel();

		if(!$user_id || !($user = $userModel->find($user_id))){
			return redirect()->to('/user/dashboard');
		}

		// rules for validation - the start.
	
		$rules = [
			'title' 	=> 'required',
			'firstname'	=> 'required|min_length[3]|max_length[100]',
			'lastname'	=> 'required|min_length[3]|max_length[100]',
			'mobile'	=> 'max_length[14]',
		];

		// hold the POST data.
		$post_data = $this->request->getPost();
		
		$title		= $post_data['title'];
		$firstname	= $post_data['firstname'];
		$lastname	= $post_data['lastname'];
		$username	= $post_data['username'];
		$mobile		= $post_data['mobile'];
		$email		= $post_data['email'];
		$password	= $post_data['password'];

		// let's play with the rules for a bit.
		$user_email = $user['email'];
		$user_username = $user['username'];

		// different username supplied.
		if(!($username == $user_username)){
			$rules['username'] = 'required|min_length[8]|max_length[255]';
		}

		// different email supplied.
		if(!($email == $user_email)){
			$rules['email'] = 'required|min_length[3]|max_length[255]|valid_email|is_unique[cf_users.email]';
		}
		// intention to change password
		if(!empty($password)){
			$rules['password'] = 'required|min_length[8]|max_length[50]';
			$rules['confirm'] = 'matches[password]';
		}

		if(!$this->validate($rules)) { 
				
			// validate early and flush!
			// we could have done a 301 redirect, and keep errors in session bag!
				
			$validation = $this->validator;
			return redirect()->back()->withInput()->with('validation', $validation);
		}

		if(!empty($password)){
			$password = password_hash($password, PASSWORD_BCRYPT);
			$userModel->update($user_id, ['password' => $password]);
		}

		$userModel->update($user_id, [
			'title'		=> $title,
			'firstname' 	=> $firstname,
			'lastname'  	=> $lastname,
			'username'  	=> $username,
			'email'		=> $email,
			'mobile'	=> $mobile,
		]);

		return redirect()->back()
		   	->with('message', 'User record was updated.');
	}

	/**
	 * Removal of user from the platform.
	 *
	 * @param  $user_id
	 * @return mixed
	*/
	public function remove_user($user_id)
	{
		/*
		 * Removal of user from app.
		 * Not best practice to include user ID in URL /remove/[:id], for simplicity yes for now
		 * but consider UUID, such as UUID version 4, /remove/xxx-xxx-xxx, stopping the guess work!
		 * this will also require changes to DB schema, for UUID support and store/retrieve = funcs/stored procs, binary = <3!.
		*/

		// not necessary as Routing binded to method, but okay...

		$method = strtoupper($this->request->getMethod());

		if($method != 'GET' || !$this->request->isAJAX()) { 
			exit('Operation not allowed.');
		}

		// quick and dirty ?

		$userModel = new UserModel();
		$userModel->delete($user_id);

		return response()->setContentType('application/json')
		   ->setStatusCode(200)
		   ->setJSON([
			'code' 	=> 200,
			'msg'	=> 'User has been removed.',
		   ]);
	}
}
