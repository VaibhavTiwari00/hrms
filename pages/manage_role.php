<?php
include('../init.php');


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="robots" content="noindex, nofollow">
	<title>Roles & Permission </title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

	<!-- Lineawesome CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="<?= get_assets() ?>css/style.css">


	<!-- toaster js link -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

	<!-- Head -->
	<?php include_once HEAD; ?>
	<!-- /Head -->

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
							<h3 class="page-title">Roles & Permissions</h3>
						</div>
					</div>
				</div>
				<!-- /Page Header -->

				<div class="row">
					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-3">
						<a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_role"><i class="fa fa-plus"></i> Add Roles</a>
						<div class="roles-menu">
							<ul class="role_menu_ul">
								<?php
								$total_roles = get_all_usertype_list($DB);
								foreach ($total_roles as $role) {
								?>
									<li class="user_role">
										<a href="javascript:void(0);" data-target="<?= $role['ut_id'] ?>">
											<?= $role['ut_name'] ?>
											<span class="role-action">
												<span class="action-circle large" data-toggle="modal" data-target="#edit_role">
													<i class="material-icons">edit</i>
												</span>
												<span class="action-circle large delete-btn" data-toggle="modal" data-target="#delete_role">
													<i class="material-icons">delete</i>
												</span>
											</span>
										</a>
									</li>
								<?php  } ?>

							</ul>
						</div>
					</div>
					<div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
						<h6 class="card-title m-b-20">Module Access</h6>
						<div class="m-b-30">
							<ul class="list-group notification-list">
								<?php
								$total_modules = get_all_module_list($DB);
								foreach ($total_modules as $role) { ?>
									<li class="list-group-item ">
										<?= $role['mm_module_name'] ?>
										<div class="status-toggle">
											<input type="checkbox" id="<?= $role['mm_id'] ?>_module" class="check check_box_role">
											<label for="<?= $role['mm_id'] ?>_module" class="checktoggle">checkbox</label>
										</div>
									</li>
								<?php } ?>

							</ul>
						</div>
						<!-- <div class="table-responsive">
							<table id="" class="table table-striped custom-table">
								<thead>
									<tr>
										<th id="permission">Module Permission</th>
										<th id="write" class="text-center">Create</th>
										<th id="create" class="text-center">Edit</th>
										<th id="delete" class="text-center">Delete</th>

									</tr>
								</thead>
								<tbody>
									<?php
									$total_modules = get_all_module_list($DB);
									foreach ($total_modules as $role) { ?>
										<tr>
											<td><?= $role['mm_module_name'] ?></td>

											<td class="text-center">
												<input type="checkbox">
											</td>
											<td class="text-center">
												<input type="checkbox">
											</td>
											<td class="text-center">
												<input type="checkbox">
											</td>

										</tr>
									<?php } ?>

								</tbody>
							</table>
						</div> -->
					</div>
				</div>
			</div>
			<!-- /Page Content -->

			<!-- Add Role Modal -->
			<?php include_once("../includes/modals/roles/add.php"); ?>
			<!-- /Add Role Modal -->

			<!-- Edit Role Modal -->
			<?php include_once("../includes/modals/roles/edit.php"); ?>
			<!-- /Edit Role Modal -->

			<!-- Delete Role Modal -->
			<?php include_once("../includes/modals/roles/delete.php"); ?>
			<!-- /Delete Role Modal -->

		</div>
		<!-- /Page Wrapper -->

	</div>
	<!-- /Main Wrapper -->
	<!-- toaster js  -->
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

	<!-- jQuery -->
	<script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="<?= get_assets() ?>js/popper.min.js"></script>
	<script src="<?= get_assets() ?>js/bootstrap.min.js"></script>

	<!-- Slimscroll JS -->
	<script src="<?= get_assets() ?>js/jquery.slimscroll.min.js"></script>

	<!-- Custom JS -->
	<script src="<?= get_assets() ?>js/app.js"></script>




	<script>
		$('.role_menu_ul').children().first().addClass('active');

		const user_role = document.querySelectorAll('.user_role');
		const user_role_first = document.querySelector('.user_role');

		const check_box_role = document.querySelectorAll('.check_box_role');

		for (let i = 0; i < check_box_role.length; i++) {
			console.log(check_box_role[i]);
			check_box_role[i].addEventListener('change', (e) => {
				let module_id = e.target.id.split('_')[0];

				let user_type_id = get_current_user_role().children[0].attributes['1'].value;


				function manipulate_role_user(module_id, user_type_id) {
					console.log(module_id, user_type_id);
					$.ajax({
						type: 'POST',
						url: 'action/manage_role.php?do=manipulate_access',
						data: {
							module_id: module_id,
							user_type_id: user_type_id
						},
						success: function(response) {
							console.log(response);
							Toastify({
								text: "Successfully Update Access",
								duration: 2000,
								close: true,
								gravity: "top", // `top` or `bottom`
								position: "right", // `left`, `center` or `right`
								stopOnFocus: true, // Prevents dismissing of toast on hover
								style: {
									background: "linear-gradient(to right, #00b09b, #96c93d)",
								},
								onClick: function() {} // Callback after click
							}).showToast();
						},
						error: function(xhr, status, error) {
							// Handle errors here
							console.error('Error : ', error);

						}
					});
				}
				manipulate_role_user(module_id, user_type_id);
			})
		}

		let check_id = user_role_first.children[0].attributes[1].value;
		const myArray = [1, 2, 3, 4, 5];
		if (myArray.indexOf(check_id) == -1) {
			check_active_role_ajax(check_id);
		}


		for (let i = 0; i < user_role.length; i++) {

			user_role[i].addEventListener('click', (e) => {

				var ut_id = e.target.attributes['1'].value;

				if (myArray.indexOf(ut_id) == -1) {
					// ui part active class add or remove from all element 
					remove_active_role_class();
					e.target.parentElement.classList.add('active');


					check_active_role_ajax(ut_id);
				}

			})
		}


		function remove_active_role_class() {
			const user_role = document.querySelectorAll('.user_role');
			for (let i = 0; i < user_role.length; i++) {
				user_role[i].classList.remove('active');
			}
		}

		function check_active_role_ajax(ut_id) {
			$.ajax({
				type: 'POST',
				url: 'action/manage_role.php?do=show_access',
				data: {
					ut_id: ut_id,
				},
				success: function(response) {
					let access = JSON.parse(response)[0].mm_id;

					let access_name = JSON.parse(response)[0].mm_id;
					let access_array = access.split(',');

					for (let i = 0; i < check_box_role.length; i++) {
						check_box_role[i].checked = false;
					}

					access_array.forEach(element => {
						let ele = document.getElementById(element + '_module');
						if (ele) {
							ele.checked = true;
						}
					});
				},
				error: function(xhr, status, error) {
					// Handle errors here
					console.error('Error : ', error);

				}
			});
		}

		function get_current_user_role() {
			var elementsWithBothClasses = document.querySelector('.user_role.active');
			return elementsWithBothClasses;
		}
	</script>

	<?php include_once FOOTER; ?>
</body>

</html>