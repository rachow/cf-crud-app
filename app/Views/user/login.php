<?php
/**
 * 	@author: $rachow
 * 	@copyright: CF Partners 2023
 *
 * 	Main user login view
*/

// stack into existing body class if set.
//$body_class = (isset($body_class)) ? $body_class . ' bg-gradient-primary' : 'bg-gradient-primary';

$body_class = (isset($body_class)) ? $body_class . ' bg-dark' : 'bg-dark';

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
<body <?php if(isset($body_class)): echo 'class="' . $body_class . '"'; endif;?>>
 <div class="container">
	<div class="row justify-content-center">
		<!-- brands logo -->
		<img src="/assets/dist/images/cf-partners-logo.png" class="mt-3">
	</div>
	<!-- outer row -->
	<div class="row justify-content-center">
          <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login to account</h1>
					<?php
						$session = \Config\Services::session();
						if($session->has('error'))
							echo '<p class="text-danger font-weight-bold">' . $session->get('error') . '</p>';
					?>
				    </div>
                                    <form class="user" method="post" action="/user/login" autocomplete="off" charset="utf-8">
                                        <div class="form-group">
                                            <input type="text" name="username" id="username" class="form-control form-control-user" placeholder="Email or Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="*******" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input" id="rememberCheck">
                                                <label class="custom-control-label" for="rememberCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
	</div>
	<!-- end outer row -->
 </div>
</body>
</html>
