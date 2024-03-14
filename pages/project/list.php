<?php
include_once '../../init.php';




if (isset($_GET['type']) && $_GET['type'] == 'assign') {
    $get_list_id = $_GET['type'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Project </title>

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

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>plugins/summernote/dist/summernote-bs4.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/style.css">


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
                            <h3 class="page-title"><?= isset($get_list_id) ? 'Assign' : 'My' ?> Projects</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?= isset($get_list_id) ? 'Assign' : 'My' ?> Projects</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <?php if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1) { ?>
                                <a href="<?= home_path() ?>/project/add" class="btn add-btn"><i class="fa fa-plus"></i> Create Project</a>
                            <?php } ?>
                            <?php
                            if (isset($get_list_id)) {
                            ?>
                                <a href="<?= home_path() ?>/project/list" class="btn add-btn mr-2">My Project</a>
                            <?php } else if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1) {
                            ?>
                                <a href="<?= home_path() ?>/project/list?type=assign" class="btn add-btn mr-2">Assignd Project</a>
                            <?php
                            } ?>


                        </div>
                    </div>
                </div>
                <!-- /Page Header -->



                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Project</th>
                                        <th>Start Date</th>
                                        <th>Assign <?= isset($get_list_id) ? 'By' : 'To' ?></th>
                                        <th>Deadline</th>
                                        <th>Priority</th>
                                        <!-- <th>Status</th> -->
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (isset($get_list_id)) {
                                    $result = get_all_project_details_of_login_user_assign($DB, $_SESSION['user_id']);
                                } else {
                                    $result = get_all_project_details_of_login_user($DB, $_SESSION['user_id']);
                                }


                                ?>
                                <tbody>

                                    <?php
                                    foreach ($result as $row) { ?>
                                        <tr>
                                            <?php
                                            $id = base64_encode($row['pm_id']);

                                            ?>
                                            <td>

                                            </td>
                                            <td>
                                                <a href="<?= home_path() . '/project/view_project?id=' . $id ?>">
                                                    <?= $row['project_title'] ?>
                                                </a>
                                            </td>

                                            <td><?= $row['pm_start_date'] ?></td>

                                            <td>

                                                <?php if (isset($get_list_id)) {
                                                    $check = get_user_details_by_id($DB, $row['pm_assign_by']);
                                                } else {
                                                    $check = get_user_details_by_id($DB, $row['pm_assign_to']);
                                                }
                                                ?>
                                                <a href="#"><?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></a>

                                            </td>

                                            <td><?= $row['pm_end_date'] ?></td>
                                            <td>
                                                <div class="dropdown action-label">
                                                    <?php if ($row['pm_priority'] == 1) {
                                                        echo '<a href="" class="btn btn-white btn-sm btn-rounded "  aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> High </a>';
                                                    } else if ($row['pm_priority'] == 2) {
                                                        echo '<a href="" class="btn btn-white btn-sm btn-rounded "  aria-expanded="false"><i class="fa fa-dot-circle-o text-warning"></i> Medium </a>';
                                                    } else {
                                                        echo '<a href="" class="btn btn-white btn-sm btn-rounded "  aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Easy </a>';
                                                    } ?>


                                                </div>
                                            </td>


                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="<?= home_path() . '/project/edit?id=' . base64_encode($row['pm_id']) ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                        <!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a> -->
                                                        <?php if ($row['pm_status'] != '3') { ?>
                                                            <button id="task_complete" class="dropdown-item" data-target="complete_<?= $row['pm_id'] ?>"><i class="fa fa-check m-r-5"></i> Complete</button>
                                                        <?php } ?>
                                                        <?php if ($row['pm_assign_by'] == $_SESSION['user_id'] && $row['pm_status'] != '3') { ?>
                                                            <button class="dropdown-item project_delete" data-target="delete_<?= $row['pm_id'] ?>">
                                                                <i class="fa fa-trash-o m-r-5"></i> Delete
                                                            </button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Page Content -->


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

    <!-- Datatable JS -->
    <script src="<?= get_assets() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= get_assets() ?>js/dataTables.bootstrap4.min.js"></script>

    <!-- Summernote JS -->
    <script src="<?= get_assets() ?>plugins/summernote/dist/summernote-bs4.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>


    <script>
        function send_request(send_data) {
            $.ajax({
                url: '<?= home_path() ?>/action/project.php?do=project_pick',
                method: 'POST',
                data: {
                    data: send_data
                },
                success: function(response) {
                    console.log(response);
                    const responseData = JSON.parse(response);
                    if (responseData.status == true) {
                        alert(responseData.msg);
                        location.reload();
                    } else {
                        alert(responseData.msg);
                        console.log(responseData.msg);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).on('click', '.project_delete', function() {
            let dropdownselect = $(this).attr('data-target');
            if (confirm('Are you sure you want to delete this project')) {
                send_request(dropdownselect);
            }

        })
    </script>


    <?php include_once FOOTER; ?>
</body>

</html>