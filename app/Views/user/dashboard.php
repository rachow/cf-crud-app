<?php
/**
 * 	@author: $rachow
 * 	@copyright: CF Partners 2023
 *
 * 	User dashboard layout view
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
		<!-- kick in the sidebar -->
        	<ul class="navbar-nav bg-dark text-white sidebar sidebar-dark accordion" id="accordionSidebar">
			<!-- brand logo -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
				<img src="/assets/dist/images/cf-partners-logo.png" class="d-block" style="width:200px;height:auto;">
				<!--
				<div class="sidebar-brand-icon rotate-n-15">
                    			<i class="fas fa-laugh-wink"></i>
				</div>
				-->
				<!--
                		<div class="sidebar-brand-text mx-3">CF App <sup>2</sup></div>
				-->

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

                    			<!-- Topbar Navbar -->
                    			<ul class="navbar-nav ml-auto">
                        			<!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        			<li class="nav-item dropdown no-arrow d-sm-none">
                            			<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
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

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-dark badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
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

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-dark badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
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

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php if(isset($firstname,$lastname)): echo $firstname . ' ' . $lastname; endif; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="/assets/dist/images/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
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
		<!-- Begin page content -->
		<div class="container-fluid">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h3 mb-0">Dashboard</h1>
                        	<a href="/user/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-user fa-sm text-white-50"></i>&nbsp;&nbsp;Add New User</a>
			</div>
			<h2 class="h5">Good <span class="greeting"></span> <?php if(isset($firstname)): echo $firstname; endif; ?>,</h2>
			<?php if(session()->getFlashData('error') !== null): ?>
				<p class="text-danger"><?= session()->getFlashData('error'); ?></p>
			<?php endif; ?>
			<?php if(session()->getFlashData('message') !== null): ?>
				<div class="alert alert-success" role="alert">
					<?= session()->getFlashData('message'); ?>
				</div>
			<?php endif; ?>
			<!-- load the users data table -->
	                <div class="card shadow mb-4">
                        	<div class="card-header py-3">
                            		<h6 class="m-0 font-weight-bold text-primary">All Users</h6>
                        	</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="cf-table-users" class="table table-bordered" width="100%" cellspacing="0">
							<thead>
							   <tr>
							     	<th>ID</td>
								<th>Title</th>
								<th>Firstname</th>
								<th>Lastname</th>
								<th>E-mail</th>
								<th>Action</th>
							   </tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Your Recent Activity</h6>
				</div>
				<div class="card-body text-center">
					<script type="text/javascript">
						const _loader = '<div class="spinner-border mt-2 mb-2" role="status"></div>';

						document.writeln(_loader+'<div>loading...</div>');
					</script>	
				</div>
			</div>
		</div>
	</div>
	</div>
	</div> 
	<!-- load core needy files - $rachow -->
	<script src="/assets/dist/vendor/jquery/jquery.min.js"></script>
	<script src="/assets/dist/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="/assets/dist/vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- slip in the datatables -->
	<script src="/assets/dist/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="/assets/dist/vendor/datatables/dataTables.bootstrap4.min.js"></script>

	<!-- custom -->
	<script type="text/javascript">

		// global register the holding of last fetch.
		var last_usersFetchPoll = null;

		$(document).ready(function(){
			// DOM now ready.
			var dd = new Date();
			var hh = dd.getHours();
			var greeting = '';
			if(hh < 12){
				greeting = 'Morning';
			}else if(hh >= 12 && hh <= 17){
				greeting = 'Afternoon';
			}else if(hh >= 17 && hh <= 24){
				greeting = 'Evening';
			}
			$('.greeting').html(greeting);
			console.log('info: greeting user.');

			// show data state before XHR
			var msg = 'No data to display.';
			var tb_users = 'cf-table-users';
			var tb_len = getTBLengthById(tb_users);
			$('#'+tb_users+' tbody').html('<tr><td colspan="'+tb_len+'" align="center">'+msg+'</td></tr>');

			// load the users data table content.
			getPlatformUsers(tb_users);
		});

		/**
 		* Fetch the platform users using XHR to poll from backend.
		* 
		* @param  tb
		* @return mixed
		*/
		function getPlatformUsers(tb)
		{
			// upgrade to Axios for better Promise based handle
			console.log('info: making XHR request.');
			tbLoadingState(tb);
			$.ajax({
				url: "/user/all",
				headers: {'X-Requested-With': 'XMLHttpRequest'}, // better to be safe.
			   	success: function(rslt){
					renderPlatformUsers(rslt, 'cf-table-users');	
			   	},
			   	error: function(err){
					   alert("Ooops error occurred");
			   	}
			});
		}

		/**
		* Handle the display and rendering of JSON data.
		*
		* @param result - JSON
		* @param tb - DOM element
		*/
		function renderPlatformUsers(result, tb)
		{
			console.log("info: FOMO! - We got this!");
			// think about promise based request => Axios/fetch !
			console.log('info: Collection: ' + JSON.stringify(result.data));

			// collect the data required.
			const total = result.total_rows;
			const totalPages = Math.ceil(total / result.per_page);
			const curr_page = result.page;
			const rows = result.data;

			var display = null;

			if(total == undefined || total == 0){
				var msg = '<p class="p-0 m-2">Your search returned 0 results.</p>';
				var len = getTBLengthById(tb);
				$('#'+tb+' tbody').html('<tr><td colspan="'+len+'" align="center">'+msg+'</td></tr>');
				//return;
			}		

			$.each(rows, function(idx, obj){
				display += buildPlatformUsersDataRow(obj);
			});

			// KABOOM: render the list of users - say no to FOMO!
			$('#' + tb + ' tbody').html(display);

			// init the data table!
			$('#'+ tb).dataTable();

		}

		/*
		* Build the table row for the dataset.
		*
		* @param  obj
		* @return string
		*/
		function buildPlatformUsersDataRow(obj)
		{
			var row = '';
			row += '<tr>';
			row += '<td>' + obj.id + '</td>';
			row += '<td>' + obj.title + '</td>';
			row += '<td>' + obj.firstname + '</td>';
			row += '<td>' + obj.lastname + '</td>';
			row += '<td>' + obj.email + '</td>';
			row += '<td><a style="color:#000;text-decoration:none;" class="text-muted" href="/user/edit/'+obj.id+'"><i class="fas fa-edit"></i>&nbsp;edit</a>&nbsp;&nbsp;<a href="javascript:void(0);" style="color:#000;text-decoration:none;" class="text-muted" onclick="removePlatformUser(\''+obj.id+'\');"><i class="fas fa-trash"></i>&nbsp;delete</a></td>';
			row += '</tr>';
			return row;
		}

		/**
		* Removal of a user from the backend.
		*
		* @param  id
		* @return mixed
		*
		*/
		function removePlatformUser(id)
		{
			if(confirm("Are you sure to delete?"))
			{
				/**
				* use jq modal in future, since we want to keep users notified (loading...)
				* something is happening while the server does its hard work :D .!$
				*/
				console.log('info: BOOM: Attempting to remove user ID ['+id+'].');

				$.ajax({
					url: "/user/remove/" + id,
					headers: {'X-Requested-With': 'XMLHttpRequest'}, // better to be safe.
			   		success: function(rslt){
						alert("User has been removed");
						console.log('info: FOMO: Removed user with ID ['+id+']');
						/**
						* instead of reload window, which will cause xxx resource pull from server,
						* why not just reload the users view states ? => renderPlatformUsers() = :D
						* 	has any other events changed in background after removal of user
						* 	i.e. do you need to stack event notifications ?
						*
						* TTFB = +/ resources (Time to First Byte, DNS Handshake)
						*/
						
						window.location.reload();
			   		},
			   		error: function(err){
						alert("Ooops error occurred");
						console.log('error: '+ JSON.stringify(err));
						// -> push to ELK or Stability Centre.
			   		}
				});
			}
		}

		/**
		* Nifty routine to grab the total columns
		* for table
		*
		* @param  tb
		* @return string
		*/
		function getTBLengthById(id)
		{
			var len = $('#'+id).find('th').length;
			return len;
		}

		/**
		* Presentation is key, users must be informed about
		* the loading state.
		*
		* @param  ele
		* @return void 
		*/
		function tbLoadingState(el)
		{
			if(el == undefined || el == '')
				return false;

			if(!/^\./.test(el)) {
				el = el.replace('#','');
				el = '#'+el;
			}

			var len = $(el+' thead').find("th").length;
			const loading = '<tr><td colspan="'+len+'" align="center">'+_loader+'<div>loading...</div></td></tr>';
			$(el+' tbody').html(loading);
		}
	</script>
</body>
</html>
