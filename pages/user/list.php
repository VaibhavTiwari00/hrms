<?php

include('../../init.php');

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
    <title>Users - HRMS admin template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/dataTables.bootstrap4.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap-datetimepicker.min.css">

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
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Users</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Users</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <a href="<?= home_path() ?>/user/add" class="btn add-btn"><i class="fa fa-plus"></i> Add User</a>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="user_table" class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Full Name</th>
                                        <th>Team</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Created Date</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM tbl_user_master";
                                    $query = $DB->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $result) {
                                    ?>

                                            <tr>
                                                <td></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <?php if (($result->um_image) != null) { ?>
                                                            <a href="<?= home_path() ?>/user/user_view?id=<?= base64_encode($result->user_unique_id) ?>" class="avatar"><img src="<?= get_assets() ?>users/<?php echo ($result->um_image); ?>" alt="Profile Pic"></a>
                                                        <?php } else {
                                                        ?>
                                                            <a href="<?= home_path() ?>/user/user_view?id=<?= base64_encode($result->user_unique_id) ?>" class="avatar">
                                                                <img src="<?= get_assets() ?>img/user.jpg" alt="Profile Pic"></a>
                                                        <?php } ?>

                                                        <a href="<?= home_path() ?>/user/user_view?id=<?= base64_encode($result->user_unique_id) ?>">
                                                            <?php echo htmlentities($result->first_name) . ' ' . $result->last_name;
                                                            $designation_name = get_designation_name_by_id($DB, htmlentities($result->designation_id));
                                                            ?>
                                                            <span>
                                                                <?php if ($designation_name) echo $designation_name[0]['designation_name']; ?>
                                                            </span>
                                                        </a>
                                                    </h2>
                                                </td>
                                                <?php $team_name = get_team_name_by_id($DB, htmlentities($result->team_id)); ?>
                                                <td><?= $team_name[0]['team_name'] ?></td>
                                                <td><?php echo htmlentities($result->email); ?></td>
                                                <td><?php echo htmlentities($result->mobile_no); ?></td>
                                                <td><?php echo htmlentities($result->um_created_date); ?></td>
                                                <td class="text-right">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="<?= home_path() ?>/user/edit?id=<?= base64_encode($result->user_unique_id) ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a> -->
                                                            <!-- <a class="dropdown-item" href="<?= home_path() ?>/manage_role"><i class="fa fa-trash-o m-r-5"></i> Manage Role</a> -->
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            <!-- Add User Modal -->
            <?php include_once("../../includes/modals/user/add_user.php"); ?>
            <!-- /Add User Modal -->

            <!-- Edit User Modal -->
            <?php include_once("../../includes/modals/user/edit_user.php"); ?>
            <!-- /Edit User Modal -->

            <!-- Delete User Modal -->
            <?php include_once("../../includes/modals/user/delete_user.php"); ?>
            <!-- /Delete User Modal -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
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

    <!-- Datatable JS -->
    <script src="<?= get_assets() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= get_assets() ?>js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>

    <?php include_once FOOTER; ?>


</body>

</html>