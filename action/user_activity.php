<?php

include_once '../init.php';



if (isset($_REQUEST['do']) && $_REQUEST["do"] == "user_activity") {

    $user_id = sanitizeInput($_POST['user_id']);
    $date = sanitizeInput($_POST['date']);

    $get_results = get_user_details_by_id($DB, $user_id);
    $login_time = convertToAmPmFormat(get_login_time_date_wise($DB, $date, $user_id));
    $logout_time = convertToAmPmFormat(get_logout_time_date_wise($DB, $date, $user_id));
    $total_time = get_working_time_date_wise($DB, $date, $user_id);
    $break_time = get_break_time_acc_date($DB, $date, $user_id);
    $activity_task_uni =  get_distinct_all_activity_acc_date($DB, $date, $user_id);

    $logout_time = $logout_time == 'Invalid date format' ? '--:--' : $logout_time;
    $login_time = $login_time == 'Invalid date format' ? '--:--' : $login_time;

    $user_data = [];

    $user_data['login_time'] = $login_time;
    $user_data['logout_time'] = $logout_time;
    $user_data['break_time'] = convertTimeToHoursMinutes($break_time);
    $user_data['total_time'] = convertTimeToHoursMinutes($total_time);
    $user_data['res_date'] = date('d M Y', strtotime($date));
    $activity_task_arr = [];

    foreach ($activity_task_uni as $activity) {

        $task_details = get_all_task_details_by_id($DB, $activity["tm_id"]);
        $a = [];
        $a['task_title'] = $task_details[0]['task_title'];
        $a['task_id'] = $activity["tm_id"];
        $activity_task_of_uni_task =  get_all_activity_acc_date_or_task($DB, $date, $activity["tm_id"], $user_id);

        $first_active = get_first_activity_acc_date_or_task_or_activity($DB, $date, $activity["tm_id"], 1, $user_id);

        $last_inactive = get_last_activity_acc_date_or_task_or_activity($DB, $date, $activity["tm_id"], 2, $user_id);

        $completed_last_task =  get_last_activity_acc_date_or_task_or_activity($DB, $date, $activity["tm_id"], 3, $user_id);
        // print_r($first_active[0]);
        // echo '<br>';
        // print_r($last_inactive[0]);

        if (isset($first_active) && !empty($first_active)) {
            $dateTime1 = new DateTime($first_active[0]['tal_created_date']);
            $activity_time1 = $dateTime1->format('h:i A');
            $a['first_active'] = $activity_time1;
        } else {
            $a['first_active'] = '--:--';
        }

        if (isset($last_inactive) && !empty($last_inactive)) {

            $dateTime2 = new DateTime($last_inactive[0]['tal_created_date']);
            $activity_time2 = $dateTime2->format('h:i A');
            $a['last_inactive'] = $activity_time2;
        } else {
            $a['last_inactive'] = '--:--';
        }

        if (isset($completed_last_task) && !empty($completed_last_task)) {

            $dateTime3 = new DateTime($completed_last_task[0]['tal_created_date']);
            $activity_time3 = $dateTime3->format('h:i A');
            $a['last_complete'] = $activity_time2;
        } else {
            $a['last_complete'] = '--:--';
        }

        $working_time = get_daily_task_time_acc_date_or_task($DB, $date, $activity["tm_id"], $user_id);
        if ($working_time == '') {
            $a['working_time'] = '--:--';
        } else {
            $a['working_time'] = $working_time;
        }
        $test = [];
        foreach ($activity_task_of_uni_task as $activity_of_particular_task) {

            $b = [];
            if ($activity_of_particular_task['task_activity_type'] == '1') {
                $activity_type = "Active";
            } else if ($activity_of_particular_task['task_activity_type'] == '2') {
                $activity_type = "Inactive";
            } else if ($activity_of_particular_task['task_activity_type'] == '3') {
                $activity_type = "Sent For Approval";
            } else if ($activity_of_particular_task['task_activity_type'] == '4') {
                $activity_type = "Reassigned";
            } else if ($activity_of_particular_task['task_activity_type'] == '5') {
                $activity_type = "Completed";
            } else if ($activity_of_particular_task['task_activity_type'] == '7') {
                $activity_type = "Edited";
            }

            $dateTime = new DateTime($activity_of_particular_task["tal_created_date"]);
            $activity_time = $dateTime->format('h:i A');

            $b['task_activity_type'] = $activity_type;
            $b['activity_time'] = $activity_time;
            array_push($test, $b);
        }

        $a['activity_of_task'] = $test;
        array_push($activity_task_arr, $a);
    }

    $user_data['activity_task'] = $activity_task_arr;

    $data['user_data'] = $user_data;
    $data['status'] = true;
    $data['msg'] = "test ";
    echo json_encode($data);
    die();

    exit();
} else {
    echo "Something went wrong";
}

// Function to sanitize input data




die();
