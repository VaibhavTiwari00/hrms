<?php
// error_reporting(0);
include('../init.php');

$session_user_id = $_SESSION['user_id'];

$res = get_user_details_by_id($DB, $session_user_id);

$team_id = $res[0]['team_id'];

$date = date('Y-m-d');


function timeUntilNextDay()
{
    // Get the current time and date
    $now = time();

    // Calculate the timestamp for the next day
    $nextDayTimestamp = strtotime('tomorrow', $now);

    // Calculate the time difference
    $timeLeftInSeconds = $nextDayTimestamp - $now - 3600;

    // Convert seconds into hours, minutes, and seconds
    $hours = floor($timeLeftInSeconds / 3600);
    $minutes = floor(($timeLeftInSeconds % 3600) / 60);
    $seconds = $timeLeftInSeconds % 60;

    // Return the time left as an associative array
    return array(
        'hours' => $hours,
        'minutes' => $minutes,
        'seconds' => $seconds
    );
}



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Dashboard</title>

    <!-- Head -->
    <?php include_once HEAD; ?>
    <!-- /Head -->

    <style>
        .live-dot:before {
            content: '';
            width: 5px;
            height: 5px;
            border: 5px solid #4471ff;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
            background-color: #445dff;
            z-index: 10;
            position: absolute;
            /* right: 37px; */
            top: 5px;
            left: -15px;
        }

        .blue,
        .blue .live-dot:before {
            border: 5px solid #4471ff !important;
            background-color: #4471ff !important;
        }

        .red,
        .red .live-dot:before {
            border: 5px solid red !important;
            background-color: red !important;
        }

        .orange,
        .orange .live-dot:before {
            border: 5px solid orange !important;
            background-color: orange !important;
        }

        .green,
        .green .live-dot:before {
            border: 5px solid #55ce63 !important;
            background-color: #55ce63 !important;
        }

        .table_home_font {
            font-size: 14px;
        }

        .btn-home-left-sm create_task_home_btn {
            min-width: 125px;
            float: left;
        }
    </style>

    <style>
        table.table td h2 {

            background: white !important;
            border: none !important;
        }

        .list_head {
            background-color: var(--dark-color);
            border-radius: 10px 10px 0 0;
            border-right: 1px solid white;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

        }


        .list_row {
            display: grid;
            grid-template-columns: 28% 27% 20% 25%;
        }


        .list_data {
            text-align: center;
            border-right: 2px solid #fff;
            padding: 8px 0;
            margin: auto 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #f1f1f1;
            border-collapse: collapse;
        }

        /* accordian */
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            /* padding: 18px 0; */
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
            /* margin-bottom: 10px; */
        }

        .active,
        .accordion:hover {
            background-color: #ccc;
        }

        .panel {
            /* padding: 0px 18px; */
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        p i {
            rotate: 0deg;
            transition: rotate 0.2s ease-out;
        }

        .panel p:last-child {
            margin-bottom: 20px;
        }

        .img-anchor {
            border-radius: 50%;
            width: 38px;
            height: 38px;
            object-fit: cover;
            margin-left: 5px;
        }

        .list_data .user-img .status {
            height: 12px;
            width: 12px;
            bottom: -2px;
        }

        .designation_heading {
            font-size: 13px;
        }

        .create_task_home_btn {
            float: unset !important;
        }

        .btn_check {
            font-size: 13px;
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="page-title">Welcome <?= $res[0]['salutation'] . ' ' . $res[0]['first_name'] . ' ' . $res[0]['last_name']  ?>!</h3>
                                <h4 class="">Login Time: <?= get_login_time_date_wise($DB, $date, $res[0]['user_unique_id']) ?></h4>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item ">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- /Page Header -->
                <?php

                if ($_SESSION['user_type'] != 5) {
                ?>
                    <div class="row">

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget">
                                <div class="card-body">
                                    <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                                    <div class="dash-widget-info">
                                        <h3><?= get_all_task_count_of_user($DB, $session_user_id) ?></h3>
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
                                        <h3><?= get_all_pending_task_count_of_user($DB, $session_user_id) ?></h3>
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
                                        <h3><?= get_all_complete_task_count_of_user($DB, $session_user_id) ?></h3>
                                        <span>Completed Task</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php
                }
                if ($_SESSION['user_type'] != 5) {
                ?>
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card card-table flex-fill">
                                <!-- <div class="card-header">
                                <h3 class="card-title mb-0">Recent Tasks</h3>
                            </div> -->
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
                                                            <?php $res = get_all_task_details_of_login_user($DB, $session_user_id);

                                                            foreach ($res as $task) {
                                                                if ($task['tm_status'] == 3) {
                                                                }
                                                            ?>

                                                                <li class="task <?= $task['tm_status'] == 3 ? 'completed' : ''; ?>">
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
                                                            <?php $res = get_pending_task_details_of_login_user($DB, $session_user_id);

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
                                                            <?php $res = get_complete_task_details_of_login_user($DB, $session_user_id);

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
                                    <a href="<?= home_path() ?>/tasks/list">View all Tasks</a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                }
                if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 4 || $_SESSION['user_type'] == 5) {

                    if ($_SESSION['user_type'] == 2) {
                        $data_emp =   get_all_team_employee($DB, $team_id);

                    ?>

                        <div class="row">
                            <div class="col-md-12 d-flex">
                                <div class="card card-table flex-fill">
                                    <div class="card-header " style="background:#ff9b44;color:#fff;">
                                        <h3 class="card-title mb-0 text-center" style="color:#fff;">Team Status</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table custom-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th class="text-center">Time Summary</th>

                                                        <th class="text-center" style="min-width:200px">Active Status</th>
                                                        <th class="text-center">Today Task Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($data_emp as $row) {

                                                        $check = get_active_time_date_wise($DB, $date, $row['user_unique_id']);

                                                        if ($check == 'Absent') {
                                                            $live_status = 'red';
                                                        } else if ($check == 'Logout') {
                                                            $live_status = 'orange';
                                                        } else if ($check == 'Active') {
                                                            $live_status = 'blue';
                                                        } else if ($check == 'Inactive') {
                                                            $live_status = 'green';
                                                        } else {
                                                            $live_status = '';
                                                        }

                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <h2 class="<?= $live_status ?>">
                                                                    <a href="<?= home_path() . "/user/user_view?id=" . base64_encode($row['user_unique_id']) ?>" class="live-dot ml-2" style="position:relative;">
                                                                        <?= $row['salutation'] . ' ' . $row['first_name'] . ' ' . $row['last_name']  ?>
                                                                    </a>
                                                                </h2>

                                                                <small class="block text-ellipsis">
                                                                    <span><?= get_all_pending_task_count_of_user($DB, $row['user_unique_id']) ?></span> <span class="text-muted">pending tasks, </span>
                                                                    <span><?= get_all_task_count_of_user($DB, $row['user_unique_id']) ?> </span> <span class="text-muted">total tasks </span>
                                                                </small>
                                                            </td>

                                                            <?php $login_time = get_login_time_date_wise($DB, $date, $row['user_unique_id']);
                                                            $logout_time = get_logout_time_date_wise($DB, $date, $row['user_unique_id']);
                                                            $working_time = get_working_time_date_wise($DB, $date, $row['user_unique_id']);
                                                            if ($login_time !== 'Absent') {
                                                            ?>
                                                                <td class="text-center">

                                                                    <b>Login:</b>
                                                                    <?= $login_time ?> | <b>working: </b> <?= $working_time ?> <br>
                                                                    |
                                                                    <b>Idle:</b> --:--:-- | <b>break:</b> <?= get_break_time_acc_date($DB, $date, $row['user_unique_id'])   ?> | <b>Logout:</b> <?= $logout_time == 'Active' ? '--:--' : $logout_time; ?>

                                                                </td>

                                                            <?php } else { ?>
                                                                <td class="text-center"> Absent</td>
                                                            <?php
                                                            } ?>


                                                            <?php $res = get_active_task_of_any_user($DB, $row['user_unique_id']);

                                                            $res_pending = get_all_pending_task_count_of_user($DB, $row['user_unique_id']);
                                                            ?>

                                                            <td class="table_home_font text-center" style="min-width:200px">
                                                                <?php
                                                                if ($login_time)
                                                                    if (empty($res)) {
                                                                        if ($res_pending == 0) {
                                                                            if ($_SESSION['user_type'] == 1) {
                                                                                if ($row['ut_id'] == '2') {
                                                                                    echo "<p class='mb-0'><a href='" . home_path() . "/tasks/add' class='btn btn-sm add-btn btn-home-left-sm create_task_home_btn'><i class='fa fa-plus'></i> Create Task</a></p>";
                                                                                } else {
                                                                                    echo "<span class='badge bg-inverse-warning'>Not Working</span>";
                                                                                }
                                                                            } else if ($_SESSION['user_type'] == 2) {
                                                                                echo "<p class='mb-0'><a href='" . home_path() . "/tasks/add' class='btn btn-sm add-btn btn-home-left-sm create_task_home_btn'><i class='fa fa-plus'></i> Create Task</a></p>";
                                                                            }
                                                                        } else {
                                                                            echo "<span class='badge bg-inverse-danger'>Not Pick Up the task</span>";
                                                                        }
                                                                    } else {
                                                                        echo $res[0]['task_title'];
                                                                    }
                                                                ?>
                                                            </td>


                                                            <td class="table_home_font text-center">
                                                                <?php
                                                                if ($login_time !== 'Absent') { ?>

                                                                    <p class="mb-0">
                                                                        <span>Active Task:</span> <b>
                                                                            <?=
                                                                            json_decode(get_how_many_task_user_active_datewise($DB, $row['user_unique_id'], 1, null), true)['rowCount'];
                                                                            ?></b>
                                                                        <br> <span>Complete Task:</span> <b>
                                                                            <?=
                                                                            json_decode(get_how_many_task_user_active_datewise($DB, $row['user_unique_id'], 3, null), true)['rowCount'] ?></b>

                                                                        <br>
                                                                        <a class="btn btn-sm mb-0 status_btn btn-success btn_check" style="color:#fff;" href="<?= home_path() . '/user/user_activity?id=' . base64_encode($row['user_unique_id']) ?>">Activity</a>

                                                                    </p>

                                                                <?php } else {
                                                                    echo 'Absent';
                                                                } ?>
                                                            </td>
                                                        </tr>

                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>

                    <?php } else if ($_SESSION['user_type'] == 1 || $_SESSION['user_type'] == 4 || $_SESSION['user_type'] == 5) {
                        $data_emp =   get_all_team_details($DB);
                    ?>

                        <div class="row ">
                            <section class="col-md-12 pricing w-100 ">
                                <div class="card-header " style="background:#ff9b44;color:#fff;">
                                    <h3 class="card-title mb-0 text-center" style="color:#fff;">Team Status</h3>

                                </div>

                                <div class="table-responsive">
                                    <table class="table custom-table mb-0">
                                        <thead>
                                            <tr class="list_row">
                                                <th class="list_data" style="display:block;text-align:left;min-width:250px;">Name</th>
                                                <th class="list_data">Time Summary</th>
                                                <th class="list_data" style="min-width:200px;">Active Task</th>
                                                <th class="list_data" style="min-width:200px;">Today Task Status</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>


                                <?php

                                foreach ($data_emp as $row) {
                                    $team_res = get_all_team_employee_manager($DB, $row['team_id']);

                                ?>
                                    <div class="accordion">
                                        <div class="list_row" style="grid-template-columns: repeat(1,1fr)">
                                            <div class="list_data " style="display: block; text-align:left;">
                                                <p class=" mb-0 mx-3 w-90 d-flex align-items-center justify-content-between">
                                                    <?php
                                                    $present_team_status = get_count_present_team_employee_manager($DB, $row['team_id'], $date)
                                                    ?>
                                                    <a class="ml-2" style="position:relative;">
                                                        <b> <?= $row['team_name'] . " </b>( Present : " . $present_team_status['present'] . " | Total : " . $present_team_status['all'] . " )" ?>
                                                    </a>
                                                    <?php if ($team_res) { ?>
                                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                                    <?php } ?>
                                                </p>


                                            </div>



                                        </div>
                                        <div class="panel">

                                            <?php

                                            foreach ($team_res as $rowres) {

                                                $check = get_active_time_date_wise($DB, $date, $rowres['user_unique_id']);

                                                if ($check == 'Absent') {
                                                    $live_statuss = 'red';
                                                } else if ($check == 'Logout') {
                                                    $live_statuss = 'orange';
                                                } else if ($check == 'Active') {
                                                    $live_statuss = 'blue';
                                                } else if ($check == 'Inactive') {
                                                    $live_statuss = 'green';
                                                } else {
                                                    $live_statuss = '';
                                                }

                                            ?>
                                                <div class="list_row ">
                                                    <div class="list_data" style="display: block; text-align:left; min-width:250px; ">
                                                        <div class="<?= home_path() . '/tasks/view_task?id=' . base64_encode($task['tm_id']) ?>">

                                                            <div class="d-flex align-items-center ">
                                                                <div class="user-img">
                                                                    <img class="img-anchor" src="<?= get_assets() ?>/users/<?= $rowres['um_image'] ?>" alt="User Picture">
                                                                    <span class="status online <?= $live_statuss ?>"></span>
                                                                </div>
                                                                <div>
                                                                    <a style="text-decoration:underline;" class="mb-0 ml-2" href=" <?= home_path() . "/user/user_view?id=" . base64_encode($rowres['user_unique_id']) ?>">
                                                                        <?= $rowres['salutation'] . ' ' . $rowres['first_name'] . ' ' . $rowres['last_name']  ?>
                                                                        <?php $team_res = get_designation_name_by_id($DB, $rowres['designation_id']);

                                                                        ?>
                                                                    </a>
                                                                    <!-- <a class="btn btn-sm mb-0 status_btn btn-success btn_check" style="color:#fff;" href="<?= home_path() . '/user/user_activity?id=' . base64_encode($rowres['user_unique_id']) ?>">Activity</a> -->
                                                                    <p class="text-muted mb-0 ml-2 designation_heading"><?= !empty($team_res) ?  $team_res[0]['designation_name'] : '' ?> </p>
                                                                    <small class="block text-ellipsis ml-2">
                                                                        <small style="font-size: 95%;">

                                                                            <span><?= get_all_pending_task_count_of_user($DB, $rowres['user_unique_id']) ?></span> <span class="text-muted">pending / </span>
                                                                            <span><?= get_all_task_count_of_user($DB, $rowres['user_unique_id']) ?> </span>
                                                                            <span class="text-muted"> completed </span>
                                                                            <?php if ($rowres['ut_id'] == 2) { ?>
                                                                                <span class="text-muted">/</span>
                                                                                <a href="<?= home_path() . '/tasks/list?type=assign&user=' . base64_encode($rowres['user_unique_id']) ?>" style="text-decoration:underline;">

                                                                                    <?= get_all_task_count_of_user_assign($DB, $rowres['user_unique_id']); ?>
                                                                                    <span class="text-muted">Assigned</span>
                                                                                </a>
                                                                            <?php } ?>

                                                                        </small>

                                                                    </small>
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                    <?php $login_time = get_login_time_date_wise($DB, $date, $rowres['user_unique_id']);
                                                    $logout_time = get_logout_time_date_wise($DB, $date, $rowres['user_unique_id']);
                                                    $working_time = get_working_time_date_wise($DB, $date, $rowres['user_unique_id']);
                                                    if ($login_time !== 'Absent') {
                                                    ?>
                                                        <div class="list_data">

                                                            <p class="mb-0">
                                                                <span>Login:</span> <b><?=
                                                                                        $login_time
                                                                                        ?></b> |
                                                                <span>Logout:</span> <b>
                                                                    <?=
                                                                    $logout_time == 'Active' ? '--:--' : $logout_time;
                                                                    ?></b> <br> |
                                                                <span>working: </span> <b><?= $working_time ?></b>
                                                                <br> |
                                                                <span>Idle:</span> <b>--:--:--</b> |
                                                                <span>break:</span> <b><?= get_break_time_acc_date($DB, date('y-m-d'), $rowres['user_unique_id'])   ?></b>
                                                            </p>

                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="list_data"> Absent</div>
                                                    <?php
                                                    } ?>



                                                    <div class="list_data" style="min-width:200px">
                                                        <?php $res_task = get_active_task_of_any_user($DB, $rowres['user_unique_id']);

                                                        $res_pending = get_all_pending_task_count_of_user($DB, $rowres['user_unique_id']);
                                                        ?>

                                                        <td class="table_home_font ">
                                                            <?php
                                                            if ($login_time !== 'Absent') {
                                                                if (empty($res_task)) {
                                                                    if ($res_pending == 0) {
                                                                        if ($_SESSION['user_type'] == 1) {
                                                                            if ($rowres['ut_id'] == '2') {
                                                                                echo "<a href='" . home_path() . "/tasks/add' class='btn btn-sm add-btn btn-home-left-sm create_task_home_btn '><i class='fa fa-plus'></i> Create Task</a>";
                                                                            } else {
                                                                                echo "<span class='badge bg-inverse-warning'>Not Working</span>";
                                                                            }
                                                                        } else if ($_SESSION['user_type'] == 2) {
                                                                            echo "<a href='" . home_path() . "/tasks/add' class='btn btn-sm add-btn btn-home-left-sm create_task_home_btn'><i class='fa fa-plus'></i> Create Task</a>";
                                                                        }
                                                                    } else {
                                                                        echo "<span class='badge bg-inverse-danger'>Not Pick Up the task</span>";
                                                                    }
                                                                } else {
                                                                    echo $res_task[0]['task_title'];
                                                                }
                                                            } else {
                                                                echo "Absent";
                                                            }
                                                            ?>
                                                        </td>
                                                    </div>

                                                    <div class="list_data" style="min-width:200px">
                                                        <?php
                                                        if ($login_time !== 'Absent') { ?>

                                                            <p class="mb-0">
                                                                <span>Active Task:</span> <b>
                                                                    <?=
                                                                    json_decode(get_how_many_task_user_active_datewise($DB, $rowres['user_unique_id'], 1, null), true)['rowCount'];
                                                                    ?></b>
                                                                <br> <span>Complete Task:</span> <b>
                                                                    <?=
                                                                    json_decode(get_how_many_task_user_active_datewise($DB, $rowres['user_unique_id'], 3, null), true)['rowCount'] ?></b>

                                                                <br>
                                                                <a class="btn btn-sm mb-0 status_btn btn-success btn_check" style="color:#fff;" href="<?= home_path() . '/user/user_activity?id=' . base64_encode($rowres['user_unique_id']) ?>">Activity</a>

                                                            </p>

                                                        <?php } else {
                                                            echo 'Absent';
                                                        } ?>
                                                    </div>

                                                </div>
                                            <?php } ?>

                                        </div>
                                    </div>



                                <?php } ?>





                            </section>
                        </div>

                <?php }
                } ?>


            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- javascript links starts here -->
    <!-- jQuery -->
    <script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>

    <!-- Bootstrap Core JS -->
    <script src="<?= get_assets() ?>js/popper.min.js"></script>
    <script src="<?= get_assets() ?>js/bootstrap.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="<?= get_assets() ?>js/jquery.slimscroll.min.js"></script>

    <!-- Chart JS -->
    <script src="<?= get_assets() ?>plugins/morris/morris.min.js"></script>
    <script src="<?= get_assets() ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?= get_assets() ?>js/chart.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>
    <!-- javascript links ends here  -->


    <?php include_once FOOTER; ?>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var icon = this.children[0].children[0].children[0].children[1];
                var panel = this.children[1];
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                    icon.style.rotate = ' 0deg';
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                    icon.style.rotate = '180deg';
                }
            });
        }
    </script>
</body>

</html>