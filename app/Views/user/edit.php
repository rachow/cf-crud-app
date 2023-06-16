<?php
/**
 *	@author: $rachow
 *	@copyright: CF Partners 2023
 *
 * 	View/Edit user view
 *	todo: break the presentation with layout files <3!
 *	      thus more modular and easier to inject content.
 *
*/

$errors = [];
$session = session();

if($session->has('validation')){
	$validation = $session->get('validation');
	$errors = $validation->getErrors();
	$session->remove('validation');
}

/**
 * wacky: capture from session flash data if found.
*/

if($title = old('title'))
	$user['title'] = $title;

if($firstname = old('firstname'))
	$user['firstname'] = $firstname;

if($lastname = old('lastname'))
	$user['lastname'] = $lastname;

if($username = old('username'))
	$user['username'] = $username;

if($mobile = old('mobile'))
	$user['mobile'] = $mobile;

if($email = old('email'))
	$user['email'] = $email;

// no caching !
header('Pragma: no-cache');
?>
<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="robots" content="noindex,nofollow">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="/favicon.ico" rel="shortcut icon" type="image/png">
   <link href="/assets/dist/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
   <link href="/assets/dist/css/sb-admin-2.css" rel="stylesheet" type="text/css">
   <title><?php echo isset($title) ? $title . ' - ' . config('System')->siteName : config('System')->siteName; ?></title>
</head>
<body id="page-top" <?php if(isset($body_class)): echo 'class="' . $body_class . '"'; endif;?>>
	<div id="wrapper">
		<!-- !! kick ass sidebar !! -->
        	<ul class="navbar-nav bg-dark text-white sidebar sidebar-dark accordion" id="accordionSidebar">
			<!-- brand logo -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
				<img src="/assets/dist/images/cf-partners-logo.png" class="d-block" style="width:200px;height:auto;">
			</a>
			<hr class="sidebar-divider my-0">
			<small class="text-center mt-2">version 1.0.0</small>
           		<li class="nav-item active">
                		<a class="nav-link" href="/user/dashboard">
                    			<i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
				</a>
            		</li>
			<hr class="sidebar-divider">
			<li class="nav-item active">
				<a class="nav-link" href="/user/dashboard">
					<i class="fas fa-fw fa-users"></i><span>Manage Users</span>
				</a>
			</li>
			<hr class="sidebar-divider">
			<li class="nav-item active">
				<a class="nav-link" href="/user/reports">
					<i class="fas fa-fw fa-chart-pie"></i><span>Manage Reports</span>
				</a>
			</li>
			<hr class="sidebar-divider">
			<li class="nav-item active">
				<a class="nav-link" href="/user/logout">
					<i class="fas fa-fw fa-sign-out-alt"></i><span>Logout</span>
				</a>
			</li>
		</ul>
		<!-- end of sidebar -->
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<!-- loading the topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    			<!-- Sidebar Toggle (Topbar) -->
                    			<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        			<i class="fa fa-bars"></i>
		    			</button>
					<!-- top search bar -->

					<form action="/user/search" method="get" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        		<div class="input-group">
                            			<input type="text" name="q" class="form-control bg-light border-0 small" placeholder="Search here."
                                		aria-label="Search" aria-describedby="basic-addon2">
                            			<div class="input-group-append">
                                			<button class="btn btn-primary" type="button">
                                    				<i class="fas fa-search fa-sm"></i>
                                			</button>
                            			</div>
                        		</div>
					</form>
                    			<!-- push the top navbar -->
                    			<ul class="navbar-nav ml-auto">
                        			<!-- search dropdown (visible = only xs) -->
                        			<li class="nav-item dropdown no-arrow d-sm-none">
                            			<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- dropdown - messages := XHR/WebSocket pull for user! $rachow -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <!-- nav items - alerts = stack them up using websocket calls := $rachow -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- counter +=id/class hook after DOM init. $rachow -->
                                <span class="badge badge-dark badge-counter">3+</span>
                            </a>
                            <!-- dropdown - alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- nav item - messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- counter - messages = hook after DOM init. periodically call REST API ..? -->
                                <span class="badge badge-dark badge-counter">7</span>
                            </a>
                            <!-- dropdown - messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/dist/images/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/dist/images/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/assets/dist/images/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- nav item - user info -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php if(isset($firstname,$lastname)): echo $firstname . ' ' . $lastname; endif; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="/assets/dist/images/undraw_profile.svg">
                            </a>
                            <!-- dropdown - user info -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/user/logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
		</nav>
		<!-- start page content -->
		<div class="container-fluid">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0">Edit User</h1>
				<a href="javascript:;" onclick="history.go(-1);" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-back fa-sm text-white-50"></i> Go back</a>
<a href="/user/create" class="d-block pull-right btn btn-primary btn-sm"><i class="fas fa-user fa-sm text-white-50"></i>&nbsp;&nbsp;Add New User</a>

			</div>
			<div class="row">
			   <div class="card shadow mb-4 col-md-12">
			      <div class="card-body">
				<div class="col-md-12 mb-5">
					<p class="lead text-muted">Update user details on the platform<p>
					<p>All fields denoted by (*) are mandatory.</p>
					<?php if(session()->getFlashData('error') !== null): ?>
						<p class="text-danger"><?= session()->getFlashData('error'); ?></p>
					<?php endif; ?>
					<?php if(session()->getFlashData('message') !== null): ?>
						<div class="alert alert-success" role="alert">
							<?= session()->getFlashData('message'); ?>
						</div>
					<?php endif; ?>

					<?php
					    if(!empty($errors)){
					?>
					      <ul>
						<?php foreach($errors as $key => $val): echo '<li class="text-danger">' . $key . ' - ' . $val . '</li>'; endforeach; ?>
					      </ul>
					<?php
					    }
					?>

					<!-- begin the form build -->
					<?php
						/**
 						* 	$rachow
						*	Method spoofing will allow RESTful operation not browserful.
						*	extend when needed to handle.
						*/

						$request = \Config\Services::request();
						$spoof_method = 'POST';

						if(strtoupper($request->getMethod()) == 'GET'){
							$spoof_method = 'POST';
						}
					?>
						<form id="cf-frm-addusr" method="POST" action="/user/update/<?= $user['id']; ?>" autocomplete="off" charset="utf-8">
						<input type="hidden" name="_method" value="<?php echo $spoof_method; ?>">
						<input type="hidden" name="user_id" value="<?= $user['id']; ?>">
						<div class="form-group row">
							<div class="col-md-2">
								<label>Title*</label>
								<select name="title" class="form-control">
									<option value="">--Select--</option>
									<option value="Mr"<?php if($user['title'] == 'Mr'): echo ' selected'; endif; ?>>Mr</option>
									<option value="Mrs"<?php if($user['title'] == 'Mrs'): echo ' selected'; endif; ?>>Mrs</option>
									<option value="Ms"<?php if($user['title'] == 'Ms'): echo ' selected'; endif; ?>>Ms</option>
									<option value="Miss"<?php if($user['title'] == 'Miss'): echo ' selected'; endif; ?>>Miss</option>
									<option value="Dr"<?php if($user['title'] == 'Dr'): echo ' selected'; endif; ?>>Dr</option>
									<option value="Prof"<?php if($user['title'] == 'Prof'): echo ' selected'; endif; ?>>Prof</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>Firstname*</label>
								<input type="text" name="firstname" class="form-control" placeholder="Enter firstname" value="<?= $user['firstname']; ?>">
							</div>	
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>Lastname*</label>
								<input type="text" name="lastname" class="form-control" placeholder="Enter lastname" value="<?= $user['lastname']; ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>Username* <small>(min: 8 chars)</small></label>
								<input type="text" name="username" id="cf-username" class="form-control" placeholder="Enter username" value="<?= $user['username']; ?>">
								<p class="text-danger" id="cf-username-check"></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>E-mail*</label>
								<input type="email" name="email" id="cf-email" class="form-control" placeholder="Enter email" value="<?= $user['email']; ?>">
								<p class="text-danger" id="cf-email-check"></p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>Mobile</label>
								<input type="tel" name="mobile" class="form-control mobile-input" value="<?= $user['mobile']; ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>Password* <small>(min: 8 chars)</small></label>
								<input type="password" name="password" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<label>Confirm*</label>
								<input type="confirm" name="confirm" class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-4">
								<button type="submit" class="btn btn-primary">Update User</button>
							</div>
						</div>
						<!--	
				   		<div id="input-tel-err" class="text-danger font-weight-bold"></div>
						<div id="input-tel-ok"></div>
						-->
					</form>
				
				</div>
                               </div><!-- card body end -->
			     </div><!-- card end -->
			</div>
		</div>
	</div>
	</div>
	</div> 
	<!-- load core needy files - $rachow -->
	<script src="/assets/dist/vendor/jquery/jquery.min.js"></script>
	<script src="/assets/dist/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/dist/vendor/jquery-easing/jquery.easing.min.js"></script>
	<script type="text/javascript">

		// initialise globals.		
		var cf_username_taken = false;
		var cf_email_taken = false;

		/**
		* for full blast, blaze these in localStorage!
		*	add common utils fun to get and store to localStorage browser API.
		*/

		var cf_user_username = '<?= $user['username']; ?>';
		var cf_user_email = '<?= $user['email']; ?>';

		/**
		* DOM is now ready loaded. Party time! \(")/
		*
		*/
		$(document).ready(function(){
			
			// populate the Intl telephnone input.
			doIntlInputSelectProps('.mobile-input');

			// start binding.
			$('#cf-username').on('change', function(evt){

				evt.preventDefault();

				var ele = '#cf-username-check';
				var msg = 'username already taken.';
				var usr = $('#cf-username').val();
					
				if(usr == cf_user_username){
					return false; // return same as before.
				}

				cf_username_taken = false; // reset

				if(usr.length <= 8){
				      	msg = 'username too short.';
					$('#cf-username').addClass('border-danger');
					$(ele).html(msg);
					cf_username_taken = true;
				  	return;
				}

				/*
				* using jq ajax, although modern approach now is axios/fetch API .!$
				* better approach to handling of promises (@@).
				*/
				$.ajax({
					url: '/user/check-username?username='+encodeURIComponent(usr),
					headers: {'X-Requested-With': 'XMLHttpRequest'}, // better be safe.
					dataType: 'json',
					success: function(rs){
						if(rs.code != '200'){
							var msg = rs.msg;
							$('#cf-username').addClass('border-danger');
							$(ele).html(msg);
							cf_username_taken = true;
						}
					},
					error: function(err){
						// send to Bugsnag or Sentry ?
						console.log('debug: something went wrong.');
						alert('Error: Something went wrong.');
					}
				});
			});

			$('#cf-email').on('change', function(evt){
				evt.preventDefault();
				var ele = '#cf-email-check';
				var msg = 'email already taken.';
				var email = $('#cf-email').val();

				if(email == cf_user_email){
					return false; // return same as before.
				}

				cf_email_taken = false; // reset
				$('#cf-email').removeClass('border-danger');
				$(ele).html('');

				if(!/\@.+/.test(email)) {
					msg = 'Email is invalid.';
					$('#cf-email').addClass('border-danger');
					$(ele).html(msg);
					cf_email_taken = true;
					return;
				}

				/*
				* using jq ajax, although modern now is axios/fetch API?
				* better approach to handling promise based req/resp.
				*/
				$.ajax({
					url: '/user/check-email?email='+encodeURIComponent(email),
					headers: {'X-Requested-With': 'XMLHttpRequest'}, // better be safe.
					dataType: 'json',
					success: function(rs){
						if(rs.code != '200'){
							var msg = rs.msg;
							$('#cf-email').addClass('border-danger');
							$(ele).html(msg);
							cf_email_taken = true;
						}
					},
					error: function(err){
						// send to Bugsnag or Sentry ?
						console.log('debug: something went wrong.');
						alert('Error: Something went wrong.');
					}
				});

			});
		});

		/**
		* Handle International phone usage.
		*
		* @param  none
		* @return void
		*/
		function doIntlInputSelectProps(input)
		{
			var intlInputSrc = document.createElement('script');
			var intlInputInitSrc = document.createElement('script');

			intlInputSrc.setAttribute('src', '/assets/dist/vendor/js/intlTelInput.min.js');
			document.head.appendChild(intlInputSrc);

			intlInputInitSrc.setAttribute('src', '/assets/dist/vendor/js/intlTelInit.js');
			document.head.appendChild(intlInputInitSrc);	
		}

	</script>
	<style>
	   @import '/assets/dist/vendor/css/intlTelInput.min.css';
	</style>
</body>
</html>
