<?php

include_once('../../init.php');

if (isset($_GET['id'])) {

    $pid = base64_decode($_GET['id']);
}
if (isset($_GET['rid'])) {
    $rid = base64_decode($_GET['rid']);
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
        #files-area {
            width: 30%;
        }

        .file-block {
            border-radius: 10px;
            background-color: rgba(144, 163, 203, 0.2);
            margin: 5px;
            color: initial;
            display: inline-flex;
        }

        .file-block>span.name {
            padding-right: 10px;
            width: max-content;
            display: inline-flex;
        }

        .file-delete {
            display: flex;
            width: 24px;
            color: initial;
            background-color: #6eb4ff00;
            font-size: large;
            justify-content: center;
            margin-right: 3px;
            cursor: pointer;
        }

        .file-delete:hover {
            background-color: rgba(144, 163, 203, 0.2);
            border-radius: 10px;
        }

        .file-delete>span {
            transform: rotate(45deg);
        }

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
        <div class="page-wrapper ">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Add Task </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Task</li>
                            </ul>
                        </div>
                        <?php if (isset($rid)) {

                            $task_ref = get_all_task_details_by_id($DB, $rid);
                        ?>
                            <div class="col-auto float-right ml-auto">
                                <p class="text-md mb-1">Reference Task ID: <b>TASK_<?= $rid ?></b></p>

                                <p class="text-md">Reference Task Name: <b><?= $task_ref[0]['task_title'] ?></b></p>

                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Add Task Information</h4>
                            </div>
                            <div class="card-body">

                                <form id="addTask">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Task Name<span class="text-danger">*</span></label>
                                                <input class="form-control" id="task_name" name="task_name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Project<span class="text-danger">*</span></label>
                                                <select class="select" name="task_project" id="task_project">

                                                    <?php
                                                    $result = get_all_project_details_of_login_user_assign($DB, $_SESSION['user_id']);
                                                    if (empty($result)) {
                                                        echo '<option value="">Please Add Project Before adding task</option>';
                                                    } else {
                                                        echo '<option value="">Select Project</option>';
                                                        foreach ($result as $row) {

                                                            if (isset($pid) && $pid == $row['pm_id']) {

                                                    ?>
                                                                <option value="<?= $row['pm_id'] ?>" selected><?= $row['project_title'] ?></option>
                                                            <?php } else {
                                                            ?>
                                                                <option value="<?= $row['pm_id'] ?>"><?= $row['project_title'] ?></option>
                                                    <?php  }
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
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
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Task Assign to<span class="text-danger">*</span></label>

                                                <select class="select" name="task_assign_to" id="task_assign_to">

                                                    <option value="">Select User</option>
                                                    <?php
                                                    $user_team_id =   get_user_details_by_id($DB, $_SESSION['user_id']);
                                                    if ($_SESSION['user_type'] == 1) {
                                                        $all_dept_user_data = get_all_manager_list($DB, $user_team_id[0]['team_id']);
                                                    } else {
                                                        $all_dept_user_data = get_list_of_all_manager_and_team_employee($DB, $user_team_id[0]['team_id']);
                                                    }


                                                    foreach ($all_dept_user_data as $row) {
                                                    ?>
                                                        <option value="<?= $row['user_unique_id'] ?>"><?= $row['first_name'] . ' ' . $row['last_name'] ?></option>

                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Task Type<span class="text-danger">*</span></label>
                                                <select class="select" name="task_type" id="task_type">
                                                    <option value="">Select Type</option>
                                                    <option value="0">Once</option>
                                                    <option value="1">Repetitive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 task_frequency">
                                            <div class="form-group">
                                                <label>Task Repetitive Type<span class="text-danger">*</span></label>
                                                <select class="select" name="task_frequency" id="task_frequency">
                                                    <option value="0">Select Frequency Type</option>
                                                    <option value="1">Daily</option>
                                                    <option value="2">Weekly</option>
                                                    <option value="3">Monthly</option>
                                                    <option value="4">Type Manually</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row task_frequency_date">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Task Repetitive Date Range<span class="text-danger">*</span></label>
                                                <input class="form-control" id="task_frequency_date" name="task_frequency_date" type="number">
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



                                        <input name="task_rid" id="task_rid" class="form-control" type="text" value="<?= isset($rid) ? $rid : '' ?>" hidden>


                                    </div>

                                    <div class="form-group">
                                        <label>Task Description</label>
                                        <textarea rows="3" id="summernote" name="task_desc" class="form-control summernote" placeholder="Enter your message here"></textarea>
                                    </div>

                                    <p class="mt-1">
                                        <label for="attachment">
                                            <a class="btn btn-primary text-light" role="button" aria-disabled="false">+ Add Files</a>
                                        </label>
                                        <input type="file" name="files[]" id="attachment" style="visibility: hidden; position: absolute;" multiple />

                                    </p>
                                    <p id="files-area">
                                        <span id="filesList">
                                            <span id="files-names"></span>
                                        </span>
                                    </p>

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
        const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file
        $("#attachment").on('change', function(e) {

            for (var i = 0; i < this.files.length; i++) {
                let fileBloc = $('<span/>', {
                        class: 'file-block'
                    }),
                    fileName = $('<span/>', {
                        class: 'name',
                        text: this.files.item(i).name
                    });
                fileBloc.append('<span class="file-delete"><span>+</span></span>')
                    .append(fileName);
                $("#filesList > #files-names").append(fileBloc);
            };
            // Ajout des fichiers dans l'objet DataTransfer
            for (let file of this.files) {
                dt.items.add(file);
            }

            this.files = dt.files;

            // EventListener pour le bouton de suppression créé
            $('span.file-delete').click(function() {
                let name = $(this).next('span.name').text();
                // Supprimer l'affichage du nom de fichier
                $(this).parent().remove();
                for (let i = 0; i < dt.items.length; i++) {
                    if (name === dt.items[i].getAsFile().name) {
                        dt.items.remove(i);
                        continue;
                    }
                }
                document.getElementById('attachment').files = dt.files;
            });
        });


        $("#task_type").on('change', function(e) {
            if ($("#task_type").val() == 1) {
                $(".task_frequency").fadeIn(500);
                $('.endDate_star').hide();
            } else {
                $('.endDate_star').show();
                $("#task_frequency").val(0);
                $("#task_frequency_date").val(0);
                $(".task_frequency").hide();
                $(".task_frequency_date").hide();
            }
        });

        $("#task_frequency").on('change', function(e) {
            if ($("#task_frequency").val() == 4) {
                $(".task_frequency_date").fadeIn(500);
            } else {
                $("#task_frequency_date").val(0);
                $(".task_frequency_date").hide();
            }
        });

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
                if ($('#task_type').val() == 1) {

                    if ($('#task_frequency').val() == 0) {
                        alert('Select Task Frequency');
                        return false;
                    } else if ($('#task_frequency').val() == 4) {
                        var frequency_date = $('#task_frequency_date').val();

                        if (Math.sign(frequency_date) != 0 && Math.sign(frequency_date) != -1) {

                        } else {
                            alert('Select Proper Frequency Date');
                            return false;
                        }
                    }
                } else {
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