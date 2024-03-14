<?php

function addTwoTimes($time1, $time2)
{
    // it will not add more than 24 hours 
    $time1_seconds = strtotime($time1);
    $time2_seconds = strtotime($time2);

    // Calculate total seconds
    $total_seconds = $time1_seconds + $time2_seconds + (5 * 3600 + 30 * 60);

    return date("H:i:s", $total_seconds);
}
function addTimes($time1, $time2)
{
    // Convert time strings to seconds
    $time1_parts = explode(':', $time1);
    $time2_parts = explode(':', $time2);

    $time1_seconds = $time1_parts[0] * 3600 + $time1_parts[1] * 60 + $time1_parts[2];
    $time2_seconds = $time2_parts[0] * 3600 + $time2_parts[1] * 60 + $time2_parts[2];

    // Add the seconds together
    $total_seconds = $time1_seconds + $time2_seconds;

    // Calculate hours, minutes, and seconds
    $hours = floor($total_seconds / 3600);
    $minutes = floor(($total_seconds % 3600) / 60);
    $seconds = $total_seconds % 60;

    // Format the result
    $result = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);

    return $result;
}
function get_all_user_type_details(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_type WHERE ut_del = '0'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}
function get_all_team_details(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "teams WHERE team_del = '0'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_all_designation_details(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "designation WHERE designation_del = '0'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}
function get_all_country_list(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "countries";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}
function get_all_team_list(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "teams WHERE team_del = '0'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}
function get_all_usertype_list(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_type";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_user_list_by_type(PDO $DB, $user_type, $team_id = null)
{
    if ($team_id == null) {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE ut_id = :ut_id AND um_del = '0'";
    } else {
        $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE ut_id = :ut_id AND um_del = '0' AND team_id = '$team_id'";
    }

    $qryList = $DB->prepare($sqlList);
    $qryList->bindValue(':ut_id', $user_type);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_all_module_list(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "module_master";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_all_state_list(PDO $DB, $pm_country)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "states WHERE country_id = '$pm_country' ORDER BY name ASC";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_all_manager_list(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE ut_id = '2'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}
function get_all_manager_admin_list(PDO $DB)
{
    $sqlList = "SELECT tum.user_unique_id as user_unique_id , CONCAT(tum.first_name,' ',tum.last_name) as name , tt.team_name as team_name FROM tbl_user_master tum LEFT JOIN tbl_teams tt ON tum.team_id = tt.team_id  WHERE tum.ut_id = '2' OR tum.ut_id = '1'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_all_employee_manager_list(PDO $DB)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE um_del = '0' AND (ut_id = '3' OR ut_id = '2')";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_all_team_employee(PDO $DB, $team_id)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE team_id = '$team_id' AND ut_id = '3' AND um_del = '0'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}
function get_all_team_employee_manager(PDO $DB, $team_id)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE team_id = '$team_id' AND (ut_id = '3' OR ut_id = '2') AND um_del = '0' ORDER BY ut_id";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function get_count_present_team_employee_manager(PDO $DB, $team_id, $date)
{
    $sqlList = "SELECT * FROM " . DB_PREFIX . "user_master WHERE team_id = '$team_id' AND (ut_id = '3' OR ut_id = '2') AND um_del = '0' ORDER BY ut_id";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    $team_res =  $qryList->fetchAll();

    $count = 0;
    $countAll = 0;
    foreach ($team_res as $row) {
        $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created ORDER BY created_date  LIMIT 1";

        $statement = $DB->prepare($sql);
        $statement->bindValue(':user_id', $row['user_unique_id']);
        $statement->bindValue(':date_created', $date);

        $statement->execute();

        $res =  $statement->fetchAll();

        ++$countAll;

        if (empty($res)) {
            $count = $count;
        } else {
            if ($res[0]['login_time']) {
                ++$count;
            }
        }
    }

    $data['present'] = $count;
    $data['all'] = $countAll;

    return $data;
}
function get_team_name_by_id(PDO $DB, $team_id)
{
    $sqlList = "SELECT team_name FROM " . DB_PREFIX . "teams WHERE team_id = '$team_id'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function check_task_type(PDO $DB, $task_id)
{

    $sql = "SELECT * FROM tbl_task_master WHERE tm_del = '0' AND tm_id = :tm_id";
    $statement = $DB->prepare($sql);
    $statement->bindValue(":tm_id", $task_id);
    $statement->execute();
    $task_res = $statement->fetchAll();

    return $task_res[0]['tm_category'];
}

function get_designation_name_by_id(PDO $DB, $designation_id)
{
    $sqlList = "SELECT designation_name FROM " . DB_PREFIX . "designation WHERE designation_id = '$designation_id'";
    $qryList = $DB->prepare($sqlList);
    $qryList->execute();
    return $qryList->fetchAll();
}

function check_last_login_with_userid(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM `tbl_login_package_master` WHERE user_unique_id = :user_id ORDER BY `created_date` DESC LIMIT 1";
    $statement = $DB->prepare($sql);
    $statement->bindValue(":user_id", $user_id);
    $statement->execute();
    $res = $statement->fetchAll();

    if ($statement->rowCount() >= 1) {
        if ($res[0]['logout_time'] == '00:00:00') {

            $get_last_login = $res[0]['last_login_time'];
            $get_last_date = date('Y-m-d', strtotime($res[0]['created_date']));

            $full_dateTime = $get_last_date . ' ' . $get_last_login;

            inactive_cur_task_of_user($DB, $user_id, $full_dateTime);

            $sqlquery = "UPDATE tbl_login_package_master SET logout_time = :logout_time WHERE user_unique_id = :user_id ORDER BY `created_date` DESC LIMIT 1";
            $statement = $DB->prepare($sqlquery);
            $statement->bindValue(":user_id", $user_id);
            $statement->bindValue(":logout_time", $get_last_login);
            $statement->execute();
        }
    }
}

// function logout_if_you_login_anywhere(PDO $DB)
// {

// }
// check user is authorized




function check_lunch_by_date(PDO $DB, $date)
{
    $user = $_SESSION['user_id'];


    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created";

    $statement = $DB->prepare($sql);

    $statement->bindValue(':user_id', $user);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    if ($statement->rowCount() > 0) {
        $lunch_count = 0;
        foreach ($results as $row) {
            $lunch_count =  $lunch_count + $row->lunch_time;
        }

        if ($lunch_count == 0) {
            return 0;
        } else {
            return 1;
        }
    } else {
        return "Something went wrong";
    }
}

function check_break_by_date(PDO $DB, $date)
{
    $user = $_SESSION['user_id'];

    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created";

    $statement = $DB->prepare($sql);

    $statement->bindValue(':user_id', $user);
    $statement->bindValue(':date_created', date("Y-m-d"));

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    if ($statement->rowCount() > 0) {
        $break_countt = 0;
        foreach ($results as $row) {
            $break_countt =  $break_countt + $row->break_count;
        }

        return $break_countt;
    } else {
        return "Somthing Went Wrong";
    }
}

function get_break_time_of_current_session(PDO $DB)
{
    $date =  date('y-m-d');
    $user = $_SESSION['user_id'];
    $logout_time = '00:00:00';
    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created AND logout_time = :logout_time";

    $statement = $DB->prepare($sql);

    $statement->bindValue(':user_id', $user);
    $statement->bindValue(':date_created', $date);
    $statement->bindValue(':logout_time', $logout_time);

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    if ($statement->rowCount() > 0) {
        $break_time = '';
        foreach ($results as $row) {
            $break_time = $row->break_time;
        }

        return $break_time;
    } else {
        return "Something went wrong";
    }
}

function get_break_time_acc_date(PDO $DB, $date, $user = null)
{
    if ($user === null) {
        $user = $_SESSION['user_id'];
    }

    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created";

    $statement = $DB->prepare($sql);

    $statement->bindValue(':user_id', $user);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    if ($statement->rowCount() > 0) {
        $break_time = '00:00:00';
        foreach ($results as $row) {
            $break_time =  addTwoTimes($break_time, $row->break_time);
        }
        return $break_time;
    } else {
        return "Absent";
    }
}
function get_all_activity_acc_date(PDO $DB, $date, $user = null)
{
    if ($user === null) {
        $user = $_SESSION['user_id'];
    }

    $sql = "SELECT * FROM tbl_task_activities_log WHERE tal_created_by = :user_id AND DATE(tal_created_date) = :date_created ORDER BY `id` ASC";

    $statement = $DB->prepare($sql);

    $statement->bindValue(':user_id', $user);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $results = $statement->fetchAll();

    return $results;
}
// sanitize Input
function sanitizeInput($data)
{
    $data = trim($data); // Remove extra spaces, tabs, etc.
    $data = stripslashes($data); // Remove backslashes (\)
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    // Additional sanitation/validation steps can be added as needed
    return $data;
}

// check user exist or not 
function check_user_exist(PDO $DB, $username)
{
    $sql = "SELECT * FROM tbl_user_master where user_name = :user_name";

    $statement =  $DB->prepare($sql);
    $statement->bindValue('user_name', $username);

    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_OBJ);

    return $statement->rowCount();
}

function check_img_exist(PDO $DB, $um_image)
{
    $sql = "SELECT * FROM tbl_user_master where um_image = :um_image";

    $statement =  $DB->prepare($sql);
    $statement->bindValue(':um_image', $um_image);

    $statement->execute();

    return $statement->rowCount();
}
// function that checks last_logout
function check_last_logout(PDO $DB, $username)
{
    $sql = "SELECT * FROM `tbl_login_package_master` WHERE user_unique_id = :user_id ORDER BY id DESC LIMIT 1;";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $username);

    $statement->execute();
    return  $statement->fetchAll();
}

// get modules by usertype
function get_modules_access_by_usertype(PDO $DB, $ut_id)
{
    $sql = "SELECT * FROM tbl_user_type  WHERE ut_id = :ut_id";
    $statement = $DB->prepare($sql);
    $statement->bindValue(":ut_id", $ut_id);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
    return json_encode($results);
}


function get_list_of_all_employess(PDO $DB)
{
    $sql = "SELECT * FROM tbl_user_master  WHERE  um_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll();
    return $results;
}

function get_list_of_all_manager_and_team_employee(PDO $DB, $team_id)
{
    $sql = "SELECT * FROM tbl_user_master WHERE  um_del = '0' AND (team_id = :team_id OR ut_id = '2')";
    $statement = $DB->prepare($sql);
    $statement->bindValue(":team_id", $team_id);
    $statement->execute();
    $results = $statement->fetchAll();
    return $results;
}

function get_user_count(PDO $DB)
{
    $sql = "SELECT * FROM tbl_user_master  WHERE um_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->execute();
    return $statement->rowCount();
}

function get_all_task_details(PDO $DB)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
}
function get_all_task_count_of_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :tm_assign_to";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_to', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_task_count_of_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_by = :tm_assign_by";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_by', $user_id);
    $statement->execute();
    return $statement->rowCount();
}

function get_all_pending_task_count_of_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :tm_assign_to AND tm_status != '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_to', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_new_task_count_of_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :tm_assign_to AND tm_status = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_to', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_new_task_count_of_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_by = :tm_assign_by AND tm_status = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_by', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_running_task_count_of_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :tm_assign_to AND tm_status = '1'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_to', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_running_task_count_of_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_by = :tm_assign_by AND tm_status = '1'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_by', $user_id);
    $statement->execute();
    return $statement->rowCount();
}

function get_all_pending_task_count_of_project(PDO $DB, $pm_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND pm_id = :pm_id AND tm_status != '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':pm_id', $pm_id);
    $statement->execute();
    return $statement->rowCount();
}

function get_all_task_count_of_project(PDO $DB, $pm_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND pm_id = :pm_id ";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':pm_id', $pm_id);
    $statement->execute();
    return $statement->rowCount();
}


function get_all_complete_task_count_of_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :tm_assign_to AND tm_status = '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_to', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_complete_task_count_of_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_by = :tm_assign_by AND tm_status = '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_by', $user_id);
    $statement->execute();
    return $statement->rowCount();
}

function get_all_pending_approval_task_count_of_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :tm_assign_to AND tm_status = '2'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_to', $user_id);
    $statement->execute();
    return $statement->rowCount();
}
function get_all_pending_approval_task_count_of_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_by = :tm_assign_by AND tm_status = '2' ";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_assign_by', $user_id);
    $statement->execute();
    return $statement->rowCount();
}


function get_all_task_details_of_login_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master WHERE tm_del = '0' AND tm_assign_to = :user_id ORDER BY tm_created_date DESC";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}

function get_all_task_details_of_projects(PDO $DB, $project_id)
{
    $sql = "SELECT * FROM tbl_task_master WHERE tm_del = '0' AND pm_id = :pm_id";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':pm_id', $project_id);
    $statement->execute();
    return $statement->fetchAll();
}





function get_all_pending_task_details_of_projects(PDO $DB, $project_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND pm_id = :tm_id AND tm_status != '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_id', $project_id);
    $statement->execute();
    return $statement->fetchAll();
}

function get_all_complete_task_details_of_projects(PDO $DB, $project_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND pm_id = :pm_id AND tm_status = '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':pm_id', $project_id);
    $statement->execute();
    return $statement->fetchAll();
}


function get_all_project_details_of_login_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_project_master  WHERE pm_del = '0' AND pm_assign_to = :user_id";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_pending_task_details_of_login_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :user_id AND tm_status != '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_complete_task_details_of_login_user(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master  WHERE tm_del = '0' AND tm_assign_to = :user_id AND tm_status = '3'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_all_task_details_of_login_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_task_master WHERE tm_del = '0' AND tm_assign_by = :user_id  ORDER BY tm_created_date DESC";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_all_project_details_of_login_user_assign(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_project_master  WHERE pm_del = '0' AND pm_assign_by = :user_id";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_all_task_details_by_id(PDO $DB, $task_id)
{
    $sql = "SELECT * FROM tbl_task_master WHERE tm_id = :tm_id AND tm_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_id', $task_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_all_repetitive_task_details_by_id(PDO $DB, $task_id)
{
    $sql = "SELECT * FROM tbl_repetitive_task_master WHERE rtm_id = :rtm_id AND rtm_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':rtm_id', $task_id);
    $statement->execute();
    return $statement->fetchAll();
}

function get_project_id_by_task_id(PDO $DB, $task_id)
{
    $sql = "SELECT * FROM tbl_task_master WHERE tm_id = :tm_id AND tm_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':tm_id', $task_id);
    $statement->execute();
    return $statement->fetchAll();
}
function get_all_project_details_by_id(PDO $DB, $project_id)
{
    $sql = "SELECT * FROM tbl_project_master WHERE pm_id = :pm_id AND pm_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':pm_id', $project_id);
    $statement->execute();
    return $statement->fetchAll();
}

function get_user_details_by_id(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_user_master  WHERE user_unique_id = :user_id AND um_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    return $statement->fetchAll();
}


function check_active_team_member(PDO $DB, $team_id)
{
    $sql = "SELECT * FROM tbl_user_master WHERE team_id = :team_id AND um_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(":team_id", $team_id);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
    return json_encode($results);
}
function check_task_have_relocated_task_or_not(PDO $DB, $task_id)
{
    $sql = "SELECT * FROM tbl_task_master WHERE tm_reference_id = :task_id AND tm_del = '0'";
    $statement = $DB->prepare($sql);
    $statement->bindValue(":task_id", $task_id);
    $statement->execute();
    $results = $statement->rowCount();

    if ($results > 0) {
        return true;
    } else {
        return false;
    }
}
// function calculateWorkingHours($startDateTime, $endDateTime){
//     $start = new DateTime($startDateTime);
//     $end = new DateTime($endDateTime);

//     $start->setTime(9, 0); // Set the start time to 9:00 AM
//     $end->setTime(18, 0); // Set the end time to 6:00 PM

//     // If the start time is after the end of office hours, set it to the next day 9:00 AM
//     if ($start->format('H') >= 18) {
//         $start->modify('+1 day')->setTime(9, 0);
//     }

//     // If the end time is before the start of office hours, set it to the previous day 6:00 PM
//     if ($end->format('H') < 9) {
//         $end->modify('-1 day')->setTime(18, 0);
//     }

//     // Calculate the working hours
//     $interval = $start->diff($end);
//     $workingHours = $interval->h + ($interval->days * 24); // Total hours

//     return $workingHours;
// }
function set_repetitive_task_end_date($task_start_date, $frequency_type, $frequency_range = null, $from_db = null)
{

    if ($from_db == null) {
        $format = "Y-m-d\TH:i:s";
    } else {
        $format = "Y-m-d H:i:s";
    }

    $dateTime = DateTime::createFromFormat($format, $task_start_date);

    $dateOnly = $dateTime->format('Y-m-d');

    $currentDate = (new DateTime())->format('Y-m-d');

    $end_date = '';

    if ($dateOnly <= $currentDate) {

        if ($frequency_type == 1) {
            $dateTime->modify('+0 day');
        } else if ($frequency_type == 2) {
            $dateTime->modify('+6 day');
        } else if ($frequency_type == 3) {
            $dateTime->modify('+29 day');
        } else if ($frequency_type == 4) {
            if (isset($frequency_range)) {
                $dateTime->modify('+' . $frequency_range - 1 . ' days');
            }
        }

        $modifiedDateString = $dateTime->setTime(23, 59, 00)->format($format);
        $end_date = $modifiedDateString;
    }

    return $end_date;
}

function check_first_login_of_day(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created ORDER BY created_date ";
    $date = date('y-m-d');
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $res =  $statement->rowCount();
    if ($res == 1) {
        return true;
    } else {
        return false;
    }
}

function check_login_of_day(PDO $DB, $user_id)
{
    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created ORDER BY created_date ";
    $date = date('y-m-d');
    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    return  $statement->rowCount();
}

function check_already_assigned_or_not(PDO $DB, $rtm_id)
{
    $sql = "SELECT date(tm_end_date) as end_date FROM tbl_task_master WHERE tm_repetitive_id = :rtm_id AND tm_del = '0' ORDER BY tm_created_date DESC LIMIT 1";
    $statement = $DB->prepare($sql);
    $statement->bindValue(':rtm_id', $rtm_id);

    $statement->execute();

    $res =  $statement->fetchAll();

    if (!empty($res)) {
        $end_date = $res[0]['end_date'];

        $date = date('Y-m-d');
        if ($end_date < $date) {
            return true; //means now you have to assign new task 
        } else {
            return false; //already assign 
        }
    } else {
        return true; //means now you have to assign new task 
    }
}

function update_daily_tasks_of_assign_user(PDO $DB, $user_id)
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

            if (check_already_assigned_or_not($DB, $rtm['rtm_unique_id'])) {

                $currentDate = (new DateTime())->format('Y-m-d H:i:s');
                $rtm_end_date =  set_repetitive_task_end_date($currentDate, $rtm['rtm_repetitive_type'], $rtm['rtm_frequency_repeat_days'], 1);

                $format = "Y-m-d H:i:s";

                $dateTime = DateTime::createFromFormat($format, $currentDate);

                $rtm_start_date =  $dateTime->setTime(0, 0, 0)->format($format);

                if ($rtm_end_date != '') {
                    $task_uni_id =  generate_task_id($DB);

                    $sql = "INSERT INTO tbl_task_master(`task_unique_id`,`pm_id`,`tm_repetitive_id`,`tm_reference_id`,`task_title`,`tm_desc`,`tm_image`,`tm_priority`,`tm_assign_by`,`tm_assign_to`,`tm_start_date`,`tm_end_date`,`tm_created_by`) VALUES (:task_unique_id,:pm_id,:tm_repetitive_id,:tm_reference_id,:task_title,:tm_desc,:tm_image,:tm_priority,:tm_assign_by,:tm_assign_to,:tm_start_date,:tm_end_date,:tm_created_by)";

                    $statement = $DB->prepare($sql);

                    $statement->bindValue(":task_unique_id", $task_uni_id);
                    $statement->bindValue(":pm_id", $rtm['pm_id']);
                    $statement->bindValue(":tm_repetitive_id", $rtm['rtm_unique_id']);
                    $statement->bindValue(":tm_reference_id", $rtm['tm_reference_id']);
                    $statement->bindValue(":pm_id", $rtm['pm_id']);
                    $statement->bindValue(":task_title", $rtm['rtm_title']);
                    $statement->bindValue(":tm_desc", $rtm['rtm_desc']);
                    $statement->bindValue(":tm_image",  $rtm['rtm_image']);
                    $statement->bindValue(":tm_priority", $rtm['rtm_priority']);
                    $statement->bindValue(":tm_assign_by", $rtm['rtm_assign_by']);
                    $statement->bindValue(":tm_assign_to", $rtm['rtm_assign_to']);
                    $statement->bindValue(":tm_start_date", $rtm_start_date);
                    $statement->bindValue(":tm_end_date", $rtm_end_date);
                    $statement->bindValue(":tm_created_by", $rtm['rtm_created_by']);

                    $res = $statement->execute();
                }
            }
        }
    }
}

function get_login_time_date_wise(PDO $DB, $date, $user_id)
{
    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created ORDER BY created_date  LIMIT 1";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $res =  $statement->fetchAll();

    if (empty($res)) {
        return  "Absent";
    } else {
        return $res[0]['login_time'];
    }
}

function get_logout_time_date_wise(PDO $DB, $date, $user_id)
{

    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created ORDER BY created_date DESC LIMIT 1";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $res =  $statement->fetchAll();

    if (empty($res)) {
        return  "Absent";
    } else {
        if ($res[0]['logout_time'] == "00:00:00") {
            return "Active";
        } else {
            return $res[0]['logout_time'];
        }
    }
}

function get_active_time_date_wise(PDO $DB, $date, $user_id)
{

    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created ORDER BY created_date DESC LIMIT 1";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $res =  $statement->fetchAll();

    if (empty($res)) {
        return  "Absent";
    } else {
        if ($res[0]['logout_time'] == "00:00:00") {
            if ($res[0]['last_login_time']) {

                $storedTimeString = $res[0]['last_login_time'];

                // Get the current time as a DateTime object
                $currentDateTime = new DateTime();

                // Convert the stored time to a DateTime object
                $storedTime = DateTime::createFromFormat('H:i:s', $storedTimeString);

                // Calculate the time difference
                $timeDifference = $currentDateTime->getTimestamp() - $storedTime->getTimestamp();

                // Convert the time difference to minutes
                $totalMinutes = floor($timeDifference / 60);

                if ($totalMinutes >= 15) {
                    return "Inactive";
                } else {
                    return "Active";
                }
            }
        } else {
            return "Logout";
        }
    }
}

function get_working_time_date_wise(PDO $DB, $date, $user_id)
{

    $sql = "SELECT * FROM tbl_login_package_master WHERE user_unique_id = :user_id AND DATE(created_date) = :date_created";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':date_created', $date);

    $statement->execute();

    $res =  $statement->fetchAll();


    if (empty($res)) {
        return  "Absent";
    } else {

        $total_duration_seconds = "0";

        foreach ($res as $row) {

            if ($row['logout_time'] == '00:00:00') {
                $login_time = $row['login_time'];
                $logout_time = date('H:i:s');


                list($hours1, $minutes1, $seconds1) = explode(':', $login_time);
                $time1InSeconds = $hours1 * 3600 + $minutes1 * 60 + $seconds1;

                list($hours2, $minutes2, $seconds2) = explode(':', $logout_time);
                $time2InSeconds = $hours2 * 3600 + $minutes2 * 60 + $seconds2;

                $differenceInSeconds = abs($time2InSeconds - $time1InSeconds);

                $total_duration_seconds += $differenceInSeconds;
            } else {

                $login_time = $row['login_time'];
                $logout_time = $row['logout_time'];

                list($hours1, $minutes1, $seconds1) = explode(':', $login_time);
                $time1InSeconds = $hours1 * 3600 + $minutes1 * 60 + $seconds1;

                list($hours2, $minutes2, $seconds2) = explode(':', $logout_time);
                $time2InSeconds = $hours2 * 3600 + $minutes2 * 60 + $seconds2;

                $differenceInSeconds = abs($time2InSeconds - $time1InSeconds);
                $total_duration_seconds += $differenceInSeconds;
            }
        }

        $break_time =  get_break_time_acc_date($DB, $date, $user_id);
        list($hours3, $minutes3, $seconds3) = explode(':', $break_time);
        $time3InSeconds = $hours3 * 3600 + $minutes3 * 60 + $seconds3;

        $final_total_seconds = abs($total_duration_seconds - $time3InSeconds);
        // $total_time = date("H:i:s", $total_duration_seconds);
        $hours = floor($final_total_seconds  / 3600);
        $minutes = floor(($final_total_seconds  % 3600) / 60);
        $seconds = $final_total_seconds  % 60;
        // return $total_time;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}

// function inactive_cur_task_of_user(PDO $DB, $user_id, $currentDateTime = null)
// {
//     date_default_timezone_set('UTC');
//     $currentDateTime = $currentDateTime == null ? date('Y-m-d H:i:s') : $currentDateTime;

//     $sqlList = "SELECT * FROM tbl_task_master WHERE tm_assign_to = :user_id AND tm_active = '1'";

//     $statementt = $DB->prepare($sqlList);

//     $statementt->bindValue(':user_id', $user_id);

//     $statementt->execute();

//     $res = $statementt->fetchAll();
//     $activity_type = 2;
//     if (!empty($res)) {
//         $date1 =  strtotime($res[0]['tm_pick_date']);
//         $date2 = strtotime($currentDateTime);

//         $differenceInSeconds = $date2 - $date1 - 1704825000;

//         $time1 = gmdate('H:i:s', $differenceInSeconds);

//         $time2 = $res[0]['tm_total_time'];

//         $total_seconds = strtotime($time1) + strtotime($time2);
//         $final_sec = gmdate('H:i:s', $total_seconds);

//         $sql = "UPDATE tbl_task_master SET tm_active=:tm_active, tm_total_time=:tm_total_time, tm_modify_by=:tm_modify_by,tm_hold_date=:tm_hold_date WHERE tm_assign_to = :user_id AND tm_active = '1'";

//         $statement = $DB->prepare($sql);

//         $statement->bindValue(':tm_active', 0);
//         $statement->bindValue(':tm_modify_by', $_SESSION['user_id']);
//         $statement->bindValue(':user_id', $user_id);
//         $statement->bindValue(':tm_total_time', $final_sec);
//         $statement->bindValue(':tm_hold_date', $currentDateTime);

//         $statement->execute();

//         log_of_task_activity($DB, $res[0]['tm_id'], $res[0]['pm_id'], $activity_type);
//     }
// }

function inactive_cur_task_of_user(PDO $DB, $user_id, $currentDateTime = null)
{

    $currentDateTime = $currentDateTime == null ? date('Y-m-d H:i:s') : $currentDateTime;

    $sqlList = "SELECT * FROM tbl_task_master WHERE tm_assign_to = :user_id AND tm_active = '1'";

    $statementt = $DB->prepare($sqlList);

    $statementt->bindValue(':user_id', $user_id);

    $statementt->execute();

    $res = $statementt->fetchAll();
    $activity_type = 2;


    if (!empty($res)) {
        $date1 = strtotime($res[0]['tm_pick_date']);
        $date2 = strtotime($currentDateTime);

        $differenceInSeconds = $date2 - $date1;

        $hours = floor($differenceInSeconds / 3600);
        $minutes = floor(($differenceInSeconds % 3600) / 60);
        $seconds = $differenceInSeconds % 60;

        $houres = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $minutees = str_pad($minutes, 2, '0', STR_PAD_LEFT);
        $secondes = str_pad($seconds, 2, '0', STR_PAD_LEFT);

        $timeDifference = $houres . ':' . $minutees . ':' . $secondes;

        $final_sec = addTimes($timeDifference, $res[0]['tm_total_time']);

        $sql = "UPDATE tbl_task_master SET tm_active=:tm_active, tm_total_time=:tm_total_time, tm_modify_by=:tm_modify_by,tm_hold_date=:tm_hold_date WHERE tm_assign_to = :user_id AND tm_active = '1'";

        $statement = $DB->prepare($sql);

        $statement->bindValue(':tm_active', 0);
        $statement->bindValue(':tm_modify_by', $_SESSION['user_id']);
        $statement->bindValue(':user_id', $user_id);
        $statement->bindValue(':tm_total_time', $final_sec);
        $statement->bindValue(':tm_hold_date', $currentDateTime);

        $statement->execute();

        log_of_task_activity($DB, $res[0]['tm_id'], $res[0]['pm_id'], $activity_type);
    }
}




function log_of_task_activity(PDO $DB, $task_id, $pm_id, $activity_type, $user_id = null)
{
    if ($user_id == null) {
        $created_by = $_SESSION['user_id'];
    } else {
        $created_by = $user_id;
    }


    $sql = "INSERT INTO tbl_task_activities_log(`tm_id`,`pm_id`,`task_activity_type`,`tal_created_by`) VALUES (:tm_id,:pm_id,:task_activity_type,:tal_created_by)";

    $statement = $DB->prepare($sql);

    $statement->bindValue(":tm_id", $task_id);
    $statement->bindValue(":pm_id", $pm_id);
    $statement->bindValue(":task_activity_type", $activity_type);
    $statement->bindValue(":tal_created_by", $created_by);

    $res = $statement->execute();
}

function get_active_task_of_any_user(PDO $DB, $user_id)
{
    $sqlList = "SELECT * FROM tbl_task_master WHERE tm_assign_to = :user_id AND tm_active = '1' AND tm_del = '0'";

    $statementt = $DB->prepare($sqlList);

    $statementt->bindValue(':user_id', $user_id);

    $statementt->execute();

    return  $statementt->fetchAll();
}
function get_how_many_task_user_active_datewise(PDO $DB, $user_id, $status, $date = null)
{
    $date =   isset($date) ? $date : date('Y-m-d');
    $sqlList = "SELECT * FROM tbl_task_activities_log WHERE tal_created_by = :user_id AND task_activity_type = :tal_status AND date(tal_created_date) = :date_created";

    $statementt = $DB->prepare($sqlList);

    $statementt->bindValue(':user_id', $user_id);
    $statementt->bindValue(':tal_status', $status);
    $statementt->bindValue(':date_created', $date);

    $statementt->execute();

    $data = [];
    $data['data'] = $statementt->fetchAll();
    $data['rowCount'] =  $statementt->rowCount();
    return json_encode($data);
}

function get_task_remarks(PDO $DB, $task_id)
{
    $sqlList = "SELECT * FROM tbl_task_activities WHERE tm_id = :tm_id AND remark_del = '0'";

    $statementt = $DB->prepare($sqlList);

    $statementt->bindValue(':tm_id', $task_id);

    $statementt->execute();

    return  $statementt->fetchAll();
}


function subtractTwoTimes($time1, $time2)
{
    $time1_seconds = strtotime($time1);
    $time2_seconds = strtotime($time2);

    $result_seconds = $time1_seconds - $time2_seconds - (5 * 3600 + 30 * 60);

    return date("H:i:s", $result_seconds);
}

function india_dateTime_format($originalDatetime)
{

    // Create a DateTime object from the original datetime string
    $dateTime = new DateTime($originalDatetime);

    // Format the datetime according to the desired format
    $formattedDatetime = $dateTime->format('d-m-Y H:i:s');

    return $formattedDatetime;
}

function get_last_task_id(PDO $DB)
{
    $sql = "SELECT tm_id FROM tbl_task_master ORDER BY tm_id DESC LIMIT 1";

    $statement = $DB->prepare($sql);
    $statement->execute();
    $task_res = $statement->fetch();

    return $task_res['tm_id'];
}
function get_repetitive_last_task_id(PDO $DB)
{
    $sql = "SELECT rtm_id FROM tbl_repetitive_task_master ORDER BY rtm_id DESC LIMIT 1";

    $statement = $DB->prepare($sql);
    $statement->execute();
    $task_res = $statement->fetch();

    return $task_res['rtm_id'];
}


function generate_task_id(PDO $DB)
{
    $last_id = get_last_task_id($DB);

    return 'TASK_' . $last_id + 1;
}

function generate_repetitive_task_id(PDO $DB)
{
    $last_id = get_repetitive_last_task_id($DB);

    if ($last_id == '' || $last_id == null || !isset($last_id)) {
        return 'RTM_1';
    }

    return 'RTM_' . $last_id + 1;
}
