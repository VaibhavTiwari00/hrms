<?php

include('../../init.php');

function convertToAmPmFormat($inputDate)
{
    // Create a DateTime object from the input date string
    $dateTime = DateTime::createFromFormat('H:i:s', $inputDate);

    // Check if the conversion was successful
    if ($dateTime !== false) {
        // Format the DateTime object to AM/PM format
        $amPmFormat = $dateTime->format('h:i A');
        return $amPmFormat;
    } else {
        // Return an error message if the conversion fails
        return "Invalid date format";
    }
}
function convertTimeToHoursMinutes($timeString)
{
    // Create a DateTime object from the input time string
    $dateTime = DateTime::createFromFormat('H:i:s', $timeString);

    // Check if the conversion was successful
    if ($dateTime !== false) {
        // Get hours and minutes separately
        $hours = $dateTime->format('H');
        $minutes = $dateTime->format('i');

        // Format the result
        $result = $hours . ':' . $minutes . ' hrs';

        return $result;
    } else {
        // Return an error message if the conversion fails
        return "Invalid time format";
    }
}
$get_user_id = base64_decode($_GET['id']);
$date = date('Y-m-d');
$get_results = get_user_details_by_id($DB, $get_user_id);
$login_time = convertToAmPmFormat(get_login_time_date_wise($DB, $date, $get_user_id));
$logout_time = get_logout_time_date_wise($DB, $date, $get_user_id);
$total_time = get_working_time_date_wise($DB, $date, $get_user_id);
$break_time = get_break_time_acc_date($DB, $date, $get_user_id);
$activity_task =  get_all_activity_acc_date($DB, $date, $get_user_id);

// print_r($activity_task);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>Users Activity</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= get_assets() ?>img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/bootstrap.min.css">

    <!-- Fontawesome CSS -->

    <link rel="stylesheet" href="<?= get_assets() ?>plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= get_assets() ?>plugins/fontawesome/css/all.min.css">

    <!-- Lineawesome CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/line-awesome.min.css">


    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= get_assets() ?>css/style.css">

    <style>
        /* fallback */
        @font-face {
            font-family: 'Material Icons';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/materialicons/v95/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
        }

        /* fallback */
        @font-face {
            font-family: 'Material Icons Outlined';
            font-style: normal;
            font-weight: 400;
            src: url(https://fonts.gstatic.com/s/materialiconsoutlined/v72/gok-H7zzDkdnRel8-DQ6KAXJ69wP1tGnf4ZGhUce.woff2) format('woff2');
        }

        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }

        .material-icons-outlined {
            font-family: 'Material Icons Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }
    </style>
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
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">User Activity</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item">User</li>
                                <li class="breadcrumb-item active">User Activity</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="card-group m-b-30">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <span class="d-block">New Employees</span>
                                        </div>
                                        <div>
                                            <span class="text-success">+10%</span>
                                        </div>
                                    </div>
                                    <h3 class="mb-3">10</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">Overall Employees 218</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <span class="d-block">Earnings</span>
                                        </div>
                                        <div>
                                            <span class="text-success">+12.5%</span>
                                        </div>
                                    </div>
                                    <h3 class="mb-3">$1,42,300</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">Previous Month <span class="text-muted">$1,15,852</span></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <span class="d-block">Expenses</span>
                                        </div>
                                        <div>
                                            <span class="text-danger">-2.8%</span>
                                        </div>
                                    </div>
                                    <h3 class="mb-3">$8,500</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <span class="d-block">Profit</span>
                                        </div>
                                        <div>
                                            <span class="text-danger">-75%</span>
                                        </div>
                                    </div>
                                    <h3 class="mb-3">$1,12,000</h3>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 70%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="row">
                    <div class="col-md-4">
                        <div class="card punch-status">
                            <div class="card-body">
                                <h5 class="card-title">Today Working Report <small class="text-muted">(<?= date('d M Y') ?>)</small></h5>
                                <div class="statistics">
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <div class="punch-det">
                                                <h6>Login In at</h6>
                                                <p><?= $login_time ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 ">
                                            <div class="punch-det">
                                                <h6>Logout at</h6>
                                                <p><?= $logout_time ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span><?= convertTimeToHoursMinutes($total_time) ?> </span>
                                    </div>
                                </div>
                                <div class="punch-btn-section">
                                    <button type="button" class="btn btn-primary punch-btn" style="cursor:text;">Working Time</button>
                                </div>
                                <div class="statistics">
                                    <div class="row">
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>Break</p>
                                                <h6><?= convertTimeToHoursMinutes($break_time) ?></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>Idle Time</p>
                                                <h6>-.- hrs</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card recent-activity">
                            <div class="card-body">
                                <h5 class="card-title">Task Activity</h5>
                                <ul class="res-activity-list">
                                    <?php foreach ($activity_task as $activity) {
                                        if ($activity['task_activity_type'] == '1') {
                                            $activity_type = "Active";
                                        } else if ($activity['task_activity_type'] == '2') {
                                            $activity_type = "Inactive";
                                        } else if ($activity['task_activity_type'] == '3') {
                                            $activity_type = "Sent For Approval";
                                        } else if ($activity['task_activity_type'] == '4') {
                                            $activity_type = "Reassigned";
                                        } else if ($activity['task_activity_type'] == '5') {
                                            $activity_type = "completed";
                                        } else if ($activity['task_activity_type'] == '7') {
                                            $activity_type = "Edited";
                                        }
                                        $task_details = get_all_task_details_by_id($DB, $activity["tm_id"]);
                                    ?>

                                        <li>
                                            <p class="mb-0"><?= $task_details['0']["task_title"] ?> </p>
                                            <p class="res-activity-time">
                                                <i class="fa fa-clock-o"></i>

                                                <?php
                                                $dateTime = new DateTime($activity["tal_created_date"]);
                                                $amPmFormat = $dateTime->format('h:i A');
                                                echo $amPmFormat . ' ' . $activity_type; ?>
                                            </p>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>



                </div>






                <!-- <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Invoices</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-nowrap custom-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Invoice ID</th>
                                                <th>Client</th>
                                                <th>Due Date</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="invoice-view.php">#INV-0001</a></td>
                                                <td>
                                                    <h2><a href="#">Global Technologies</a></h2>
                                                </td>
                                                <td>11 Mar 2019</td>
                                                <td>$380</td>
                                                <td>
                                                    <span class="badge bg-inverse-warning">Partially Paid</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="invoice-view.php">#INV-0002</a></td>
                                                <td>
                                                    <h2><a href="#">Delta Infotech</a></h2>
                                                </td>
                                                <td>8 Feb 2019</td>
                                                <td>$500</td>
                                                <td>
                                                    <span class="badge bg-inverse-success">Paid</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><a href="invoice-view.php">#INV-0003</a></td>
                                                <td>
                                                    <h2><a href="#">Cream Inc</a></h2>
                                                </td>
                                                <td>23 Jan 2019</td>
                                                <td>$60</td>
                                                <td>
                                                    <span class="badge bg-inverse-danger">Unpaid</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="invoices.php">View all invoices</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Payments</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table custom-table table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>Invoice ID</th>
                                                <th>Client</th>
                                                <th>Payment Type</th>
                                                <th>Paid Date</th>
                                                <th>Paid Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><a href="invoice-view.php">#INV-0001</a></td>
                                                <td>
                                                    <h2><a href="#">Global Technologies</a></h2>
                                                </td>
                                                <td>Paypal</td>
                                                <td>11 Mar 2019</td>
                                                <td>$380</td>
                                            </tr>
                                            <tr>
                                                <td><a href="invoice-view.php">#INV-0002</a></td>
                                                <td>
                                                    <h2><a href="#">Delta Infotech</a></h2>
                                                </td>
                                                <td>Paypal</td>
                                                <td>8 Feb 2019</td>
                                                <td>$500</td>
                                            </tr>
                                            <tr>
                                                <td><a href="invoice-view.php">#INV-0003</a></td>
                                                <td>
                                                    <h2><a href="#">Cream Inc</a></h2>
                                                </td>
                                                <td>Paypal</td>
                                                <td>23 Jan 2019</td>
                                                <td>$60</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="payments.php">View all payments</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Clients</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table custom-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#" class="avatar"><img alt="" src="assets/img/profiles/avatar-19.jpg"></a>
                                                        <a href="client-profile.php">Barry Cuda <span>CEO</span></a>
                                                    </h2>
                                                </td>
                                                <td>barrycuda@example.com</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-success"></i> Active
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="#" class="avatar"><img alt="" src="assets/img/profiles/avatar-19.jpg"></a>
                                                        <a href="client-profile.php">Tressa Wexler <span>Manager</span></a>
                                                    </h2>
                                                </td>
                                                <td>tressawexler@example.com</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="client-profile.php" class="avatar"><img alt="" src="assets/img/profiles/avatar-07.jpg"></a>
                                                        <a href="client-profile.php">Ruby Bartlett <span>CEO</span></a>
                                                    </h2>
                                                </td>
                                                <td>rubybartlett@example.com</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="client-profile.php" class="avatar"><img alt="" src="assets/img/profiles/avatar-06.jpg"></a>
                                                        <a href="client-profile.php"> Misty Tison <span>CEO</span></a>
                                                    </h2>
                                                </td>
                                                <td>mistytison@example.com</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-success"></i> Active
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <a href="client-profile.php" class="avatar"><img alt="" src="assets/img/profiles/avatar-14.jpg"></a>
                                                        <a href="client-profile.php"> Daniel Deacon <span>CEO</span></a>
                                                    </h2>
                                                </td>
                                                <td>danieldeacon@example.com</td>
                                                <td>
                                                    <div class="dropdown action-label">
                                                        <a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fa fa-dot-circle-o text-danger"></i> Inactive
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Active</a>
                                                            <a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="clients.php">View all clients</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex">
                        <div class="card card-table flex-fill">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Recent Projects</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table custom-table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Project Name </th>
                                                <th>Progress</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h2><a href="project-view.php">Office Management</a></h2>
                                                    <small class="block text-ellipsis">
                                                        <span>1</span> <span class="text-muted">open tasks, </span>
                                                        <span>9</span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="progress progress-xs progress-striped">
                                                        <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip" style="width: 65%" aria-label="65%" data-bs-original-title="65%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2><a href="project-view.php">Project Management</a></h2>
                                                    <small class="block text-ellipsis">
                                                        <span>2</span> <span class="text-muted">open tasks, </span>
                                                        <span>5</span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="progress progress-xs progress-striped">
                                                        <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip" style="width: 15%" aria-label="15%" data-bs-original-title="15%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2><a href="project-view.php">Video Calling App</a></h2>
                                                    <small class="block text-ellipsis">
                                                        <span>3</span> <span class="text-muted">open tasks, </span>
                                                        <span>3</span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="progress progress-xs progress-striped">
                                                        <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip" style="width: 49%" aria-label="49%" data-bs-original-title="49%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2><a href="project-view.php">Hospital Administration</a></h2>
                                                    <small class="block text-ellipsis">
                                                        <span>12</span> <span class="text-muted">open tasks, </span>
                                                        <span>4</span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="progress progress-xs progress-striped">
                                                        <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip" style="width: 88%" aria-label="88%" data-bs-original-title="88%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h2><a href="project-view.php">Digital Marketplace</a></h2>
                                                    <small class="block text-ellipsis">
                                                        <span>7</span> <span class="text-muted">open tasks, </span>
                                                        <span>14</span> <span class="text-muted">tasks completed</span>
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="progress progress-xs progress-striped">
                                                        <div class="progress-bar" role="progressbar" data-bs-toggle="tooltip" style="width: 100%" aria-label="100%" data-bs-original-title="100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    <div class="dropdown dropdown-action">
                                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                            <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="projects.php">View all projects</a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- /Page Content -->


        </div>
        <!-- /Page Wrapper -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="<?= get_assets() ?>js/jquery-3.2.1.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script> -->
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

    <?php include_once FOOTER; ?>


</body>

</html>