<?php

include_once '../../init.php';


$id = base64_decode($_GET['id']);


$results = get_all_repetitive_task_details_by_id($DB, $id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Repetitive Task View </title>

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

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/dataTables.bootstrap4.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

    <link rel="stylesheet" href="<?= get_assets() ?>plugins/timeline/timeline.scss">


    <!-- Head -->
    <?php include_once HEAD; ?>
    <!-- /Head -->

    <style>
        #remark-heading {
            position: sticky;
            top: 0px;
            z-index: 999;
            background-color: #f7f7f7;
            padding: 15px 20px;
        }

        #card-body {
            max-height: 550px;
            overflow-y: scroll;
        }
    </style>
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

        .task_nav_item {
            cursor: pointer !important;
        }

        .dropdown-action {
            float: right;
        }

        #task_table tbody tr td:nth-child(10) {
            text-align: center !important;
        }

        @media screen and (max-width:1050px) {

            #task_table thead tr th,
            #task_table tbody tr td {
                text-align: center !important;
            }
        }
    </style>
</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php include_once HEADER; ?>
        <!-- Header -->

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
                            <h3 class="page-title">Repetitive Task Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Repetitive Task</li>
                            </ul>
                        </div>

                        <div class="col-auto float-right ml-auto">



                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-lg-8 col-xl-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="project-title">
                                    <h3 class="card-title"><?= $results[0]['rtm_title'] ?></h3>
                                </div>
                                <p><?= $results[0]['rtm_desc'] ?></p>

                            </div>
                        </div>
                        <?php
                        $img_arr = json_decode($results[0]['rtm_image']);
                        if (!empty($img_arr)) {
                        ?>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title m-b-20">Uploaded files</h5>
                                    <ul class="files-list">
                                        <?php
                                        foreach ($img_arr as $img) {
                                        ?>
                                            <li>
                                                <div class="files-cont">
                                                    <div class="file-type">
                                                        <span class="files-icon"><i class="fa fa-file-pdf-o"></i></span>
                                                    </div>
                                                    <div class="files-info">
                                                        <span class="file-name text-ellipsis mb-2">
                                                            <a download href="<?= get_assets() . '/test/' . $img ?>"><?= $img ?></a>
                                                        </span>
                                                    </div>
                                                    <ul class="files-action">
                                                        <li class="dropdown dropdown-action">
                                                            <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false">
                                                                <i class="material-icons">more_horiz</i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <button class="dropdown-item delete_file_btn" data_target="<?= 'T_' . $results[0]['rtm_id'] . '_' . $img ?>">Delete</button>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>

                                        <?php } ?>

                                    </ul>
                                </div>
                            </div>

                        <?php } ?>

                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title m-b-15">Repetitive Task details</h6>
                                <table class="table table-striped table-border">
                                    <tbody>
                                        <?php if ($results[0]['tm_reference_id'] != null) {
                                            $task_res = get_all_task_details_by_id($DB, $results[0]['tm_reference_id']);

                                        ?>
                                            <tr>
                                                <td>Reference Task:</td>
                                                <td class="text-right">
                                                    <a href="<?= home_path() . '/tasks/view_task?id=' . base64_encode($task_res[0]['tm_id']) ?>"><?= $task_res[0]['task_title'] ?> </a>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <td>Start Date:</td>
                                            <td class="text-right"><?= $results[0]['rtm_start_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Deadline:</td>
                                            <td class="text-right"><?= $results[0]['rtm_end_date'] ?></td>
                                        </tr>

                                        <tr>
                                            <td>Frequency Type:</td>

                                            <td class="text-right">
                                                <?php

                                                if ($results[0]['rtm_repetitive_type'] == 1) {
                                                    echo 'Daily';
                                                } else if ($results[0]['rtm_repetitive_type'] == 2) {
                                                    echo 'Weekly';
                                                } else if ($results[0]['rtm_repetitive_type'] == 3) {
                                                    echo 'Monthly';
                                                } else if ($results[0]['rtm_repetitive_type'] == 4) {
                                                    echo '-';
                                                } ?>

                                            </td>
                                        </tr>
                                        <?php if ($results[0]['rtm_repetitive_type'] == 4) { ?>
                                            <tr>
                                                <td>Repetitive Days:</td>

                                                <td class="text-right">
                                                    <?=

                                                    $results[0]['rtm_frequency_repeat_days'] ?>

                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>Priority:</td>
                                            <td class="text-right">
                                                <div class="btn-group">

                                                    <?php

                                                    if ($results[0]['rtm_priority'] == 1) {
                                                        echo '<a href="#" class="badge badge-danger">High </a>';
                                                    } else if ($results[0]['rtm_priority'] == 2) {
                                                        echo '<a href="#" class="badge badge-primary">Medium </a>';
                                                    } else {
                                                        echo '<a href="#" class="badge badge-success">Low </a>';
                                                    } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Assign by:</td>
                                            <td class="text-right"><a href="profile.php"> <?php $check = get_user_details_by_id($DB, $results[0]['rtm_assign_by']) ?>
                                                    <a href="#"><?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></a></a></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="card project-user">
                            <div class="card-body">
                                <h6 class="card-title m-b-20">
                                    Assigned User
                                </h6>
                                <ul class="list-box">
                                    <?php $check = get_user_details_by_id($DB, $results[0]['rtm_assign_to']) ?>
                                    <li>
                                        <a href="profile.php">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar"><img alt="" src="<?= get_assets() ?>users/<?= $check[0]['um_image'] ?>"></span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author"><?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></span>
                                                    <div class="clearfix"></div>
                                                    <?php $des_name = get_designation_name_by_id($DB, $check[0]['designation_id']);
                                                    ?>
                                                    <span class="message-content"><?= isset($des_name[0]['designation_name']) ? $des_name[0]['designation_name'] : ""; ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


            <!-- /Page Content -->


        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- Add Training Type Modal -->
    <?php include_once("../../includes/modals/complete/complete_reason.php"); ?>
    <!-- /Add Training Type Modal -->
    <!-- jQuery -->
    <script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="<?= get_assets() ?>js/popper.min.js"></script>
    <script src="<?= get_assets() ?>js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="<?= get_assets() ?>js/jquery.slimscroll.min.js"></script>

    <!-- Select2 JS -->
    <script src="<?= get_assets() ?>js/select2.min.js"></script>
    <!-- Datatable JS -->
    <script src="<?= get_assets() ?>js/jquery.dataTables.min.js"></script>
    <script src="<?= get_assets() ?>js/dataTables.bootstrap4.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="<?= get_assets() ?>js/moment.min.js"></script>
    <script src="<?= get_assets() ?>js/bootstrap-datetimepicker.min.js"></script>

    <!-- Task JS -->
    <script src="<?= get_assets() ?>js/task.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>

    <?php include_once FOOTER; ?>


    <script>
        document.getElementById('card-body').scrollTop = document.getElementById('card-body').scrollHeight;
        $(document).on('click', '.delete_file_btn', function() {
            event.stopPropagation();
            let file_select = $(this).attr('data_target');
            console.log(file_select)
            $.ajax({
                url: '../action/file_delete.php?do=delete_file',
                method: 'POST',
                data: {
                    data: file_select
                },
                success: function(response) {
                    const responseData = JSON.parse(response);

                    if (responseData.status == true) {
                        console.log(responseData.data)
                        alert(responseData.msg);
                        location.reload();

                    } else {
                        alert(responseData.msg);
                        $(this).prop('disabled', false);

                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                    alert(xhr.responseText);
                }
            });

        });
    </script>



</body>

</html>