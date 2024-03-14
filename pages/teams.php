<?php
include('../init.php');

if (strlen($_SESSION['userlogin']) == 0) {
    header('location:login.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">

    <title>Team</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/font-awesome.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/select2.min.css">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
			<script src="<?= get_assets() ?>js/html5shiv.min.js"></script>
			<script src="<?= get_assets() ?>js/respond.min.js"></script>
		<![endif]-->

    <!-- Head -->
    <?php include_once HEAD; ?>
    <!-- /Head -->
    <style>
        .img-anchor {
            border-radius: 50%;
            width: 38px;
            height: 38px;
            object-fit: cover;
            margin-left: 5px;
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
                            <h3 class="page-title">Teams</h3>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-3 ">
                        <!-- <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#add_team"><i class="fa fa-plus"></i> Add Teams</a> -->
                        <div class="roles-menu">
                            <ul class="role_menu_ul">
                                <?php
                                $results = get_all_team_list($DB);
                                foreach ($results as $row) {
                                ?>
                                    <li class="user_role">
                                        <a href="javascript:void(0);" data-target="<?= $row['team_id'] ?>"><?= $row['team_name'] ?>

                                        </a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-9">
                        <h6 class="card-title m-b-20">Team Members (<span id="team_length">0</span>)</h6>
                        <div class="m-b-30">
                            <ul class="list-group notification-list" id="team_member_ul">
                                <li class="list-group-item">
                                    Rahul
                                    <div class="status-toggle">
                                        <i class="fa fa-trash-o m-r-5"></i>
                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Page Content -->

            <!-- Add Role Modal -->
            <?php include_once("../includes/modals/teams/add.php"); ?>
            <!-- /Add Role Modal -->

            <!-- Edit Role Modal -->
            <?php include_once("../includes/modals/teams/edit.php"); ?>
            <!-- /Edit Role Modal -->

            <!-- Delete Role Modal -->
            <?php include_once("../includes/modals/teams/delete.php"); ?>
            <!-- /Delete Role Modal -->

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

    <!-- Custom JS -->
    <script src="<?= get_assets() ?>js/app.js"></script>



    <script>
        $('#addTeam').submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            let team_name = $('#team_name').val();
            // Serialize form data
            console.log(team_name);
            if ($('#team_name').val() == '') {
                alert('team name must not be empty');
                return false;
            }

            $.ajax({
                type: 'POST', // Method type
                url: 'action/teams.php?do=add_team', // URL where you want to submit the form data
                data: {
                    team_name: team_name,
                }, // Form data
                success: function(response) {
                    // Handle the success response here
                    console.log('Form submitted successfully');
                    window.location.href = "<?= home_path() ?>/teams";
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error submitting form: ', error);

                }
            });
        });
    </script>
    <script>
        $('.role_menu_ul').children().first().addClass('active');

        const user_role = document.querySelectorAll('.user_role');
        const user_role_first = document.querySelector('.user_role');
        const team_member_ul = document.querySelector('#team_member_ul');


        let check_id = user_role_first.children[0].attributes[1].value;
        const myArray = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
        if (myArray.indexOf(check_id) == -1) {
            check_active_team_member(check_id);
        }

        for (let i = 0; i < user_role.length; i++) {

            user_role[i].addEventListener('click', (e) => {

                var team_id = e.target.attributes['1'].value;

                if (myArray.indexOf(team_id) == -1) {
                    // ui part active class add or remove from all element 
                    remove_active_role_class();
                    e.target.parentElement.classList.add('active');
                    check_active_team_member(team_id);
                }
            })
        }


        function remove_active_role_class() {
            const user_role = document.querySelectorAll('.user_role');
            for (let i = 0; i < user_role.length; i++) {
                user_role[i].classList.remove('active');
            }
        }



        function check_active_team_member(team_id) {
            team_member_ul.innerHTML = '';
            $.ajax({
                type: 'POST',
                url: 'action/teams.php?do=show_members',
                data: {
                    team_id: team_id,
                },

                success: function(response) {
                    // console.log(response);
                    if (JSON.parse(response).length == 0) {
                        team_member_ul.innerHTML += `<li class="list-group-item">Not Found  </li>`
                    }
                    $('#team_length').html(JSON.parse(response).length);
                    JSON.parse(response).forEach((ele) => {
                        if (ele) {
                            team_member_ul.innerHTML += `<li class="list-group-item d-flex align-items-center">
                            <img class="img-anchor" src="<?= get_assets() ?>/users/${ele.um_image}" alt="User Picture">
                            <p class="mb-0 ml-2">${ele.first_name}  ${ele.last_name}</p>  
                            </li>`;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error : ', error);

                }
            });
        }

        function get_current_user_role() {
            var elementsWithBothClasses = document.querySelector('.user_role.active');
            return elementsWithBothClasses;
        }
    </script>

    <?php include_once FOOTER; ?>
</body>


</html>