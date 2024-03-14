<?php
include_once '../../init.php';


error_reporting(1);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Daily Tasks List</title>

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

        .task_nav_item {
            cursor: pointer !important;
        }

        .dropdown-action {
            float: right;
        }

        #daily_task_table tbody tr td:nth-child(10) {
            text-align: center !important;
        }

        @media screen and (max-width:1050px) {

            #daily_task_table thead tr th,
            #daily_task_table tbody tr td {
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
                            <h3 class="page-title">Daily Tasks</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Daily Tasks</li>
                            </ul>
                        </div>
                        <div class="col-auto float-right ml-auto">
                            <?php if ($_SESSION['user_type'] == 2 || $_SESSION['user_type'] == 1) { ?>
                                <a href="<?= home_path() ?>/tasks/add" class="btn add-btn">
                                    <i class="fa fa-plus"></i> Create Task</a>
                            <?php } ?>



                            <div class="view-icons">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped custom-table" id="daily_task_table">
                                <thead>
                                    <tr>
                                        <th style="min-width:50px;">Sr.No.</th>
                                        <th style="max-width:150px;min-width:120px;">Task Name</th>
                                        <th style="max-width:150px;min-width:120px;">Project Name</th>
                                        <th style="min-width:80px;">Task Repetitive Type</th>
                                        <th style="min-width:80px;">Task Repetitive Range</th>
                                        <th style="min-width:90px;">Start Date</th>
                                        <th style="min-width:90px;">Assign To</th>
                                        <th style="min-width:90px;">Deadline</th>
                                        <th style="min-width:90px;">Priority</th>
                                        <th class=" text-right" style="min-width:60px;max-width:60px;">Action</th>
                                    </tr>
                                </thead>

                                <input type="text" value="<?= $_SESSION['user_id'] ?>" id="username" hidden>


                                <tbody>



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
        function remove_active_class() {
            let get_link = document.querySelectorAll('.task_nav_link');

            for (var i = 0; i < get_link.length; i++) {

                get_link[i].classList.remove('active');

            }
        }
        $(document).on('click', '.task_nav_item', function() {
            console.log($(this).attr('data_target'));
            remove_active_class();
            $(this.children[0]).addClass("active");

            mytable($(this).attr('data_target'));
        });


        function mytable(status = null) {


            var username = $('#username').val();
            console.log(username);  
            $("#daily_task_table").DataTable({
                "searching": true,
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
                "paging": true, // Enable pagination
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
                    url: "../action/tasks.php?do=daily_list_tasks", // json datasource
                    type: "post", // method  , by default get
                    data: {
                        username: username,
                        status: status,
                    },
                    error: function() { // error handling
                        $("#daily_task_table").html("");
                        $("#daily_task_table").append('<tbody class=""><tr><th colspan="8" style="text-align: center;">No Tasks Found.</th></tr></tbody>');
                        $("#center_master_table_processing").css("display", "none");
                    }
                },
                bDestroy: true,
            });
        }

        mytable();


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
            var task_type = $(this).attr('data_type');
            $('#task_reassign_id').val(task_reassign_id);
            console.log(task_reassign_id, task_type);
            if (task_type == 1) {
                $('#form_toggle_btn').hide();
            }

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
        })
    </script>


    <?php include_once FOOTER; ?>
</body>

</html>