<div class="header">
	<!-- Logo -->
	<div class="header-left">
		<a href="<?= home_path() ?>" class="logo">
			<!-- <img src="<?= get_assets() ?>img/logo.png" width="40" height="40" alt=""> -->
			<div class="page-title-box">
				<h2>SAAOL </h2>
			</div>
		</a>
	</div>
	<!-- /Logo -->

	<a id="toggle_btn" href="javascript:void(0);">
		<span class="bar-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</a>

	<!-- Header Title -->
	<!-- <div class="page-title-box">
		<h3>Dreamguy's Technologies</h3>
	</div> -->
	<!-- /Header Title -->

	<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

	<!-- Header Menu -->
	<ul class="nav user-menu">


		<!-- <li class="nav-item">
			<div class="top-nav-search">
				<form action="" onsubmit="return false" style="width:140px;">

					<button class=" form-control btn" type="submit" data-toggle="modal" data-target="#lunch_start" style="background-color: #47ba78f2 !important; width:unset; color:white;padding: 8px 30px; right:20%;">Lunch</button>

				</form>
			</div>
		</li> -->

		<li class="nav-item">
			<div class="top-nav-search">
				<form action="" onsubmit="return false" style="width:140px;">

					<button class="form-control btn" type="submit" data-toggle="modal" data-target="#break_start" style="background-color: #8e27d1 !important; width:unset; color:white;padding: 8px 30px;right:20%;">Break</button>

				</form>
			</div>
		</li>

		<!-- Search -->
		<div class="page-title-box">

			<h2 id="working_timer"></h2>
		</div>
		<!-- /Search -->

		<!-- Notifications -->
		<!-- <li class="nav-item dropdown">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<i class="fa fa-bell-o"></i> <span class="badge badge-pill">3</span>
			</a>
			<div class="dropdown-menu notifications">
				<div class="topnav-dropdown-header">
					<span class="notification-title">Notifications</span>
					<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
				</div>
				<div class="noti-content">
					<ul class="notification-list">
						<li class="notification-message">
							<a href="activities.php">
								<div class="media">
									<span class="avatar">
										<img alt="" src="<?= get_assets() ?>img/profiles/avatar-02.jpg">
									</span>
									<div class="media-body">
										<p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
										<p class="noti-time"><span class="notification-time">4 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.php">
								<div class="media">
									<span class="avatar">
										<img alt="" src="<?= get_assets() ?>img/profiles/avatar-03.jpg">
									</span>
									<div class="media-body">
										<p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
										<p class="noti-time"><span class="notification-time">6 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.php">
								<div class="media">
									<span class="avatar">
										<img alt="" src="<?= get_assets() ?>img/profiles/avatar-06.jpg">
									</span>
									<div class="media-body">
										<p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
										<p class="noti-time"><span class="notification-time">8 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.php">
								<div class="media">
									<span class="avatar">
										<img alt="" src="<?= get_assets() ?>img/profiles/avatar-17.jpg">
									</span>
									<div class="media-body">
										<p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
										<p class="noti-time"><span class="notification-time">12 mins ago</span></p>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="activities.php">
								<div class="media">
									<span class="avatar">
										<img alt="" src="<?= get_assets() ?>img/profiles/avatar-13.jpg">
									</span>
									<div class="media-body">
										<p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
										<p class="noti-time"><span class="notification-time">2 days ago</span></p>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<div class="topnav-dropdown-footer">
					<a href="activities.php">View all Notifications</a>
				</div>
			</div>
		</li> -->
		<!-- /Notifications -->

		<!-- Message Notifications -->
		<!-- <li class="nav-item dropdown">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<i class="fa fa-comment-o"></i> <span class="badge badge-pill">8</span>
			</a>
			<div class="dropdown-menu notifications">
				<div class="topnav-dropdown-header">
					<span class="notification-title">Messages</span>
					<a href="javascript:void(0)" class="clear-noti"> Clear All </a>
				</div>
				<div class="noti-content">
					<ul class="notification-list">
						<li class="notification-message">
							<a href="chat.php">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img alt="" src="<?= get_assets() ?>img/profiles/avatar-09.jpg">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author">Richard Miles </span>
										<span class="message-time">12:28 AM</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.php">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img alt="" src="<?= get_assets() ?>img/profiles/avatar-02.jpg">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author">John Doe</span>
										<span class="message-time">6 Mar</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.php">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img alt="" src="<?= get_assets() ?>img/profiles/avatar-03.jpg">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author"> Tarah Shropshire </span>
										<span class="message-time">5 Mar</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.php">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img alt="" src="<?= get_assets() ?>img/profiles/avatar-05.jpg">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author">Mike Litorus</span>
										<span class="message-time">3 Mar</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
						<li class="notification-message">
							<a href="chat.php">
								<div class="list-item">
									<div class="list-left">
										<span class="avatar">
											<img alt="" src="<?= get_assets() ?>img/profiles/avatar-08.jpg">
										</span>
									</div>
									<div class="list-body">
										<span class="message-author"> Catherine Manseau </span>
										<span class="message-time">27 Feb</span>
										<div class="clearfix"></div>
										<span class="message-content">Lorem ipsum dolor sit amet, consectetur adipiscing</span>
									</div>
								</div>
							</a>
						</li>
					</ul>
				</div>
				<div class="topnav-dropdown-footer">
					<a href="chat.php">View all Messages</a>
				</div>
			</div>
		</li> -->
		<!-- /Message Notifications -->

		<?php
		$user = $_SESSION['user_id'];

		$sql = "SELECT * FROM tbl_user_master WHERE user_unique_id = '$user'";
		$query = $DB->prepare($sql);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_OBJ);
		$cnt = 1;
		?>

		<li class="nav-item dropdown has-arrow main-drop">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<span class="user-img"><img src="<?= get_assets() ?>users/<?= htmlentities($result->um_image); ?>" alt="User Picture">
					<span class="status online"></span></span>
				<span><?php echo htmlentities(ucfirst($_SESSION['userlogin'])); ?></span>
			</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="<?= home_path() ?>/user/user_view?id=<?= base64_encode($_SESSION['user_id']) ?>">My Profile</a>
				<!-- <a clas  s="dropdown-item" href="settings.php">Settings</a> -->
				<a class="dropdown-item" href="<?= home_path() ?>/logout">Logout</a>
			</div>
		</li>
	</ul>
	<!-- /Header Menu -->

	<!-- Mobile Menu -->
	<div class="dropdown mobile-user-menu">
		<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
		<div class="dropdown-menu dropdown-menu-right">
			<a class="dropdown-item" href="<?= home_path() ?>/user/user_view?id=<?= base64_encode($_SESSION['user_id']) ?>">My Profile</a>
			<a class="dropdown-item" href="settings.php">Settings</a>
			<a class="dropdown-item" href="<?= home_path() ?>/logout">Logout</a>
		</div>
	</div>
	<!-- /Mobile Menu -->

</div>
<script>
	console.log(document.getElementById('working_timer').innerHTML);
</script>