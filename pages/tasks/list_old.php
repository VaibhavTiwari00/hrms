<?php
include_once '../../init.php';


error_reporting(1);


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
    <title>Tasks </title>

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

    <style>
        .status_btn {
            cursor: text !important;
            font-size: 0.7rem;
        }

        .priority_btn {
            cursor: text !important;
        }

        .dropdown_time,
        .btn_active_inactive {
            cursor: pointer !important;
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
                    <div class="row align-items-center">

                        <div class="col">
                            <h3 class="page-title"><?= isset($get_list_id) ? 'Assign' : 'My' ?> Tasks</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?= isset($get_list_id) ? 'Assign' : 'My' ?> Tasks</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <?php if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1) { ?>
                                <a href="<?= home_path() ?>/tasks/add" class="btn add-btn"><i class="fa fa-plus"></i> Create Task</a>
                            <?php } ?>
                            <?php
                            if (isset($get_list_id)) {
                            ?>
                                <a href="<?= home_path() ?>/tasks/list" class="btn add-btn mr-2">My Task</a>
                            <?php } else if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1) {
                            ?>
                                <a href="<?= home_path() ?>/tasks/list?type=assign" class="btn add-btn mr-2">Assignd Task</a>
                            <?php
                            } ?>



                            <div class="view-icons">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <!-- Search Filter -->

               
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table datatable" id="task_table">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th style="max-width:150px">Task</th>
                                        <th>Project Name</th>
                                        <th>Start Date</th>
                                        <th>Assign <?= isset($get_list_id) ? 'To' : 'By' ?></th>
                                        <th>Deadline</th>
                                        <th>Priority</th>
                                        <th>Active Status</th>
                                        <th>Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                if (isset($get_list_id)) {
                                    $result = get_all_task_details_of_login_user_assign($DB, $_SESSION['user_id']);
                                } else {
                                    $result = get_all_task_details_of_login_user($DB, $_SESSION['user_id']);
                                }

                                ?>
                                <tbody>

                                    <?php
                                    foreach ($result as $row) { ?>
                                        <tr>
                                            <?php
                                            $id = base64_encode($row['tm_id']);

                                            ?>
                                            <td>

                                            </td>

                                            <td>
                                                <a href="<?= home_path() . '/tasks/view_task?id=' . $id ?>">
                                                    <?= $row['task_title'] ?>
                                                </a>
                                            </td>



                                            <?php $res =   get_all_project_details_by_id($DB, $row['pm_id']) ?>

                                            <td><?= $res[0]['project_title'] ?></td>
                                            <td><?= india_dateTime_format($row['tm_start_date']) ?></td>
                                            <td>

                                                <?php if (isset($get_list_id)) {
                                                    $check = get_user_details_by_id($DB, $row['tm_assign_to']);
                                                } else {
                                                    $check = get_user_details_by_id($DB, $row['tm_assign_by']);
                                                }

                                                ?>
                                                <a href="#">
                                                    <?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></a>

                                            </td>

                                            <td><?= india_dateTime_format($row['tm_end_date']) ?></td>

                                            <td>
                                                <div class="dropdown action-label">
                                                    <?php if ($row['tm_priority'] == 1) {
                                                        echo '<a  class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> High </a>';
                                                    } else if ($row['tm_priority'] == 2) {
                                                        echo '<a  class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-warning"></i> Medium </a>';
                                                    } else {
                                                        echo '<a  class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Easy </a>';
                                                    } ?>


                                                </div>
                                            </td>

                                            <td>
                                                <div class="dropdown action-label">
                                                    <?php
                                                    $check_dropdown_time = $row['tm_active'] == 0 ? 'inactive' : 'active';
                                                    $color_success = $row['tm_active'] == 0 ? 'danger' : 'success';


                                                    if (isset($get_list_id)) {
                                                        echo '<a href="" class="btn btn-white btn-sm btn-rounded "><i class="fa fa-dot-circle-o text-' . $color_success . '"></i>
                                                            ' . $check_dropdown_time . '</a>';
                                                    } else {
                                                        if ($row['tm_status'] == '3' || $row['tm_status'] == '2') {
                                                            echo '<a class="btn btn-white btn-sm btn-rounded btn_active_inactive">
                                                            <i class="fa fa-dot-circle-o text-' . $color_success . '"></i>
                                                            ' . $check_dropdown_time . '</a>';
                                                        } else {
                                                    ?>

                                                            <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" id="parent_dropdown_<?= $row['tm_id'] ?>" data-target="<?= $check_dropdown_time . '_' . $row['tm_id'] ?>" aria-expanded="false">
                                                                <i class="fa fa-dot-circle-o text-<?= $color_success ?>"></i>
                                                                <?= $check_dropdown_time ?>
                                                            </a>

                                                        <?php }
                                                    }
                                                    if (isset($get_list_id)) {
                                                    } else { ?>
                                                        <div class="dropdown-menu">
                                                            <p class="dropdown-item mb-0 dropdown_time" data-target="active_<?= $row['tm_id'] ?>"><i class="fa fa-dot-circle-o text-success"></i> Active</p>
                                                            <p class="dropdown-item mb-0 dropdown_time" data-target="inactive_<?= $row['tm_id'] ?>"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td style="text-align:center;">

                                                <?php if ($row['tm_status'] == '0') { ?>
                                                    <p class="btn btn-sm mb-0 status_btn btn-success">New</p>
                                                <?php } else if ($row['tm_status'] == '1') { ?>
                                                    <p class="btn btn-sm mb-0 status_btn btn-primary">Running</p>
                                                <?php } else if ($row['tm_status'] == '3') { ?>
                                                    <p class="btn btn-sm mb-0 status_btn btn-info">Completed</p>
                                                <?php } else if ($row['tm_status'] == '2') { ?>
                                                    <p class="btn btn-sm mb-0 status_btn btn-danger">Approval Pending</p>
                                                <?php } ?>

                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <?php if ($row['tm_assign_by'] == $_SESSION['user_id'] && $row['tm_status'] != '3') { ?>
                                                            <a class="dropdown-item" href="<?= home_path() . '/tasks/edit?id=' . base64_encode($row['tm_id']) ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a><?php } ?>
                                                        <!-- final complete -->
                                                        <?php if ($row['tm_status'] == '2' && $row['tm_assign_by'] == $_SESSION['user_id']) { ?>
                                                            <!-- <button class="dropdown-item task_complete" data-target="complete_<?= $row['tm_id'] ?>">
                                                            <i class="fa fa-check m-r-5"></i> Complete</button> -->
                                                            <button class="dropdown-item complete_task" data-toggle="modal" data_value="<?= $row['tm_id'] ?>" data-target="#complete_reason">
                                                                <i class="fa fa-check m-r-5"></i>
                                                                Complete
                                                            </button>
                                                        <?php } ?>

                                                        <?php if ($row['tm_status'] == '0' && isset($get_list_id)) { ?>
                                                            <button class="dropdown-item task_delete" data-target="delete_<?= $row['tm_id'] ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</button>
                                                        <?php } ?>
                                                        <!-- sent for approval  -->
                                                        <?php if ($row['tm_status'] != '3' && $row['tm_status'] != '2' && $row['tm_assign_to'] == $_SESSION['user_id'] && !isset($get_list_id)) { ?>
                                                            <button class="dropdown-item follow_up_task" data-toggle="modal" data_value="<?= $row['tm_id'] ?>" data-target="#follow_up_reason">
                                                                <i class="fa fa-check m-r-5"></i>
                                                                Sent For Approval
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

    <!-- Add Training Type Modal -->
    <?php include_once("../../includes/modals/complete/complete_reason.php"); ?>
    <!-- /Add Training Type Modal -->

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
                url: '<?= home_path() ?>/action/tasks.php?do=task_pick',
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
                        $('#submit_btn').prop('disabled', false);
                        console.log(responseData.msg);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        }
        $(document).on('click', '.dropdown_time', function() {
            let dropdownselect = $(this).attr('data-target');
            console.log(dropdownselect)

            const parent_dropdown_time = $('#parent_dropdown_' + $(this).attr('data-target').split('_')[1]).attr('data-target');

            console.log(parent_dropdown_time);
            if (parent_dropdown_time == dropdownselect) {
                alert('already selected');
            } else {
                send_request(dropdownselect);
            }
        })

        $(document).on('click', '.task_complete', function() {
            let dropdownselect = $(this).attr('data-target');
            send_request(dropdownselect);
        })

        $(document).on('click', '.task_delete', function() {

            let dropdownselect = $(this).attr('data-target');
            if (confirm('Are you sure you want to delete this task')) {
                send_request(dropdownselect);
            }
        })
    </script>


    <script>
        $(document).on('click', '.follow_up_task', function() {
            $('#follow_up_reason').modal('toggle');
            var task_id = $(this).attr('data_value');
            $('#task_id').val(task_id);

        })

        $(document).on('click', '.complete_task', function() {
            $('#complete_reason').modal('toggle');
            var task_reassign_id = $(this).attr('data_value');
            $('#task_reassign_id').val(task_reassign_id);
            console.log(task_reassign_id);

        })

        $(document).ready(function() {
            // Attach a click event handler to the button
            $("#form_toggle_btn").click(function() {
                // Toggle the visibility of the div with a slide animation

                $("#reassign_form").slideToggle();
            });
        });

        $('#follow_up_form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);

            if ($('#task_reason').val() == '') {
                alert('Please Add Some Remark');
                return false;
            } else if ($('#task_id').val() == '') {
                alert('Error');
                return false;
            }

            // $('#submit_btn').prop('disabled', true);

            $.ajax({
                url: '../action/tasks.php?do=follow_up',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    const responseData = JSON.parse(response);
                    console.log(responseData);
                    if (responseData.status == true) {
                        alert(responseData.msg);
                        window.location.href = "<?= home_path() ?>/tasks/list";
                    } else {
                        alert(responseData.msg);
                        $('#submit_btn').prop('disabled', false);
                        console.log(responseData.msg);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });


        $('#reassign_form').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);

            if ($('#task_reassign_reason').val() == '') {
                alert('Please Add Some Remark');
                return false;
            } else if ($('#task_reassign_id').val() == '') {
                alert('Error');
                return false;
            }

            console.log($('#task_reassign_reason').val(), $('#task_reassign_id').val());
            $('#submit_btn').prop('disabled', true);

            $.ajax({
                url: '../action/tasks.php?do=reassign_task',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    const responseData = JSON.parse(response);
                    console.log(responseData);
                    if (responseData.status == true) {
                        alert(responseData.msg);
                        window.location.href = "<?= home_path() ?>/tasks/list";
                    } else {
                        alert(responseData.msg);
                        $('#submit_btn').prop('disabled', false);
                        console.log(responseData.msg);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).on('click', '#final_complete', function() {

            var task_id_complete = $('#task_reassign_id').val();
            console.log(task_id_complete);

            $.ajax({
                url: '../action/tasks.php?do=complete_task',
                method: 'POST',
                data: {
                    data: task_id_complete,
                },
                success: function(response) {
                    console.log(response);
                    const responseData = JSON.parse(response);
                    console.log(responseData);
                    if (responseData.status == true) {
                        alert(responseData.msg);
                        window.location.href = "<?= home_path() ?>/tasks/list?type=assign";
                    } else {
                        alert(responseData.msg);
                        $('#submit_btn').prop('disabled', false);
                        console.log(responseData.msg);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        })
    </script>


    <?php include_once FOOTER; ?>
</body>

</html>