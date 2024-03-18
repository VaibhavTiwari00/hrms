<?php

include('../../init.php');





if (isset($_GET['id'])) {
    $get_user_id = base64_decode($_GET['id']);
    $date = date('Y-m-d');
    $get_results = get_user_details_by_id($DB, $get_user_id);
} else {
    die("Error");
}
// $get_results = get_user_details_by_id($DB, $get_user_id);
// $login_time = convertToAmPmFormat(get_login_time_date_wise($DB, $date, $get_user_id));
// $logout_time = get_logout_time_date_wise($DB, $date, $get_user_id);
// $total_time = get_working_time_date_wise($DB, $date, $get_user_id);
// $break_time = get_break_time_acc_date($DB, $date, $get_user_id);
// $activity_task =  get_all_activity_acc_date($DB, $date, $get_user_id);

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


    <!-- Head -->
    <?php include_once HEAD; ?>
    <!-- /Head -->
    <style>
        .li_child_div {
            height: 0;
            opacity: 0;
            transition: 0.5s;
            padding: 0px;
        }

        .activity_li {
            cursor: pointer;
        }

        .active {
            height: 100%;
            opacity: 1;
            padding: 5px 0px;
        }

        .active_i {
            transform: rotate(180deg);
            transition: 0.5s;
        }

        .active_punch {
            padding: 10px 0px;
        }

        .card_activity {
            height: 398px;
            overflow-y: scroll;
        }

        .res-activity-list {
            height: unset !important;
            overflow-y: unset !important;
        }

        .recent-activity .res-activity-time b {
            color: #222;
            /* font-weight: 500; */
        }

        #res_activity_ul>li>div>div>p:first-child {
            font-size: 14px;
            font-weight: 600;
            color: #007bff;
        }

        .recent-activity .res-activity-time span {
            color: #000;
        }

        #res_activity_ul_2:after {
            border: none;
        }

        .activity_li_2:before {
            left: -20px !important;
            top: 6px !important;
        }

        .activity_li_2 {
            margin-bottom: 9px !important;
        }

        .activity_li_2>p:first-child {
            color: #000;
        }

        .activity_li_2:last-child {
            margin-bottom: 0px !important;
        }

        .punch-det {
            border: none;
        }

        .stats-box {
            border: none;
        }
    </style>
    <style>
        .profile-view .profile-img-wrap {
            height: 70px;
            width: 70px;
        }

        .profile-view .profile-img {
            width: 70px;
            height: 70px;
        }

        .profile-img-wrap img {
            border-radius: 50%;
            height: 70px;
            width: 70px;
            object-fit: cover;
        }

        .profile-view .profile-basic {
            margin-left: 100px;
            padding-right: 50px;
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

                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="page-title">User Activity</h3>

                        </div>
                        <div class="col-sm-6">
                            <!-- <input type="date" value="<?= date('Y-m-d') ?>" id="date" name="date"> -->

                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="profile-view">
                                    <div class="profile-img-wrap">
                                        <div class="profile-img">
                                            <a href="#"><img alt="" src="<?= get_assets() ?>users/<?= $get_results[0]['um_image'] ?>"></a>
                                        </div>
                                    </div>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="profile-info-left">
                                                    <h3 class="user-name m-t-0 mb-0"><?= $get_results[0]['first_name'] . ' ' . $get_results[0]['last_name'] ?></h3>

                                                    <?php $team_res = get_designation_name_by_id($DB, $get_results[0]['designation_id']);

                                                    if ($team_res) { ?>
                                                        <h6 class="text-muted mt-1">
                                                            <?= $team_res[0]['designation_name'] ?>
                                                        </h6>
                                                    <?php }
                                                    ?>

                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group w-50 mb-0">
                                                    <label>Select Date</label>
                                                    <input name="date" id="date" class="form-control" required="" type="date" value="<?= date('Y-m-d') ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card punch-status">
                            <div class="card-body">
                                <h5 class="card-title">Working Report <small class="text-muted date_show_res">(<?= date('d M Y') ?>)</small></h5>
                                <input type="text" value="<?= $get_user_id ?>" id="user_activity_id" hidden>
                                <div class="statistics">
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <div class="punch-det">
                                                <h6>Login In at</h6>
                                                <p id="login_time">--:--</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 ">
                                            <div class="punch-det">
                                                <h6>Logout at</h6>
                                                <p id="logout_time">--:--</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="punch-info">
                                    <div class="punch-hours">
                                        <span id="working_time">--:--</span>
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
                                                <h6 id="break_time">--:--</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 text-center">
                                            <div class="stats-box">
                                                <p>Idle Time</p>
                                                <h6>--:--</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card recent-activity">
                            <div class="card-body card_activity">
                                <h5 class="card-title">Task Activity</h5>
                                <ul class="res-activity-list" id="res_activity_ul">



                                </ul>
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



    <script>
        var activity_ul = document.getElementById('res_activity_ul');
        let activity_li = document.querySelectorAll('.activity_li');

        function check_active_role_ajax(user_id, date) {
            $.ajax({
                type: 'POST',
                url: '../action/user_activity.php?do=user_activity',
                data: {
                    user_id: user_id,
                    date: date,
                },
                success: function(response) {
                    user_data = JSON.parse(response).user_data;
                    console.log(JSON.parse(response).user_data);
                    $('#login_time').html(user_data['login_time']);
                    $('#working_time').html(user_data['total_time']);
                    $('#break_time').html(user_data['break_time']);
                    $('#logout_time').html(user_data['logout_time']);
                    $('.date_show_res').html(user_data['res_date']);
                    // $('#working_time').html(user_data['working_time']);/

                    activity_task = user_data['activity_task'];
                    if (activity_task.length == 0) {
                        activity_ul.innerHTML = '<li>  <p class="mb-0"> No Activity  </p></li>';
                    } else {
                        activity_ul.innerHTML = '';
                    }
                    activity_ul.innerHTML = '';
                    i = 0
                    activity_task.forEach(function(activity) {
                        i++;
                        test = '';
                        // console.log(activity.task_title, activity.activity_time);
                        activity.activity_of_task.forEach(function(subActivity) {
                            test += `<li class="activity_li activity_li_2">
                            <p class="mb-0"> ${subActivity.task_activity_type}</p>
                            <p class="res-activity-time ">
                            <i class="fa fa-clock-o"></i>${subActivity.activity_time} 
                            </p></li>`;
                        });
                        activity_ul.innerHTML += `<li class="activity_li" id="activity_li_${i}">
                                       <div class="d-flex align-items-center justify-content-between">
                                        <div> <p class="mb-0"> ${activity.task_title}</p>
                                        <p class="res-activity-time d-flex align-items-center ">
                                            <b>Active Time: </b> <span class="mx-1"> ${activity.first_active} </span> <b> | Inactive Task: </b> <span class="mx-1">${activity.last_inactive}</span> <b> | Working Time: </b> <span class="mx-1">${activity.working_time} hrs</span>
                                        </p> </div>
                                        <i class="fa fa-chevron-down mr-1" aria-hidden="true" id="activity_li_${i}_i"></i>
                                       </div>
                                        <div class="li_child_div" data_target="activity_li_${i}">
                                           <ul class="res-activity-list punch-det" id="res_activity_ul_2">
                                            ${test} <!-- Placeholder for nested loop content -->
                                           </ul>
                                        </div>
                                    </li>`;


                    })
                    activity_li_test = document.querySelectorAll('.activity_li');
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error : ', error);

                }
            });
        }

        var user_id = $('#user_activity_id').val();
        var date = $('#date').val();
        $('#date').on('change', (e) => {
            // console.log(e.target.value);
            check_active_role_ajax(user_id, e.target.value)

        })

        check_active_role_ajax(user_id, date);



        $('.res-activity-list').on('click', 'li', function(event) {
            // Handle the click event on the li element
            var clickedLi = $(this).attr('id');
            var targetElement = $('[data_target="' + clickedLi + '"]');
            console.log(targetElement);
            var target_i = $('#' + clickedLi + '_i')
            targetElement.toggleClass('active');
            target_i.toggleClass('active_i');

            // targetElement.slideToggle('active');
        });
    </script>
</body>

</html>

<!--  <div class="li_child_div" data_target="activity_li_${i}">
                                            <div class="punch-det active_punch d-flex mb-1  w-80">
                                                 <div class="col-md-4 d-flex align-items-center justify-content-between">
                                                 <h6>Active at</h6>
                                                 <p id="">--:--</p>
                                                 </div>
                                                 <div class="col-md-4 d-flex align-items-center justify-content-between">
                                                 <h6>Inactive at</h6>
                                                 <p id="">--:--</p>
                                                 </div>
                                                  <div class="col-md-4 d-flex align-items-center justify-content-between">
                                                 <h6>Working</h6>
                                                 <p id="">--:--</p>
                                                 </div>
                                            </div>
                                            <div class="punch-det active_punch  d-flex mb-1  w-80">
                                                 <div class="col-md-4 d-flex align-items-center justify-content-between">
                                                 <h6>Active at</h6>
                                                 <p id="">--:--</p>
                                                 </div>
                                                 <div class="col-md-4 d-flex align-items-center justify-content-between">
                                                 <h6>Inactive at</h6>
                                                 <p id="">--:--</p>
                                                 </div>
                                                  <div class="col-md-4 d-flex align-items-center justify-content-between">
                                                 <h6>Working</h6>
                                                 <p id="">--:--</p>
                                                 </div>
                                            </div>
                                        </div> -->