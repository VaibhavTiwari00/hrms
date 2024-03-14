<?php

include_once '../../init.php';


$id = base64_decode($_GET['id']);

$results = get_all_project_details_by_id($DB, $id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Task View </title>

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
        .card-footer {
            text-align: center;
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
                            <h3 class="page-title"><?= $results[0]['project_title'] ?></h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Project</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <?php
                            if ($_SESSION['user_type'] == 2) { ?>
                                <a href="<?= home_path() . '/project/edit?id=' . base64_encode($results[0]['pm_id']) ?>" class="btn add-btn"><i class="fa fa-plus"></i> Edit Project</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-lg-8 col-xl-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="project-title">
                                    <h3 class="card-title mb-0"><?= $results[0]['project_title'] ?></h3>
                                    <small class="block text-ellipsis m-b-15"><span class="text-xs"> <?= get_all_pending_task_count_of_project($DB, $results[0]['pm_id']) ?></span> <span class="text-muted">pending tasks, </span><span class="text-xs"><?= get_all_task_count_of_project($DB, $results[0]['pm_id']) ?></span> <span class="text-muted">tasks completed</span></small>
                                </div>
                                <p><?= $results[0]['pm_desc'] ?></p>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title m-b-20">Uploaded files</h5>
                                <ul class="files-list">
                                    <?php
                                    $img_arr = json_decode($results[0]['pm_image']);
                                    if ($img_arr) {

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
                                                            <a href="" class="dropdown-toggle btn btn-link" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_horiz</i></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <p class="dropdown-item">Delete</p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                    <?php }
                                    } else {
                                        echo "No Found";
                                    } ?>

                                </ul>
                            </div>
                        </div>



                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title m-b-15">Project details</h6>
                                <table class="table table-striped table-border">
                                    <tbody>
                                        <!-- <tr>
                                            <td>Total Hours:</td>
                                            <td class="text-right">100 Hours</td>
                                        </tr> -->
                                        <tr>
                                            <td>Total Work Time:</td>
                                            <td class="text-right"><?= $results[0]['pm_total_time'] ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Start Date:</td>
                                            <td class="text-right"><?= $results[0]['pm_start_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Deadline:</td>
                                            <td class="text-right"><?= $results[0]['pm_end_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Priority:</td>
                                            <td class="text-right">
                                                <div class="btn-group">

                                                    <?php

                                                    if ($results[0]['pm_priority'] == 1) {
                                                        echo '<a href="#" class="badge badge-danger">High </a>';
                                                    } else if ($results[0]['pm_priority'] == 2) {
                                                        echo '<a href="#" class="badge badge-primary">Medium </a>';
                                                    } else {
                                                        echo '<a href="#" class="badge badge-success">Low </a>';
                                                    } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Assign by:</td>
                                            <td class="text-right"><a href="profile.php"> <?php $check = get_user_details_by_id($DB, $results[0]['pm_assign_by']) ?>
                                                    <a href="#"><?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></a></a></td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="card project-user">
                            <div class="card-body">
                                <h6 class="card-title m-b-20">
                                    Assigned Team
                                </h6>
                                <ul class="list-box">
                                    <?php

                                    if ($results[0]['pm_assign_to'] != '') {

                                        $team_id_arr  = explode(',', $results[0]['pm_assign_to']);

                                        foreach ($team_id_arr as $team_id) {
                                            $check = get_team_name_by_id($DB, $team_id);
                                    ?>
                                            <li>
                                                <a href="profile.php">
                                                    <div class="list-item">
                                                        <div class="list-left">
                                                            <!-- <span class="avatar"><img alt="" src="<?= get_assets() ?>users/<?= $check[0]['um_image'] ?>"></span> -->
                                                        </div>
                                                        <div class="list-body mb-3">
                                                            <span class="message-author"><?= $check[0]['team_name']  ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>

                                    <?php  }
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                        <!-- <div class="card project-user">
                            <div class="card-body">
                                <h6 class="card-title m-b-20">
                                    Assigned User
                                </h6>
                                <ul class="list-box">
                                    <?php $check = get_user_details_by_id($DB, $results[0]['pm_assign_to']) ?>
                                    <li>
                                        <a href="profile.php">
                                            <div class="list-item">
                                                <div class="list-left">
                                                    <span class="avatar"><img alt="" src="<?= get_assets() ?>users/<?= $check[0]['um_image'] ?>"></span>
                                                </div>
                                                <div class="list-body">
                                                    <span class="message-author"><?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></span>
                                                    <div class="clearfix"></div>
                                                    <span class="message-content">Web Designer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                        </div> -->
                    </div>


                </div>

                <div class="row mb-2 d-flex justify-content-end">
                    <a href="<?= home_path() ?>/tasks/add?id=<?= base64_encode($results[0]['pm_id']) ?>" class="btn add-btn mr-3">
                        <i class="fa fa-plus"></i> Create Task
                    </a>
                </div>
                <div class="row">

                    <div class="col-lg-12 col-xl-12 col-sm-12">

                        <div class="card">

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
                                                        <?php $res = get_all_task_details_of_projects($DB, $results[0]['pm_id']);

                                                        foreach ($res as $task) {
                                                        ?>
                                                            <li class="task <?= $task['tm_status'] == 3 ? 'completed' : ''; ?>">
                                                                <div class="task-container">
                                                                    <span class="task-action-btn task-check">
                                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                                            <i class="material-icons">check</i>
                                                                        </span>
                                                                    </span>
                                                                    <a href="<?= home_path() . "/tasks/view_task?id=" . base64_encode($task['tm_id'])  ?>">
                                                                        <span class="task-label"><?= $task['task_title'] ?></span>
                                                                    </a>


                                                                </div>
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
                                                        <?php $res = get_all_pending_task_details_of_projects($DB, $results[0]['pm_id']);

                                                        foreach ($res as $task) {
                                                        ?>
                                                            <li class="task">
                                                                <div class="task-container">
                                                                    <span class="task-action-btn task-check">
                                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                                            <i class="material-icons">check</i>
                                                                        </span>
                                                                    </span>
                                                                    <a href="<?= home_path() . "/tasks/view_task?id=" . base64_encode($task['tm_id'])  ?>">
                                                                        <span class="task-label"><?= $task['task_title'] ?></span>
                                                                    </a>
                                                                </div>
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
                                                        <?php $res = get_all_complete_task_details_of_projects($DB, $results[0]['pm_id']);

                                                        foreach ($res as $task) {
                                                        ?>
                                                            <li class="task">
                                                                <div class="task-container">
                                                                    <span class="task-action-btn task-check">
                                                                        <span class="action-circle large complete-btn" title="Mark Complete">
                                                                            <i class="material-icons">check</i>
                                                                        </span>
                                                                    </span>
                                                                    <a href="<?= home_path() . "/tasks/view_task?id=" . base64_encode($task['tm_id'])  ?>">
                                                                        <span class="task-label"><?= $task['task_title'] ?></span>
                                                                    </a>
                                                                </div>
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
                                <a href="http://localhost/saaol_work/project_HRA/HRA/tasks/list">View all Tasks</a>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
            <!-- /Page Content -->

            <!-- Assign Leader Modal -->
            <div id="assign_leader" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Leader to this project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group m-b-30">
                                <input placeholder="Search to add a leader" class="form-control search-input" type="text">
                                <span class="input-group-append">
                                    <button class="btn btn-primary">Search</button>
                                </span>
                            </div>
                            <div>
                                <ul class="chat-user-list">
                                    <li>
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar"><img alt="" src="<?= get_assets() ?>img/profiles/avatar-09.jpg"></span>
                                                <div class="media-body align-self-center text-nowrap">
                                                    <div class="user-name">Richard Miles</div>
                                                    <span class="designation">Web Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar"><img alt="" src="<?= get_assets() ?>img/profiles/avatar-10.jpg"></span>
                                                <div class="media-body align-self-center text-nowrap">
                                                    <div class="user-name">John Smith</div>
                                                    <span class="designation">Android Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-16.jpg">
                                                </span>
                                                <div class="media-body align-self-center text-nowrap">
                                                    <div class="user-name">Jeffery Lalor</div>
                                                    <span class="designation">Team Leader</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Assign Leader Modal -->

            <!-- Assign User Modal -->
            <div id="assign_user" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign the user to this project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group m-b-30">
                                <input placeholder="Search a user to assign" class="form-control search-input" type="text">
                                <span class="input-group-append">
                                    <button class="btn btn-primary">Search</button>
                                </span>
                            </div>
                            <div>
                                <ul class="chat-user-list">
                                    <li>
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar"><img alt="" src="<?= get_assets() ?>img/profiles/avatar-09.jpg"></span>
                                                <div class="media-body align-self-center text-nowrap">
                                                    <div class="user-name">Richard Miles</div>
                                                    <span class="designation">Web Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar"><img alt="" src="<?= get_assets() ?>img/profiles/avatar-10.jpg"></span>
                                                <div class="media-body align-self-center text-nowrap">
                                                    <div class="user-name">John Smith</div>
                                                    <span class="designation">Android Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="media">
                                                <span class="avatar">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-16.jpg">
                                                </span>
                                                <div class="media-body align-self-center text-nowrap">
                                                    <div class="user-name">Jeffery Lalor</div>
                                                    <span class="designation">Team Leader</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="submit-section">
                                <button class="btn btn-primary submit-btn">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Assign User Modal -->

            <!-- Edit Project Modal -->
            <div id="edit_project" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Project</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Project Name</label>
                                            <input class="form-control" value="Project Management" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Client</label>
                                            <select class="select">
                                                <option>Global Technologies</option>
                                                <option>Delta Infotech</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <div class="cal-icon">
                                                <input class="form-control datetimepicker" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>End Date</label>
                                            <div class="cal-icon">
                                                <input class="form-control datetimepicker" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Rate</label>
                                            <input placeholder="$50" class="form-control" value="$5000" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <select class="select">
                                                <option>Hourly</option>
                                                <option selected="">Fixed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Priority</label>
                                            <select class="select">
                                                <option selected="">High</option>
                                                <option>Medium</option>
                                                <option>Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Add Project Leader</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Team Leader</label>
                                            <div class="project-members">
                                                <a class="avatar" href="#" data-toggle="tooltip" title="Jeffery Lalor">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-16.jpg">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Add Team</label>
                                            <input class="form-control" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Team Members</label>
                                            <div class="project-members">
                                                <a class="avatar" href="#" data-toggle="tooltip" title="John Doe">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-02.jpg">
                                                </a>
                                                <a class="avatar" href="#" data-toggle="tooltip" title="Richard Miles">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-09.jpg">
                                                </a>
                                                <a class="avatar" href="#" data-toggle="tooltip" title="John Smith">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-10.jpg">
                                                </a>
                                                <a class="avatar" href="#" data-toggle="tooltip" title="Mike Litorus">
                                                    <img alt="" src="<?= get_assets() ?>img/profiles/avatar-05.jpg">
                                                </a>
                                                <span class="all-team">+2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea rows="4" class="form-control" placeholder="Enter your message here"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload Files</label>
                                    <input class="form-control" type="file">
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Edit Project Modal -->

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

    <!-- Task JS -->
    <script src="<?= get_assets() ?>js/task.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>

    <?php include_once FOOTER; ?>
</body>

</html>