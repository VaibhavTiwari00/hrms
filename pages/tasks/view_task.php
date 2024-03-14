<?php

include_once '../../init.php';


$id = base64_decode($_GET['id']);


$results = get_all_task_details_by_id($DB, $id);

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

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/dataTables.bootstrap4.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap-datetimepicker.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

    <link rel="stylesheet" href="<?= get_assets() ?>plugins/timeline/timeline.scss">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
			<script src="<?= get_assets() ?>js/html5shiv.min.js"></script>
			<script src="<?= get_assets() ?>js/respond.min.js"></script>
		<![endif]-->


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

        .activity-badge.badge-bg-info {
            background: #E6F5FF;
            color: #9368E9;
        }
.reallocate_btn {
            background-color: #9368E9;
        }

        .reallocate_btn:hover {
            background-color: #9368E4;
        }
        .activity-badge {
            padding: 5px 10px;
            display: inline-flex;
            align-items: center;
            font-size: 12px;
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
                            <h3 class="page-title">Task Details</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Task</li>
                            </ul>
                        </div>

                        <div class="col-auto float-right ml-auto">
                            <?php
                            if ($results[0]['tm_assign_by'] == $_SESSION['user_id'] && $results[0]['tm_status'] != '3') { ?>
                                <a href="<?= home_path() . '/tasks/edit?id=' . base64_encode($results[0]['tm_id']) ?>" class="btn add-btn"><i class="fa fa-plus"></i> Edit Task</a>
                            <?php } ?>
                            <?php
                            if ($results[0]['tm_status'] == '2' && $results[0]['tm_assign_by'] == $_SESSION['user_id']) { ?>
                                <button class="btn add-btn mx-2 " id="final_complete" data-toggle="modal" data_value="<?= $results[0]['tm_id'] ?>" data-target="#complete_task">
                                    <i class="fa fa-check" aria-hidden="true"></i> Complete Task</button>
                                <button class="btn add-btn complete_task" data-toggle="modal" data_value="<?= $results[0]['tm_id'] ?>" data-target="#complete_reason">
                                    <i class="fa fa-retweet" aria-hidden="true"></i> Reassign Task
                                </button>
                            <?php } ?>
                            <?php
                            if ($results[0]['tm_status'] != '3' && $results[0]['tm_status'] != '2' && $results[0]['tm_assign_to'] == $_SESSION['user_id']) { ?>
                                <button class="btn add-btn follow_up_task mr-3" data-toggle="modal" data_value="<?= $results[0]['tm_id'] ?>" data-target="#follow_up_reason">
                                    <i class="fa fa-check m-r-5"></i>
                                    Sent For Approval
                                </button>
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
                                    <h3 class="card-title"><?= $results[0]['task_title'] ?></h3>
                                </div>
                                <p><?= $results[0]['tm_desc'] ?></p>

                            </div>
                        </div>
                        <?php
                        $img_arr = json_decode($results[0]['tm_image']);
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
                                                                <button class="dropdown-item delete_file_btn" data_target="<?= 'T_' . $results[0]['tm_id'] . '_' . $img ?>">Delete</button>
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
                        <?php $remarks = get_task_remarks($DB, $results[0]['tm_id']);

                        $i = 1;
                        if (!empty($remarks)) { ?>
                            <div class="card">
                                <h5 class="card-title mb-0" id="remark-heading">Remarks</h5>
                                <div class="card-body" id="card-body">

                                    <ul class="timeline">


                                        <?php foreach ($remarks as $row) {
                                            $timeline_user =   get_user_details_by_id($DB, $row['created_by']);

                                        ?>
                                            <li class="<?= $i % 2 != 0 ? "" : "timeline-inverted" ?>">
                                                <div class="timeline-badge success">
                                                    <span class="avatar m-0">
                                                        <img alt="" src="<?= get_assets() ?>users/<?= $timeline_user[0]['um_image'] ?>">
                                                    </span>
                                                </div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-body">
                                                        <p class="mb-3"><?= $row['remarks'] ?></p>
                                                        <small class="float-right"><?= $row['created_date'] ?></small>
                                                    </div>
                                                </div>
                                            </li>

                                        <?php $i++;
                                        } ?>


                                    </ul>


                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title m-b-15">Project details</h6>
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
                                            <td>Total Work Time:</td>
                                            <td class="text-right"><?= $results[0]['tm_total_time'] ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Start Date:</td>
                                            <td class="text-right"><?= $results[0]['tm_start_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Deadline:</td>
                                            <td class="text-right"><?= $results[0]['tm_end_date'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Priority:</td>
                                            <td class="text-right">
                                                <div class="btn-group">

                                                    <?php

                                                    if ($results[0]['tm_priority'] == 1) {
                                                        echo '<a href="#" class="badge badge-danger">High </a>';
                                                    } else if ($results[0]['tm_priority'] == 2) {
                                                        echo '<a href="#" class="badge badge-primary">Medium </a>';
                                                    } else {
                                                        echo '<a href="#" class="badge badge-success">Low </a>';
                                                    } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Assign by:</td>
                                            <td class="text-right"><a href="profile.php"> <?php $check = get_user_details_by_id($DB, $results[0]['tm_assign_by']) ?>
                                                    <a href="#"><?= $check[0]['first_name'] . ' ' . $check[0]['last_name'] ?></a></a></td>
                                        </tr>
                                        <tr>
                                            <td>Active:</td>
                                            <td class="text-right"><?= $results[0]['tm_active'] == 0 ? 'Inactive' : 'Active' ?></td>
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
                                    <?php $check = get_user_details_by_id($DB, $results[0]['tm_assign_to']) ?>
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

                <div class="row">


                    <div class="col-md-12 col-12 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Reallocated Task</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table " id="task_table">
                                        <thead>
                                            <tr>
                                                <th style="min-width:50px;">Sr.No.</th>
                                                <th style="max-width:150px;min-width:120px;">Task</th>

                                                <?php if ($_SESSION['user_type'] == 5) {
                                                } else { ?>
                                                    <th style="max-width:150px;min-width:120px;">Project Name </th>
                                                <?php } ?>

                                                <th style="min-width:90px;">Start Date</th>
                                                <th style="min-width:90px;">Assigned By</th>
                                                <th style="min-width:90px;">Deadline</th>
                                                <th style="min-width:90px;">Priority</th>
                                                <th style="min-width:90px;">Active Status</th>
                                                <th style="min-width:90px;text-align:center;">Status</th>
                                                <th class="text-right" style="min-width:90px;">Action</th>

                                            </tr>
                                        </thead>




                                        <input type="text" value="<?= $results[0]['tm_assign_by'] ?>" id="username_assign" hidden>
                                        <input type="text" value="<?= $results[0]['tm_id'] ?>" id="task_ref" hidden>
                                        <tbody>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- <div class="card-footer">
                                <a href="clients.html">View all clients</a>
                            </div> -->
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
        function mytable(status = null) {

            var task_ref = $('#task_ref').val();

            var username_assign = null;

            var username = null;

            $("#task_table").DataTable({
                "searching": false,
                "processing": true,
                "serverSide": false,
                "iDisplayLength": 10,
                "aLengthMenu": [
                    [10, 20, 50, 1000],
                    [10, 20, 50, "All"]
                ],
                "responsive": true,
                "ordering": false,
                "iDisplayLength": 10,
                "paging": false, // Enable pagination
                "pageLength": 10, // Set number of rows per page
                "rowCallback": function(nRow, aData, iDisplayIndex) {
                    var oSettings = this.fnSettings();
                    $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                    return nRow;
                },
                "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 1, 2, 3]
                    },
                    {
                        "orderable": true,
                        "targets": []
                    }
                ],
                "lengthMenu": [
                    [10, 50, 200, 1000, -1],
                    [10, 50, 200, 1000, "All"]
                ],
                "language": {
                    "emptyTable": "No Data Found",
                },

                "ajax": {
                    url: "../action/tasks.php?do=list_tasks", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        username_assign: username_assign,
                        username: username,
                        status: status,
                        task_ref: task_ref,
                    },
                    error: function() { // error handling
                        $("#task_table").html("");
                        $("#task_table").append('<tbody class=""><tr><th colspan="8" style="text-align: center;">No Tasks Found.</th></tr></tbody>');
                        $("#center_master_table_processing").css("display", "none");
                    }
                },
                bDestroy: true,
            });
        }

        mytable();
    </script>

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
        });

        $(document).on('click', '#final_complete', function() {

            var task_id_complete = $(this).attr('data_value');

            let text = "Are You Sure You Want to Complete This Task";
            if (confirm(text) == true) {
                $('#submit_btn').prop('disabled', true);
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
                        $('#submit_btn').prop('disabled', false);
                    }
                });
            }
        })
    </script>
</body>

</html>