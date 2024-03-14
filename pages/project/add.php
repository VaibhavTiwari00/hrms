<?php

include_once('../../init.php');



error_reporting(1);
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
    <title>Projects Add </title>

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

        .file-delete,
        .file-delete-task {
            display: flex;
            width: 24px;
            color: initial;
            background-color: #6eb4ff00;
            font-size: large;
            justify-content: center;
            margin-right: 3px;
            cursor: pointer;
        }

        .file-delete:hover,
        .file-delete-task:hover {
            background-color: rgba(144, 163, 203, 0.2);
            border-radius: 10px;
        }

        .file-delete>span,
        .file-delete-task>span {
            transform: rotate(45deg);
        }

        .project_department {
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
                            <h3 class="page-title">Add Project</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Project</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto float-right ml-auto">
                                <a href="#" class="btn add-btn" data-toggle="modal" data-target="#edit_project"><i class="fa fa-plus"></i> Save Project</a>

                                <a href="task-board.php" class="btn btn-white float-right m-r-10" data-toggle="tooltip" title="Project Board"><i class="fa fa-bars"></i></a>
                            </div> -->
                    </div>
                </div>
                <!-- /Page Header -->
                <div class="row">

                    <form class="container" id="addProject">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Project Name<span class="text-danger">*</span></label>
                                    <input class="form-control" id="project_name" name="project_name" type="text">
                                </div>
                            </div>

                            
                        </div>

                        <div class="row">
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Priority<span class="text-danger">*</span></label>
                                    <select class="select" name="project_priority" id="project_priority">
                                        <option value="">Select Priority</option>
                                        <option value="1">High</option>
                                        <option value="2">Medium</option>
                                        <option value="3">Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Department<span class="text-danger">*</span></label>
                                    <select class="project_department" multiple="multiple" name="project_department" id="project_department">
                                        <option value="">Select Department</option>
                                        <?php $res =  get_all_team_details($DB);
                                        foreach ($res as $row) {
                                        ?>
                                            <option value="<?= $row['team_id'] ?>"><?= $row['team_name'] ?></option>

                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Start Date<span class="text-danger">*</span></label>
                                    <input name="project_start_date" id="start_date" class="form-control" required type="datetime-local">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>End Date<span class="text-danger">*</span></label>
                                    <input name="project_end_date" id="end_date" class="form-control" required type="datetime-local">
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="3" id="summernote" name="project_desc" class="form-control summernote" placeholder="Enter your message here"></textarea>
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


    <?php include_once '../../includes/modals/projects/add.php'; ?>

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


    <!-- Project JS -->
    <script src="<?= get_assets() ?>js/task.js"></script>

    <!-- Summernote JS -->
    <script src="<?= get_assets() ?>plugins/summernote/dist/summernote-bs4.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>



    <script>
        $(document).ready(function() {
            // Apply Select2 to the select element with additional options
            $('#project_department').select2({
                multiple: true,
                placeholder: 'Select options',
                allowClear: true,
            });
        });
        const dt = new DataTransfer(); // this function is for main project

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

        // this is for task 
        const dtt = new DataTransfer(); // this function is for particular task
        $("#attachment_task").on('change', function(e) {

            for (var i = 0; i < this.files.length; i++) {
                let fileBloc = $('<span/>', {
                        class: 'file-block'
                    }),
                    fileName = $('<span/>', {
                        class: 'name',
                        text: this.files.item(i).name
                    });
                fileBloc.append('<span class="file-delete-task"><span>+</span></span>')
                    .append(fileName);
                $("#filesList > #files-names-task").append(fileBloc);
            };
            // Ajout des fichiers dans l'objet DataTransfer
            for (let file of this.files) {
                dtt.items.add(file);
            }

            this.files = dtt.files;

            // EventListener pour le bouton de suppression créé
            $('span.file-delete-task').click(function() {
                let name = $(this).next('span.name').text();
                // Supprimer l'affichage du nom de fichier
                $(this).parent().remove();
                for (let i = 0; i < dtt.items.length; i++) {
                    if (name === dtt.items[i].getAsFile().name) {
                        dtt.items.remove(i);
                        continue;
                    }
                }
                document.getElementById('attachment_task').files = dtt.files;
            });
        });

        $('#addProject').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);
            var project_dep = $('#project_department').select2('data');
            var project_priority = $('#project_priority').val()

            if ($('#project_name').val() == '') {
                alert('Project Title can not be empty');
                return false;
            } else if (project_dep == '') {
                alert('Project Department can not be empty');
                return false;
            } else if (project_priority == '') {
                alert('Project Priority can not be empty');
                return false;   
            }

            var project_dep_arr = [];

            project_dep.forEach(element => {
                console.log(element.id);
                project_dep_arr.push(element.id);
            });

            formData.append('project_dep', project_dep_arr.toString());

            $('#submit_btn').prop('disabled', true);
            $.ajax({
                url: '../action/project.php?do=add_project',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const responseData = JSON.parse(response);

                    if (responseData.status == true) {
                        alert(responseData.msg);
                        window.location.href = "<?= home_path() ?>/project/list";
                    } else {
                        alert(responseData.msg);
                        $('#submit_btn').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                    alert(xhr.responseText);
                }
            });
        });

        // $('#addTask1').submit(function(event) {
        //     event.preventDefault(); // Prevent the default form submission

        //     var formData = new FormData(this);

        //     if ($('#task_name').val() == '') {
        //         alert('Project Title can not be empty');
        //         return false;
        //     }

        //     $('#sub_task1').prop('disabled', true);

        //     $.ajax({
        //         url: '../action/tasks.php?do=add_task',
        //         method: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log(response);
        //             const responseData = JSON.parse(response);
        //             console.log(responseData);
        //             if (responseData.status == true) {
        //                 alert(responseData.msg);
        //                 window.location.href = "<?= home_path() ?>/tasks/list";
        //             } else {
        //                 alert(responseData.msg);
        //                 $('#sub_task1').prop('disabled', false);
        //                 console.log(responseData.msg);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle errors
        //             console.error(xhr.responseText);
        //         }
        //     });
        // });
    </script>

    <?php include_once FOOTER; ?>
</body>

</html>