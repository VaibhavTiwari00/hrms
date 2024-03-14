<?php


include_once "../config.php";
include_once "../includes/main_function.php";
include_once "../includes/route.inc.php";

// ini_set('session.gc_maxlifetime', 86400);
session_start();

function secondsUntilNextDay()
{
	// Get the current time and date
	$now = time();

	// Calculate the timestamp for the next day
	$nextDayTimestamp = strtotime('tomorrow', $now);

	// Calculate the time difference in seconds
	$timeLeftInSeconds = $nextDayTimestamp - $now;

	// Return the time left in seconds
	return $timeLeftInSeconds;
}
// Call the function and get the result
$timeLeftInSeconds = secondsUntilNextDay();

// Display the result
// echo "Time left until the next day: {$timeLeftInSeconds} seconds.";


// Check if the user is already logged in, if yes then redirect him to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true) {
	header("location:" . home_path());
	exit;
} elseif (isset($_POST['login'])) {
	$username = htmlspecialchars($_POST['username']);
	$password = htmlspecialchars($_POST['password']);
	$sql = "SELECT user_name,password,mm_id,user_unique_id,ut_id from tbl_user_master where user_name=:username LIMIT 1";
	$query = $DB->prepare($sql);
	$query->bindParam(':username', $username, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);

	$datetime = date('H:i:s', time());
	$date = date('d/m/Y');

	if ($query->rowCount() > 0) {
		foreach ($results as $row) {
			$hashpass = $row->password;
		}
		//verifying Password
		if (password_verify($password, $hashpass)) {


			$data_cookie = [];

			$data_cookie['user'] = base64_encode($username);

			$_SESSION['userlogin'] = $_POST['username'];
			$_SESSION['user_id'] = $results[0]->user_unique_id;
			$_SESSION['user_type'] = $results[0]->ut_id;

			$module_table  = get_modules_access_by_usertype($DB, $results[0]->ut_id);
			$_SESSION['module_access'] = json_decode($module_table)[0]->mm_id;

			$_SESSION['time'] = time();

			$_SESSION["loggedin"] = true;

			$session_datetime = date("Y-m-d H:i:s");
			$_SESSION['created_date'] = $session_datetime;

			check_last_login_with_userid($DB, $_SESSION['user_id']);

			$sql = "INSERT INTO " . $DB_Prefix . "login_package_master(`user_unique_id`,`login_time`,`created_date`) VALUES (:user_unique_id,:login_time,:created_date)";

			$statement = $DB->prepare($sql);

			$statement->bindValue(":user_unique_id", $_SESSION['user_id']);
			$statement->bindValue(":login_time", $datetime);
			$statement->bindValue(":created_date", $session_datetime);

			$res = $statement->execute();

			$data_cookie['current_session'] = $session_datetime;
			$data_cookie_json = json_encode($data_cookie);

			setcookie('hrm_user', $data_cookie_json, time() + $timeLeftInSeconds, '/');
			
			update_daily_tasks_of_assign_user($DB, $results[0]->user_unique_id);

			header("location:" . home_path());
		} else {
			$wrongpassword = '
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Oh Snapp!😕</strong> Alert <b class="alert-link">Password: </b>You entered wrong password.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>';
		}
	}
	//if username or email not found in database
	else {
		$wrongusername = '
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Oh Snapp!🙃</strong> Alert <b class="alert-link">UserName: </b> You entered a wrong UserName.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="Smarthr - Bootstrap Admin Template">
	<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
	<meta name="author" content="Dreamguys - Bootstrap Admin Template">
	<meta name="robots" content="noindex, nofollow">
	<title>Login </title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

</head>

<body class="account-page">
	<!-- Main Wrapper -->
	<div class="main-wrapper">
		<div class="account-content">
			<div class="container">
				<!-- Account Logo -->
				<div class="account-logo">
					<a href="index.php">
						<img src="<?= get_assets() ?>img/logo_real.png" alt=" Company Logo">
					</a>
				</div>
				<!-- /Account Logo -->

				<div class="account-box">
					<div class="account-wrapper">
						<h3 class="account-title">HRM Login</h3>
						<!-- Account Form -->
						<form method="POST" enctype="multipart/form-data" action="<?= home_path() ?>/login">
							<div class="form-group">
								<label>User Name</label>
								<input class="form-control" name="username" required type="text">
							</div>

							<?= isset($wrongusername) ? $wrongusername : ''; ?>
							<div class="form-group">
								<div class="row">
									<div class="col">
										<label>Password</label>
									</div>
								</div>
								<input class="form-control" name="password" required type="password">
							</div>
							<?= isset($wrongpassword) ? $wrongpassword : ''; ?>

							<div class="form-group text-center">
								<button class="btn btn-primary account-btn" name="login" type="submit">Login</button>
								<!-- <div class="col-auto pt-2">
									<a class="text-muted float-right" href="forgot-password.php">
										Forgot password?
									</a>
								</div> -->
							</div>

							<!-- <div class="account-footer">
								<p>Having Trouble? report an issue on github <a target="https://github.com/MusheAbdulHakim/Smarthr---hr-payroll-project-employee-management-System/issues" href="https://github.com/MusheAbdulHakim/Smarthr---hr-payroll-project-employee-management-System/issues">Github issues</a></p>
							</div> -->
						</form>
						<!-- /Account Form -->

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="<?= get_assets() ?>js/popper.min.js"></script>
	<script src="<?= get_assets() ?>js/bootstrap.min.js"></script>

	<!-- Custom JS -->
	<script src="<?= get_assets() ?>js/app.js"></script>


</body>

</html>