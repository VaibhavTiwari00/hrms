<?php

include_once '../init.php';

error_reporting(1);



if (isset($_REQUEST['do']) &&  $_REQUEST['do'] == 'break_allot') {

    $break_time =  $_POST['time'];
    $date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $break_value = 1;
    $logout_time = '00:00:00';

    $break_var = check_break_by_date($DB, $date);
    if ($break_var == 0) {
        $sql = "UPDATE tbl_login_package_master SET break_time = :break_time,break_count = :break_value WHERE user_unique_id = :user_id AND logout_time = :logout_time AND DATE(created_date) = :date_created";


        $statement = $DB->prepare($sql);
        $statement->bindValue(':break_time', $break_time);
        $statement->bindValue(":break_value", $break_value);
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":logout_time", $logout_time);
        $statement->bindValue(":date_created", $date);

        $statement->execute();

        $get_active_task =  get_active_task_of_any_user($DB, $_SESSION['user_id']);

        if (isset($get_active_task)) {

            $tm_extra_time =  addTwoTimes($get_active_task[0]['tm_extra_time'], $break_time);

            $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_extra_time = :tm_extra_time WHERE tm_id = :task_id";

            $statement = $DB->prepare($sql);

            $statement->bindValue(":tm_extra_time", $tm_extra_time);
            $statement->bindValue(":task_id", $get_active_task[0]['tm_id']);

            $res = $statement->execute();
        }
        $data['status'] = true;
        $data['msg'] = "Break Added Successfully";
        $data['data'] = $break_time;
        echo json_encode($data);
    } else if ($break_var >= 1) {
        $break_value = $break_var + 1;
        $currnt_break_time =  get_break_time_of_current_session($DB);
        date_default_timezone_set('UTC');
        $time1_seconds = strtotime($currnt_break_time) - strtotime('TODAY');
        $time2_seconds = strtotime($break_time) - strtotime('TODAY');
        $total_seconds = $time1_seconds + $time2_seconds;
        $total_time = date("H:i:s", $total_seconds);


        $sql = "UPDATE tbl_login_package_master SET break_time = :break_time,break_count = :break_value WHERE user_unique_id = :user_id AND logout_time = :logout_time AND DATE(created_date) = :date_created";


        $statement = $DB->prepare($sql);
        $statement->bindValue(':break_time', $total_time);
        $statement->bindValue(":break_value", $break_value);
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":logout_time", $logout_time);
        $statement->bindValue(":date_created", $date);

        $res = $statement->execute();

        $get_active_task =  get_active_task_of_any_user($DB, $_SESSION['user_id']);

        if (isset($get_active_task)) {

            $tm_extra_time =  addTwoTimes($get_active_task[0]['tm_extra_time'], $break_time);

            $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_extra_time = :tm_extra_time WHERE tm_id = :task_id";

            $statement = $DB->prepare($sql);

            $statement->bindValue(":tm_extra_time", $tm_extra_time);
            $statement->bindValue(":task_id", $get_active_task[0]['tm_id']);

            $res = $statement->execute();
        }

        $data['status'] = true;
        $data['msg'] = "Break Added Successfully";
        $data['data'] = $total_time;
        echo json_encode($data);
    } else {
        $data['status'] = false;
        $data['msg'] = "Something Went Wrong";
        $data['data'] = $break_time;
        echo json_encode($data);
    }
} else if (isset($_REQUEST['do']) &&  $_REQUEST['do'] == 'lunch_allot') {

    $id =  $_POST['id'];
    $date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $lunch_value = 1;
    $logout_time = '00:00:00';

    if (check_lunch_by_date($DB, $date) == 0) {
        $sql = "UPDATE tbl_login_package_master SET lunch_time = :lunch_value WHERE user_unique_id = :user_id AND logout_time = :logout_time AND DATE(created_date) = :date_created";


        $statement = $DB->prepare($sql);
        $statement->bindValue(":lunch_value", $lunch_value);
        $statement->bindValue(":user_id", $user_id);
        $statement->bindValue(":logout_time", $logout_time);
        $statement->bindValue(":date_created", $date);

        $res = $statement->execute();

        echo "successfull";
    } else {
        echo "check";
        echo "you have already taken";
    };

    $get_active_task =  get_active_task_of_any_user($DB, $_SESSION['user_id']);

    if (isset($get_active_task)) {

        $tm_extra_time =  addTwoTimes($get_active_task[0]['tm_extra_time'], '00:30:00');

        $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_extra_time = :tm_extra_time WHERE tm_id = :task_id";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":tm_extra_time", $tm_extra_time);
        $statement->bindValue(":task_id", $get_active_task[0]['tm_id']);

        $res = $statement->execute();
    }
} else {
    echo "no request";
}
