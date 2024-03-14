<?php

include_once('../../init.php');

// $_SESSION['saaol_admin_uname'];
if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
} elseif (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE from users where id=:rid";
    $query = $DB->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();
    echo "<script>alert('User deleted Successfully');</script>";
}


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
                            <h3 class="page-title">Add User</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= home_path() ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add User</li>
                            </ul>
                        </div>
                        <!-- <div class="col-auto float-right ml-auto">
                            <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
                        </div> -->
                    </div>
                </div>
                <!-- /Page Header -->



                <div class=" ">
                    <div id="add_user" class=" p-0">
                        <div class=" " role="">
                            <div class="">
                                <div class="">
                                    <form method="POST" enctype="multipart/form-data" id="addUser">


                                        <div class=" w-100 row mb-4 p-2 ">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Salutation <span class="text-danger">*</span></label>
                                                    <select class="select select_salutation floating select2-hidden-accessible" required name="salutation">
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
                                                    <input class="form-control" required name="firstname" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Last Name</label>
                                                    <input class="form-control" name="lastname" type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Username <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="username" required type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input class="form-control" required name="email" type="email">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Phone Number <span class="text-danger">*</span></label>
                                                    <input class="form-control" required name="mobile_no" type="text">
                                                </div>
                                            </div>



                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input class="form-control" name="password" id="password" required type="password">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input class="form-control" name="confirm_pass" id="confirm_password" required type="password">
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
                                                        ?>
                                                                <option value="<?= $rowListUserType['designation_id']; ?>"><?= $rowListUserType['designation_name']; ?></option>

                                                        <?php }
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
                                                        ?>
                                                                <option value="<?= $rowListUserType['team_id']; ?>"><?= $rowListUserType['team_name']; ?></option>

                                                        <?php }
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
                                                        ?>

                                                                <option value="<?php echo $rowListUserType['ut_id']; ?>"><?php echo $rowListUserType['ut_name']; ?></option>

                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>




                                            <!-- <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Select Country</label>
                                                    <select name="select_country" class="select select_country floating select2-hidden-accessible">
                                                        <option value="0">Choose Country</option>
                                                        <?php
                                                        $resultsCountries = get_all_country_list($DB);

                                                        if (count($resultsCountries) > 0) {
                                                            foreach ($resultsCountries as $rowListCountry) {
                                                        ?>
                                                                <option value="<?php echo $rowListCountry['id']; ?>"><?php echo $rowListCountry['name']; ?></option>

                                                        <?php }
                                                        } ?>

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Select State</label>
                                                    <select name="select_state" class="select select_state floating select2-hidden-accessible">
                                                        <option>Select State</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>City <span class="text-danger">*</span></label>
                                                    <input class="form-control" name="city" required type="text">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="address" id="address">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Qualification </label>
                                                    <input type="text" class="form-control" name="qualification" id="qualification">
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Pincode <span class="text-danger">*</span></label>
                                                    <input type="text" required class="form-control" name="pincode" id="pincode">
                                                </div>
                                            </div> -->

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label>Choose file </label>
                                                    <div class="mb-1 ">
                                                        <label class="w-100 d-flex" for="customFile1">
                                                            <img id="selectedImage" src="<?= get_img() ?>/placeholder.jpg" style="width: 60%; height:200px;object-fit:cover; margin:0 auto;" />
                                                        </label>

                                                    </div>
                                                    <div class="d-flex justify-content-center">

                                                        <div class="">
                                                            <input name="file_name" type="file" class="form-control d-none" id="customFile1" onchange="displaySelectedImage(event, 'selectedImage')" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="submit-section">
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
            $('.select_country').on('select2:select', (e) => {
                var check = e.params.data.id;
                var name = e.params.data.text;
                console.log(check, name);

                $.ajax({
                    url: '../action/actions.php?do=fetch_state_by_country',
                    type: 'POST',
                    data: {
                        id: check,
                        name: name,
                    },
                    success: function(responseData) {

                        let state_select_data = [{
                            id: 0,
                            text: "Please Select State",
                        }];

                        $('.select_state').empty();


                        $.each($.parseJSON(responseData), function(index, value) {
                            state_select_data.push({
                                id: value.id,
                                text: value.name,
                            })
                        })

                        $('.select_state').select2({
                            placeholder: 'Select an state',
                            data: state_select_data,
                        });


                    },
                    error: function(xhr, status, error) {

                        console.error('Failed to fetch data:', error);

                    }
                });
            })
        </script>
        <script>
            function handleResponse(response) {
                // Create a script element
                var scriptElement = document.createElement('script');
                scriptElement.innerHTML = response; // Assign the received script to the script element

                // Append the script element to the document's body or head
                document.body.appendChild(scriptElement); // You can also use document.head.appendChild(scriptElement);
            }
        </script>
        <script>
            $('#addUser').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission


                if ($('#select_designation').val() == '') {
                    alert('Please Select Designation');
                    return false;
                }

                var formData = new FormData(this); // Serialize form data
                if ($('#confirm_password').val() != $('#password').val()) {
                    alert('Password does not match');
                    return false;
                } else if ($('#password').val().length < 4) {
                    alert('Password should be at least 4 characters');
                    return false;
                }

                $.ajax({
                    type: 'POST', // Method type
                    url: '../action/actions.php?do=add_user', // URL where you want to submit the form data
                    data: formData, // Form data
                    contentType: false,
                    processData: false,
                    success: function(response) {
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