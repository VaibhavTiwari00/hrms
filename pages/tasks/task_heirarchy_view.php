<?php
include_once '../../init.php';


error_reporting(1);


if (isset($_GET['type']) && $_GET['type'] == 'assign') {
    $get_list_id = $_GET['type'];
}
if (isset($_GET['type']) && $_GET['type'] == 'assign' && isset($_GET['user']) && !empty($_GET['user'])) {
    $user_id = base64_decode($_GET['user']);
} else {
    $user_id = $_SESSION['user_id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Tasks </title>

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

        #task_table tbody tr td:nth-child(10) {
            text-align: center !important;
        }

        @media screen and (max-width:1050px) {

            #task_table thead tr th,
            #task_table tbody tr td {
                text-align: center !important;
            }
        }
    </style>
    <style>
        /*Now the CSS*/
        .tree {
            overflow-x: auto;
            height: max-content;
            height: 800px;
            width: 100%;
        }

        .tree .admin_ul {
            width: 700px;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
        }

        .tree ul {
            padding-top: 20px;
            padding-left: 0;
            position: relative;
            transition: all 0.5s;
            display: flex;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 3px 0 3px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }



        /*We will use ::before and ::after to draw the connectors*/

        .tree li::before,
        .tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 50%;
            height: 20px;
        }



        .tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }

        /*We need to remove left-right connectors from elements without 
any siblings*/
        .tree li:only-child::after,
        .tree li:only-child::before {
            display: none;
        }

        /*Remove space from the top of single children*/
        .tree li:only-child {
            padding-top: 0;
        }

        /*Remove left connector from first child and 
right connector from last child*/
        .tree li:first-child::before,
        .tree li:last-child::after {
            border: 0 none;
        }

        /*Adding back the vertical connector to the last nodes*/
        .tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        /*Time to add downward connectors from parents*/
        .tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }

        .tree li .div {
            border: 1px solid #ccc;
            padding: 4px 8px;
            text-decoration: none;
            color: #666;
            font-size: 12px;
            font-family: arial, verdana, tahoma;
            display: inline-block;
            width: max-content;
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .employee_ul {
            width: 0;
            height: 0;
            opacity: 0;
            transition: all 0.5s;
            position: absolute !important;
            left: 50%;
            transform: translateX(-50%);
        }

        /*Time for some hover effects*/
        /*We will apply the hover effect the the lineage of the element also*/
        .tree li .div:hover,
        .tree li .div:hover+ul li .div {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }


        .tree li .div:hover+.employee_ul {
            width: max-content;
            height: max-content;
            opacity: 1;
        }

        /*Connector styles on hover*/
        .tree li .div:hover+ul li::after,
        .tree li .div:hover+ul li::before,
        .tree li .div:hover+ul::before,
        .tree li .div:hover+ul ul::before {
            border-color: #94a0b4;
        }
    </style>
    <style>
        .list_head {
            background-color: var(--dark-color);
            border-radius: 10px 10px 0 0;
            border-right: 1px solid white;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;

        }




        .list_data {
            text-align: center;
            padding: 4px 0;
            margin: auto 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* border: 1px solid #f1f1f1; */
            border-collapse: collapse;
        }

        .user-imgg {
            display: grid;
            place-items: center;
        }

        .img-anchor {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            object-fit: cover;
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
                            <h3 class="page-title">
                                Tasks Heirarchy View
                            </h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Tasks Heirarchy View</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <!-- /Page Header -->
                <div class="div">
                    <div class="tree">
                        <ul class="admin_ul">
                            <?php $row1 = get_user_list_by_type($DB, 5);
                            foreach ($row1 as $data) { ?>
                                <li>
                                    <div class="div">
                                        <div class="list_data" style="display: block; text-align:left;  ">

                                            <div class="user-imgg">
                                                <img class="img-anchor" src="<?= get_assets() ?>/users/<?= $data['um_image'] ?>" alt="Admin Picture">
                                            </div>
                                            <div class="text-center">
                                                <p style="text-decoration:underline;" class="mb-2 mt-2">
                                                    <?= $data['salutation'] . ' ' . $data['first_name'] . ' ' . $data['last_name'] ?>
                                                </p>

                                                <small class="block text-ellipsis ">
                                                    <button class="btn btn-sm btn-primary" style="font-size:11px;">Task List</button>
                                                </small>
                                            </div>





                                        </div>
                                    </div>
                                    <ul>
                                        <?php $row2 = get_user_list_by_type($DB, 1);
                                        foreach ($row2 as $data2) { ?>
                                            <li>
                                                <div class="div">
                                                    <div class="list_data" style="display: block; text-align:left;  ">

                                                        <div class="user-imgg">
                                                            <img class="img-anchor" src="<?= get_assets() ?>/users/<?= $data2['um_image'] ?>" alt="Admin Picture">
                                                        </div>
                                                        <div class="text-center">
                                                            <p style="text-decoration:underline;" class="mb-2 mt-2">
                                                                <?= $data2['salutation'] . ' ' . $data2['first_name'] . ' ' . $data2['last_name'] ?> </p>

                                                            <small class="block text-ellipsis ">
                                                                <button class="btn btn-sm btn-primary" style="font-size:11px;">Task List</button>
                                                            </small>
                                                        </div>

                                                    </div>
                                                </div>
                                                <ul>
                                                    <?php $rowT = get_all_team_details($DB);
                                                    foreach ($rowT as $dataT) { ?>
                                                        <li>
                                                            <div class="div">
                                                                <div class="list_data" style="display: block; text-align:left;  ">

                                                                    <div class="text-center">
                                                                        <p style="text-decoration:underline;color:#222;font-size:13px;" class="mb-0 ">
                                                                            <?= $dataT['team_name'] ?>
                                                                        </p>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <ul>
                                                                <?php $row3 = get_user_list_by_type($DB, 2, $dataT['team_id']);
                                                                foreach ($row3 as $data3) { ?>
                                                                    <li>
                                                                        <div class="div">
                                                                            <div class="list_data" style="display: block; text-align:left;  ">

                                                                                <div class="user-imgg">
                                                                                    <img class="img-anchor" src="<?= get_assets() ?>/users/<?= $data3['um_image'] ?>" alt="Admin Picture">
                                                                                </div>
                                                                                <div class="text-center">
                                                                                    <p style="text-decoration:underline;" class="mb-2 mt-2">
                                                                                        <?= $data3['salutation'] . ' ' . $data3['first_name'] . ' ' . $data3['last_name'] ?> </p>

                                                                                    <small class="block text-ellipsis ">
                                                                                        <button class="btn btn-sm btn-primary" style="font-size:11px;">Task List</button>
                                                                                    </small>
                                                                                </div>




                                                                            </div>
                                                                        </div>

                                                                        <ul class="employee_ul">
                                                                            <?php $row4 = get_user_list_by_type($DB, 3, $data3['team_id']);
                                                                            foreach ($row4 as $data4) { ?>
                                                                                <li>
                                                                                    <div class="div">
                                                                                        <div class="list_data" style="display: block; text-align:left;  ">

                                                                                            <div class="user-imgg">
                                                                                                <img class="img-anchor" src="<?= get_assets() ?>/users/<?= $data4['um_image'] ?>" alt="Admin Picture">
                                                                                            </div>
                                                                                            <div class="text-center">
                                                                                                <p style="text-decoration:underline;" class="mb-2 mt-2">
                                                                                                    <?= $data4['first_name'] . ' ' . $data4['last_name'] ?> </p>

                                                                                                <small class="block text-ellipsis ">
                                                                                                    <button class="btn btn-sm btn-primary" style="font-size:11px;">Task List</button>
                                                                                                </small>
                                                                                            </div>



                                                                                        </div>
                                                                                    </div>
                                                                                </li>

                                                                            <?php } ?>
                                                                        </ul>
                                                                    </li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                    <?php } ?>
                                                </ul>

                                            </li>

                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
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



    <?php include_once FOOTER; ?>
</body>

</html>