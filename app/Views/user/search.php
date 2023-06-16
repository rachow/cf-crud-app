<?php
/**
 *	@author: $rachow
 *	@copyright: CF Partners 2023
 *
 *	Search wiki view
 *	 Go crazy with XHR, Websockets, dymanically fetching recent searches etc.
 */

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
                                <a class="dropdown-item" href="/usr/logout">
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
                        	<h1 class="h3 mb-0">Search results</h1>
			</div>
			<div class="row">
			   <div class="card shadow mb-4 col-md-12">
			      <div class="card-body">
				   <div class="col-md-12 text-center">
					No results found.
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

		var hooks = [];
		
		/**
		* DOM is now ready loaded.
		*
		*/
		$(document).ready(function(){
			console.log('info: search intent not found.');			
		});
	</script>
</body>
</html>

