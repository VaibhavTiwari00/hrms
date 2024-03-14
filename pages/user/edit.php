<?php

include_once('../../init.php');

// authorized_user_only();


$get_id = base64_decode($_GET['id']);
$get_results = get_user_details_by_id($DB, $get_id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Users </title>

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
                    <div class="row align-items-center border-bottom">
                        <div class="col mb-2">
                            <h3 class="page-title">Edit User</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit User</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
                        </div> -->
                    </div>
                </div>
                <!-- /Page Header -->



                <div class=" ">
                    <div id="edit_user" class=" p-0">
                        <div class=" " role="">
                            <div class="">
                                <div class="">
                                    <form method="POST" enctype="multipart/form-data" id="editUser">


                                        <div class=" w-100 row mb-4 p-2 ">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Salutation <span class="text-danger">*</span></label>
                                                    <select class="select select_salutation floating select2-hidden-accessible" required name="salutation">
                                                        <option value="<?= $get_results[0]['salutation'] ?>" selected><?= $get_results[0]['salutation'] ?></option>
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Mrs.">Mrs.</option>
                                                        <option value="Ms.">Ms.</option>
                                                        <option value="Dr.">Dr.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>First Name <span class="text-danger">*</span></label>
                                                    <input class="form-control" required name="firstname" type="text" value="<?= $get_results[0]['first_name'] ?>">
                                                    <input class="form-control" name="user_id" hidden type="text" value="<?= $get_results[0]['user_unique_id'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input class="form-control" name="lastname" type="text" value="<?= $get_results[0]['last_name'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Username <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="username" required type="text" value="<?= $get_results[0]['user_name'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input class="form-control" required name="email" type="email" value="<?= $get_results[0]['email'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Phone Number <span class="text-danger">*</span></label>
                                                    <input class="form-control" required name="mobile_no" type="text" value="<?= $get_results[0]['mobile_no'] ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Select Designation</label>
                                                    <select class="select select_team floating select2-hidden-accessible" name="select_designation" id="select_designation">
                                                        <option value="">Select Designation</option>
                                                        <?php
                                                        $resultsUserType = get_all_designation_details($DB);
                                                        if (count($resultsUserType) > 0) {
                                                            foreach ($resultsUserType as $rowListUserType) {
                                                                if ($rowListUserType['designation_id'] == $get_results[0]['designation_id']) {
                                                        ?>
                                                                    <option value="<?php echo $rowListUserType['designation_id']; ?>" selected><?php echo $rowListUserType['designation_name']; ?></option>

                                                                <?php } else {
                                                                ?>
                                                                    <option value="<?php echo $rowListUserType['designation_id']; ?>"><?php echo $rowListUserType['designation_name']; ?></option>

                                                        <?php }
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Select Team</label>
                                                    <select class="select select_team floating select2-hidden-accessible" name="select_team">

                                                        <?php
                                                        $resultsUserType = get_all_team_details($DB);
                                                        if (count($resultsUserType) > 0) {
                                                            foreach ($resultsUserType as $rowListUserType) {
                                                                if ($rowListUserType['team_id'] == $get_results[0]['team_id']) {
                                                        ?>
                                                                    <option value="<?php echo $rowListUserType['team_id']; ?>" selected><?php echo $rowListUserType['team_name']; ?></option>

                                                                <?php } else {
                                                                ?>
                                                                    <option value="<?php echo $rowListUserType['team_id']; ?>"><?php echo $rowListUserType['team_name']; ?></option>

                                                        <?php }
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Select User Type</label>
                                                    <select name="user_type" class="select floating select2-hidden-accessible">
                                                        <?php
                                                        $resultsUserType = get_all_user_type_details($DB);

                                                        if (count($resultsUserType) > 0) {
                                                            foreach ($resultsUserType as $rowListUserType) {
                                                                if ($rowListUserType['ut_id'] == $get_results[0]['ut_id']) {
                                                        ?>
                                                                    <option value="<?php echo $rowListUserType['ut_id']; ?>" selected><?php echo $rowListUserType['ut_name']; ?></option>

                                                                <?php } else {
                                                                ?>
                                                                    <option value="<?php echo $rowListUserType['ut_id']; ?>"><?php echo $rowListUserType['ut_name']; ?></option>

                                                        <?php }
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Choose file </label>
                                                    <div class="mb-1 ">
                                                        <label class="w-100 d-flex" for="customFile1">

                                                            <img id="selectedImage" src="<?= get_assets() . 'users/' . $get_results[0]['um_image'] ?>" style="width: 60%; height:200px;object-fit:cover; margin:0 auto;" />
                                                        </label>

                                                    </div>
                                                    <div class="d-flex justify-content-center">

                                                        <div class="">
                                                            <input name="file_name" type="file" class="form-control d-none" id="customFile1" onchange="displaySelectedImage(event, 'selectedImage')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="submit-section col-sm-12">
                                                <button type="submit" name="add_user" class="btn btn-primary submit-btn">Submit</button>
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

        <!-- Datatable JS -->
        <script src="<?= get_assets() ?>js/jquery.dataTables.min.js"></script>
        <script src="<?= get_assets() ?>js/dataTables.bootstrap4.min.js"></script>

        <!-- Custom JS -->
        <script src="<?= get_assets() ?>js/app.js"></script>

        <?php include_once FOOTER ?>

        <script>
            function displaySelectedImage(event, elementId) {
                const selectedImage = document.getElementById(elementId);
                const fileInput = event.target;

                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        selectedImage.src = e.target.result;
                    };

                    reader.readAsDataURL(fileInput.files[0]);
                }
            }
        </script>

        <!-- select 2 -->
        <script>
            $(".select_select").select2({
                width: 'resolve' // need to override the changed default
            });
            $(".select_team").select2({
                width: 'resolve' // need to override the changed default
            });
            $(".select_country").select2({
                width: 'resolve',
            });
            $(".select_salutation").select2({
                width: 'resolve' // need to override the changed default
            });
        </script>



        <script>
            $('#editUser').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                if ($('#select_designation').val() == '') {
                    alert('Please Select Designation');
                    return false;
                }

                var formData = new FormData(this); // Serialize form data

                $.ajax({
                    type: 'POST', // Method type
                    url: '../action/actions.php?do=edit_user', // URL where you want to submit the form data
                    data: formData, // Form data
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response)
                        const responseData = JSON.parse(response);
                        if (responseData.status == true) {
                            alert(responseData.msg);
                            window.location.href = "<?= home_path() ?>/user/list";
                        } else {
                            alert(responseData.msg);
                            console.log(responseData.msg);
                        }

                    },
                    error: function(xhr, status, error) {
                        // Handle errors here
                        console.error('Error submitting form: ', error);

                    }
                });
            });
        </script>
        <?php include_once FOOTER; ?>
</body>

</html>