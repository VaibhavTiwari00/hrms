<?php

include_once('../../init.php');

if (isset($_GET['id'])) {

    $pid = base64_decode($_GET['id']);
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
    <title>Tasks Add </title>

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
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>plugins/summernote/dist/summernote-bs4.css">

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
        .select {
            width: 100%;
        }

        .task_frequency {
            display: none;
        }

        .task_frequency_date {
            display: none;
        }

        .card-header {
            background-color: rgba(0, 0, 0, .03);
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
                            <h3 class="page-title">Add Task</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Task</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#edit_project"><i class="fa fa-plus"></i> Save Task</a>

                                <a href="task-board.php" class="btn btn-white float-right m-r-10" data-toggle="tooltip" title="Task Board"><i class="fa fa-bars"></i></a>
                            </div> -->
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <form id="addTask">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Task Name<span class="text-danger">*</span></label>
                                                <input class="form-control" id="task_name" name="task_name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Task Assign to<span class="text-danger">*</span></label>

                                                <select class="select" name="task_assign_to" id="task_assign_to">

                                                    <option value="">Select User</option>
                                                    <?php

                                                    $all_dept_user_data = get_all_manager_admin_list($DB);


                                                    foreach ($all_dept_user_data as $row) {
                                                    ?>
                                                        <option value="<?= $row['user_unique_id'] ?>"><?= $row['name'] . ' (' . $row['team_name'] . ')' ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Priority<span class="text-danger">*</span></label>
                                                <select class="select" name="task_priority" id="task_priority">
                                                    <option value="">Select Priority</option>
                                                    <option value="1">High</option>
                                                    <option value="2">Medium</option>
                                                    <option value="3">Low</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row d-none">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Task Type<span class="text-danger">*</span></label>
                                                <input class="form-control" id="task_type" name="task_type" type="text" value="0">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Start Date<span class="text-danger">*</span></label>
                                                <input name="task_start_date" id="start_date" class="form-control" required type="datetime-local">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>End Date<span class="text-danger endDate_star">*</span></label>
                                                <input name="task_end_date" id="end_date" class="form-control" type="datetime-local">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Task Description</label>
                                        <textarea rows="1" id="summernote" name="task_desc" class="form-control summernote" placeholder="Enter your message here"></textarea>
                                    </div>



                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn" id="submit_btn">Submit</button>
                                    </div>

                                </form>
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

    <!-- Summernote JS -->
    <script src="<?= get_assets() ?>plugins/summernote/dist/summernote-bs4.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>



    <script>
        $(document).ready(function() {
            // Apply Select2 to the select element with additional options
            $('#task_assign_to').select2({
                // Additional options here
            });
        });



        $('#addTask').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);


            if ($('#task_name').val() == '') {
                alert('title cannot be empty');
                return false;
            } else if ($('#task_project').val() == '') {
                alert('Select Some Project');
                return false;
            } else if ($('#task_assign_to').val() == '') {
                alert('Select Some User');
                return false;
            } else if ($('#task_priority').val() == '') {
                alert('Select Some priority');
                return false;
            } else if ($('#task_type').val() == '') {
                alert('Select Task Type');
                return false;
            } else {
                console.log($('#task_type').val());
                if ($('#task_type').val() != 1) {
                    if ($('#end_date').val() == '') {
                        alert('Select End Date');
                        return false;
                    }
                }
            }


            $('#submit_btn').prop('disabled', true);
            $.ajax({
                url: '../action/tasks.php?do=add_task',
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
        });
    </script>

    <?php include_once FOOTER; ?>
</body>

</html>