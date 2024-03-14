<?php

include_once('../../init.php');



$id = base64_decode($_GET['id']);

$results = get_all_task_details_by_id($DB, $id);

$project_id = $results[0]['pm_id']
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Tasks Edit </title>

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
        <div class="page-wrapper bg-white">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="page-title">Edit Task</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Task</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">

                    <form class="container" id="editTask">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Task Name<span class="text-danger">*</span></label>
                                    <input class="form-control" name="task_name" type="text" value="<?= $results[0]['task_title'] ?>">
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
                                                if ($project_id == $row['pm_id']) {
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
                                    <select class="select" name="task_priority">
                                        <?php if ($results[0]['tm_priority'] == 1) {
                                            echo '<option value="1" selected>High</option>
                                             <option value="2">Medium</option>
                                        <option value="3">Low</option>';
                                        } else if ($results[0]['tm_priority'] == 2) {
                                            echo '<option value="2" selected>Medium</option>
                                            <option value="1">High</option>
                                            <option value="3">Low</option>';
                                        } else {
                                            echo '<option value="2">Low</option>
                                        <option value="2">Medium</option>
                                        <option value="1" selected>High</option>';
                                        } ?>


                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Task Assign to<span class="text-danger">*</span></label>
                                    <select class="select" name="task_assign_to" id="task_assign_to">

                                        <?php
                                        echo '<option value="">Select User</option>';
                                        ?>

                                        <?php
                                        $user_team_id =   get_user_details_by_id($DB, $_SESSION['user_id']);

                                        if ($_SESSION['user_type'] == 1) {
                                            $all_dept_user_data = get_all_manager_list($DB);
                                        } else {
                                            $all_dept_user_data = get_list_of_all_manager_and_team_employee($DB, $user_team_id[0]['team_id']);
                                        }

                                        foreach ($all_dept_user_data as $row) {
                                            if ($results[0]['tm_assign_to'] == $row['user_unique_id']) {
                                        ?>
                                                <option value="<?= $row['user_unique_id'] ?>" selected><?= $row['first_name'] . ' ' . $row['last_name'] ?></option>

                                            <?php } else {
                                            ?>
                                                <option value="<?= $row['user_unique_id'] ?>"><?= $row['first_name'] . ' ' . $row['last_name'] ?></option>


                                        <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date<span class="text-danger">*</span></label>
                                    <input name="task_start_date" id="start_date" class="form-control" type="datetime-local" value="<?= $results[0]['tm_start_date'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date<span class="text-danger">*</span></label>
                                    <input name="task_end_date" id="end_date" class="form-control" type="datetime-local" value="<?= $results[0]['tm_end_date'] ?>">

                                    <input type="text" name="task_id" value="<?= $results[0]['tm_id'] ?>" hidden>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="3" id="summernote" name="task_desc" class="form-control summernote" placeholder="Enter your message here">
                                 <?= $results[0]['tm_desc'] ?> 
                            </textarea>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title m-b-20">Uploaded files</h5>
                                <ul class="files-list">
                                    <?php $img_arr = json_decode($results[0]['tm_image']);
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


            /* The above code is assigning the value of the "files" property of the "dt" object to the
            "files" property of the current object. */
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


        $(document).ready(function() {
            // Apply Select2 to the select element with additional options
            $('#task_assign_to').select2({
                // Additional options here
            });
        });

        $('#editTask').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

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
            }

            $('#submit_btn').prop('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                url: '../action/tasks.php?do=edit_task',
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
    </script>


    <?php include_once FOOTER; ?>
</body>

</html>