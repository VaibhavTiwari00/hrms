<?php
include('../../init.php');


if (isset($_GET['id'])) {
	$get_id = base64_decode($_GET['id']);
	$get_results = get_user_details_by_id($DB, $get_id);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="robots" content="noindex, nofollow">
	<title>User Profile </title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/select2.min.css">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap-datetimepicker.min.css">

	<!-- Tagsinput CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
			<script src="<?= get_assets() ?>js/html5shiv.min.js"></script>
			<script src="<?= get_assets() ?>js/respond.min.js"></script>
		<![endif]-->

	<!-- Head -->
	<?php include_once HEAD; ?>
	<!-- /Head -->

	<style>
		.profile-view .profile-img-wrap {
			height: 70px;
			width: 70px;
		}

		.profile-view .profile-img {
			width: 70px;
			height: 70px;
		}

		.profile-img-wrap img {
			border-radius: 50%;
			height: 70px;
			width: 70px;
			object-fit: cover;
		}
	</style>
</head>

<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		<?php include_once HEADER; ?>
		<!-- /Header -->

		<!-- Sidebar -->
		<?php include_once SIDEBAR; ?>
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">

			<!-- Page Content -->
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">Profile</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
								<li class="breadcrumb-item active">Profile</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="card mb-0">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="profile-view">
									<div class="profile-img-wrap">
										<div class="profile-img">
											<a href="#"><img alt="" src="<?= get_assets() ?>users/<?= $get_results[0]['um_image'] ?>"></a>
										</div>
									</div>
									<div class="profile-basic">
										<div class="row">
											<div class="col-md-5">
												<div class="profile-info-left">
													<h3 class="user-name m-t-0 mb-0"><?= $get_results[0]['first_name'] . ' ' . $get_results[0]['last_name'] ?></h3>

													<?php $team_res = get_designation_name_by_id($DB, $get_results[0]['designation_id']);

													if ($team_res) { ?>
														<h6 class="text-muted mt-1">
															<?= $team_res[0]['designation_name'] ?>
														</h6>
													<?php }
													?>
													<small class="text-muted"><a class="btn add_btn btn_sm" href="<?= home_path() . '/user/user_activity?id=' . base64_encode($get_id) ?>">Activity</a></small>
												</div>
											</div>
											<div class="col-md-7">
												<ul class="personal-info">
													<li>
														<div class="title">Phone:</div>
														<div class="text"><a href=""><?= $get_results[0]['mobile_no'] ?></a></div>
													</li>
													<li>
														<div class="title">Email:</div>
														<div class="text"><a href=""><?= $get_results[0]['email'] ?></a></div>
													</li>
													<!-- <li>
														<div class="title">Birthday:</div>
														<div class="text">24th July</div>
													</li>
													<li>
														<div class="title">Address:</div>
														<div class="text">1861 Bayonne Ave, Manchester Township, NJ, 08759</div>
													</li>
													<li>
														<div class="title">Gender:</div>
														<div class="text">Male</div>
													</li>
													<li>
														<div class="title">Reports to:</div>
														<div class="text">
															<div class="avatar-box">
																<div class="avatar avatar-xs">
																	<img src="<?= get_assets() ?>img/profiles/avatar-16.jpg" alt="">
																</div>
															</div>
															<a href="profile.php">
																Jeffery Lalor
															</a>
														</div>
													</li> -->
												</ul>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<br>

				<div class="row">

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
								<div class="dash-widget-info">
									<h3><?= get_all_task_count_of_user($DB, $get_id) ?></h3>
									<span>All Tasks</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-user"></i></span>
								<div class="dash-widget-info">
									<h3><?= get_all_pending_task_count_of_user($DB, $get_id) ?></h3>
									<span>Pending Task</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
						<div class="card dash-widget">
							<div class="card-body">
								<span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
								<div class="dash-widget-info">
									<h3><?= get_all_complete_task_count_of_user($DB, $get_id) ?></h3>
									<span>Completed Task</span>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-12 d-flex">
						<div class="card card-table flex-fill">

							<div class="project-task">
								<ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
									<li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true">All Tasks</a></li>
									<li class="nav-item"><a class="nav-link" href="#pending_tasks" data-toggle="tab" aria-expanded="false">Pending Tasks</a></li>
									<li class="nav-item"><a class="nav-link" href="#completed_tasks" data-toggle="tab" aria-expanded="false">Completed Tasks</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane show active" id="all_tasks">
										<div class="task-wrapper">
											<div class="task-list-container">
												<div class="task-list-body">
													<ul id="task-list">
														<?php $res = get_all_task_details_of_login_user($DB, $get_id);

														foreach ($res as $task) {
														?>
															<li class="task">
																<a href="<?= home_path() . '/tasks/view_task?id=' . base64_encode($task['tm_id']) ?>">
																	<div class="task-container">
																		<span class="task-action-btn task-check">
																			<span class="action-circle large complete-btn" title="Mark Complete">
																				<i class="material-icons">check</i>
																			</span>
																		</span>
																		<span class="task-label"><?= $task['task_title'] ?></span>

																	</div>
																</a>
															</li>
														<?php }
														?>
													</ul>
												</div>
												<div class="task-list-footer">
													<div class="new-task-wrapper">
														<textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
														<span class="error-message hidden">You need to enter a task first</span>
														<span class="add-new-task-btn btn" id="add-task">Add Task</span>
														<span class="btn" id="close-task-panel">Close</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="pending_tasks">
										<div class="task-wrapper">
											<div class="task-list-container">
												<div class="task-list-body">
													<ul id="task-list">
														<?php $res = get_pending_task_details_of_login_user($DB, $get_id);

														foreach ($res as $task) {
														?>
															<li class="task">
																<a href="<?= home_path() . '/tasks/view_task?id=' . base64_encode($task['tm_id']) ?>">
																	<div class="task-container">
																		<span class="task-action-btn task-check">
																			<span class="action-circle large complete-btn" title="Mark Complete">
																				<i class="material-icons">check</i>
																			</span>
																		</span>
																		<span class="task-label"><?= $task['task_title'] ?></span>

																	</div>
																</a>
															</li>
														<?php }
														?>
													</ul>
												</div>
												<div class="task-list-footer">
													<div class="new-task-wrapper">
														<textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
														<span class="error-message hidden">You need to enter a task first</span>
														<span class="add-new-task-btn btn" id="add-task">Add Task</span>
														<span class="btn" id="close-task-panel">Close</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="completed_tasks">
										<div class="task-wrapper">
											<div class="task-list-container">
												<div class="task-list-body">
													<ul id="task-list">
														<?php $res = get_complete_task_details_of_login_user($DB, $get_id);

														foreach ($res as $task) {
														?>
															<li class="task">
																<a href="<?= home_path() . '/tasks/view_task?id=' . base64_encode($task['tm_id']) ?>">
																	<div class="task-container">
																		<span class="task-action-btn task-check">
																			<span class="action-circle large complete-btn" title="Mark Complete">
																				<i class="material-icons">check</i>
																			</span>
																		</span>
																		<span class="task-label"><?= $task['task_title'] ?></span>

																	</div>
																</a>
															</li>
														<?php }
														?>
													</ul>
												</div>
												<div class="task-list-footer">
													<div class="new-task-wrapper">
														<textarea id="new-task" placeholder="Enter new task here. . ."></textarea>
														<span class="error-message hidden">You need to enter a task first</span>
														<span class="add-new-task-btn btn" id="add-task">Add Task</span>
														<span class="btn" id="close-task-panel">Close</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<a href="<?= home_path() ?>/tasks">View all Tasks</a>
							</div>
						</div>
					</div>
				</div>

			</div>


			<!-- /Page Content -->

			<!-- Profile Modal -->
			<div id="profile_info" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Profile Information</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="row">
									<div class="col-md-12">
										<div class="profile-img-wrap edit-img">
											<img class="inline-block" src="<?= get_assets() ?>img/profiles/avatar-02.jpg" alt="user">
											<div class="fileupload btn">
												<span class="btn-text">edit</span>
												<input class="upload" type="file">
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>First Name</label>
													<input type="text" class="form-control" value="John">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Last Name</label>
													<input type="text" class="form-control" value="Doe">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Birth Date</label>
													<div class="cal-icon">
														<input class="form-control datetimepicker" type="text" value="05/06/1985">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Gender</label>
													<select class="select form-control">
														<option value="male selected">Male</option>
														<option value="female">Female</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>Address</label>
											<input type="text" class="form-control" value="4487 Snowbird Lane">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>State</label>
											<input type="text" class="form-control" value="New York">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Country</label>
											<input type="text" class="form-control" value="United States">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Pin Code</label>
											<input type="text" class="form-control" value="10523">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Phone Number</label>
											<input type="text" class="form-control" value="631-889-3206">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Department <span class="text-danger">*</span></label>
											<select class="select">
												<option>Select Department</option>
												<option>Web Development</option>
												<option>IT Management</option>
												<option>Marketing</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Designation <span class="text-danger">*</span></label>
											<select class="select">
												<option>Select Designation</option>
												<option>Web Designer</option>
												<option>Web Developer</option>
												<option>Android Developer</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Reports To <span class="text-danger">*</span></label>
											<select class="select">
												<option>-</option>
												<option>Wilmer Deluna</option>
												<option>Lesley Grauer</option>
												<option>Jeffery Lalor</option>
											</select>
										</div>
									</div>
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Profile Modal -->

			<!-- Personal Info Modal -->
			<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Personal Information</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Passport No</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Passport Expiry Date</label>
											<div class="cal-icon">
												<input class="form-control datetimepicker" type="text">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Tel</label>
											<input class="form-control" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Nationality <span class="text-danger">*</span></label>
											<input class="form-control" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Religion</label>
											<div class="cal-icon">
												<input class="form-control" type="text">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Marital status <span class="text-danger">*</span></label>
											<select class="select form-control">
												<option>-</option>
												<option>Single</option>
												<option>Married</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Employment of spouse</label>
											<input class="form-control" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>No. of children </label>
											<input class="form-control" type="text">
										</div>
									</div>
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Personal Info Modal -->

			<!-- Family Info Modal -->
			<div id="family_info_modal" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"> Family Informations</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-scroll">
									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Family Member <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Name <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Relationship <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Date of birth <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Phone <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Name <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Relationship <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Date of birth <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Phone <span class="text-danger">*</span></label>
														<input class="form-control" type="text">
													</div>
												</div>
											</div>
											<div class="add-more">
												<a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
											</div>
										</div>
									</div>
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Family Info Modal -->

			<!-- Emergency Contact Modal -->
			<div id="emergency_contact_modal" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Personal Information</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="card">
									<div class="card-body">
										<h3 class="card-title">Primary Contact</h3>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Relationship <span class="text-danger">*</span></label>
													<input class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Phone <span class="text-danger">*</span></label>
													<input class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Phone 2</label>
													<input class="form-control" type="text">
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="card">
									<div class="card-body">
										<h3 class="card-title">Primary Contact</h3>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Relationship <span class="text-danger">*</span></label>
													<input class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Phone <span class="text-danger">*</span></label>
													<input class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Phone 2</label>
													<input class="form-control" type="text">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Emergency Contact Modal -->

			<!-- Education Modal -->
			<div id="education_info" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"> Education Informations</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-scroll">
									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="Oxford University" class="form-control floating">
														<label class="focus-label">Institution</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="Computer Science" class="form-control floating">
														<label class="focus-label">Subject</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" value="01/06/2002" class="form-control floating datetimepicker">
														</div>
														<label class="focus-label">Starting Date</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" value="31/05/2006" class="form-control floating datetimepicker">
														</div>
														<label class="focus-label">Complete Date</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="BE Computer Science" class="form-control floating">
														<label class="focus-label">Degree</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="Grade A" class="form-control floating">
														<label class="focus-label">Grade</label>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Education Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="Oxford University" class="form-control floating">
														<label class="focus-label">Institution</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="Computer Science" class="form-control floating">
														<label class="focus-label">Subject</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" value="01/06/2002" class="form-control floating datetimepicker">
														</div>
														<label class="focus-label">Starting Date</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<div class="cal-icon">
															<input type="text" value="31/05/2006" class="form-control floating datetimepicker">
														</div>
														<label class="focus-label">Complete Date</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="BE Computer Science" class="form-control floating">
														<label class="focus-label">Degree</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus focused">
														<input type="text" value="Grade A" class="form-control floating">
														<label class="focus-label">Grade</label>
													</div>
												</div>
											</div>
											<div class="add-more">
												<a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
											</div>
										</div>
									</div>
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Education Modal -->

			<!-- Experience Modal -->
			<div id="experience_info" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Experience Informations</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form>
								<div class="form-scroll">
									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group form-focus">
														<input type="text" class="form-control floating" value="Digital Devlopment Inc">
														<label class="focus-label">Company Name</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<input type="text" class="form-control floating" value="United States">
														<label class="focus-label">Location</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<input type="text" class="form-control floating" value="Web Developer">
														<label class="focus-label">Job Position</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<div class="cal-icon">
															<input type="text" class="form-control floating datetimepicker" value="01/07/2007">
														</div>
														<label class="focus-label">Period From</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<div class="cal-icon">
															<input type="text" class="form-control floating datetimepicker" value="08/06/2018">
														</div>
														<label class="focus-label">Period To</label>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="card">
										<div class="card-body">
											<h3 class="card-title">Experience Informations <a href="javascript:void(0);" class="delete-icon"><i class="fa fa-trash-o"></i></a></h3>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group form-focus">
														<input type="text" class="form-control floating" value="Digital Devlopment Inc">
														<label class="focus-label">Company Name</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<input type="text" class="form-control floating" value="United States">
														<label class="focus-label">Location</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<input type="text" class="form-control floating" value="Web Developer">
														<label class="focus-label">Job Position</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<div class="cal-icon">
															<input type="text" class="form-control floating datetimepicker" value="01/07/2007">
														</div>
														<label class="focus-label">Period From</label>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group form-focus">
														<div class="cal-icon">
															<input type="text" class="form-control floating datetimepicker" value="08/06/2018">
														</div>
														<label class="focus-label">Period To</label>
													</div>
												</div>
											</div>
											<div class="add-more">
												<a href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add More</a>
											</div>
										</div>
									</div>
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Experience Modal -->

		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="<?= get_assets() ?>js/popper.min.js"></script>
	<script src="<?= get_assets() ?>js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="<?= get_assets() ?>js/jquery.slimscroll.min.js"></script>

	<!-- Select2 JS -->
	<script src="<?= get_assets() ?>js/select2.min.js"></script>

	<!-- Datetimepicker JS -->
	<script src="<?= get_assets() ?>js/moment.min.js"></script>
	<script src="<?= get_assets() ?>js/bootstrap-datetimepicker.min.js"></script>

	<!-- Tagsinput JS -->
	<script src="<?= get_assets() ?>plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

	<!-- Custom JS -->
	<script src="<?= get_assets() ?>js/app.js"></script>

	<?php include_once FOOTER; ?>

</body>

</html>