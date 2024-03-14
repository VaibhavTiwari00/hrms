<?php


include_once '../init.php';
error_reporting(1);

// $date = date('Y-m-d');
// $data_emp =   get_all_team_employee($DB, 1);

// foreach ($data_emp as $row) {

//     echo $row['first_name'] . ' ' .  get_working_time_date_wise($DB, $date, $row['user_unique_id']) . '<br>';
// }

// $originalDatetimeString = "2022-02-20 12:34:56";
// $format = "Y-m-d H:i:s";

// $dateTime = DateTime::createFromFormat($format, $originalDatetimeString);

// if ($dateTime !== false) {
//     // Set the time to '00:00:00'
//     $dateTime->setTime(23, 59, 0);

//     // Get the resulting datetime string
//     $resultDatetimeString = $dateTime->format($format);

//     echo "Original Datetime: $originalDatetimeString\n";
//     echo "Resulting Datetime: $resultDatetimeString\n";
// } else {
//     echo "Invalid datetime format";
// }

// $user_id = '659283d6024e4';
// echo "<br>";
// if (check_first_login_of_day($DB, $user_id)) {
//     echo "true";
// } else {
//     echo 'false';
// }


// // echo $end_date;

// $sql = "SELECT date(tm_end_date) as end_date FROM tbl_task_master WHERE tm_repetitive_id = :rtm_id AND tm_del = '0' ORDER BY tm_created_date DESC LIMIT 1";
// $statement = $DB->prepare($sql);
// $statement->bindValue(':rtm_id', 'RTM_18');

// $statement->execute();

// $res =  $statement->fetchAll();

// if (!empty($res)) {
//     $end_date = $res[0]['end_date'];

//     $date = date('Y-m-d');
//     if ($end_date < $date) {
//         echo "lol"; //means now you have to assign new task 
//     } else {
//         echo "lolfalse"; //already assign 
//     }
// } else {
//     echo "false"; //means now you have to assign new task 
// }

function updatee_daily_tasks_of_assign_user(PDO $DB, $user_id = '6592aaaf19f2a')
{
    $status = 1;

    $sql = "SELECT * FROM tbl_repetitive_task_master WHERE rtm_assign_to = :user_id AND rtm_status = :rtm_status AND rtm_del = '0' AND ((date(rtm_end_date) IS NOT NULL AND CURRENT_DATE BETWEEN date(rtm_start_date) AND date(rtm_end_date)) OR (date(rtm_end_date) = '0000-00-00' AND CURRENT_DATE >= date(rtm_start_date)))";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':rtm_status', $status);

    $statement->execute();

    $res =  $statement->fetchAll();
    if (!empty($res)) {
        foreach ($res as $rtm) {
            print_r($rtm['rtm_unique_id']);
            if (check_already_assigned_or_not($DB, $rtm['rtm_unique_id'])) {

                $currentDate = (new DateTime())->format('Y-m-d H:i:s');
                $rtm_end_date =  set_repetitive_task_end_date(
                    $currentDate,
                    $rtm['rtm_repetitive_type'],
                    $rtm['rtm_frequency_repeat_days'],
                    1
                );

                $format = "Y-m-d H:i:s";

                $dateTime = DateTime::createFromFormat($format, $currentDate);

                $rtm_start_date =  $dateTime->setTime(0, 0, 0)->format($format);

                if ($rtm_end_date != '') {
                    echo 'check';
                } else {
                    echo 'hr';
                }
            }else{
                echo "no task";
            }
        }
    } else {
        echo 'herllo';
    }
}

updatee_daily_tasks_of_assign_user($DB);
