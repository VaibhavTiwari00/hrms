<?php
// Initialize the session
session_start();

function secondsUntilNextDay()
{
    // Get the current time and date
    $now = time();

    // Calculate the timestamp for the next day
    $nextDayTimestamp = strtotime('tomorrow', $now);

    // Calculate the time difference in seconds
    $timeLeftInSeconds = $nextDayTimestamp - $now;

    // Return the time left in seconds
    return $timeLeftInSeconds;
}


function authorized_user_only(PDO $DB)
{
    if (isset($_SESSION['user_id']) && $_SESSION['loggedin'] && $_SESSION['userlogin'] && isset($_SESSION['time'])) {
        $time = $_SESSION['time'];
        // 120000
        if ($time + 120000 > time()) {
            $_SESSION['time'] = time();
            $sql = "SELECT * FROM `tbl_login_package_master` WHERE user_unique_id = :user_id AND created_date = :created_date";

            $statement = $DB->prepare($sql);
            $statement->bindValue(":user_id", $_SESSION['user_id']);
            $statement->bindValue(":created_date", $_SESSION['created_date']);
            $statement->execute();
            $res = $statement->fetchAll();

            if ($res[0]['logout_time'] !== '00:00:00') {
                // logout the user
                $timeLeftInSeconds = secondsUntilNextDay();
                session_destroy();
                setcookie('hrm_user', '', time() - $timeLeftInSeconds, '/');
                header("Location: " . home_path() . "/login");
            } else {
                return true;
            }
        } else {
            // logout the user
            $timeLeftInSeconds = secondsUntilNextDay();
            session_destroy();
            setcookie('hrm_user', '', time() - $timeLeftInSeconds, '/');
            header("Location: " . home_path() . "/login");
        }
    } else {
        if (isset($_COOKIE['hrm_user'])) {
            $storedJson = json_decode($_COOKIE['hrm_user'], true);

            $user_cookie = base64_decode($storedJson['user']);
            $current_session = $storedJson['current_session'];

            $sql = "SELECT user_name,password,mm_id,user_unique_id,ut_id from tbl_user_master where user_name=:username LIMIT 1";
            $query = $DB->prepare($sql);

            $query->bindParam(':username', $user_cookie, PDO::PARAM_STR);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);

            $_SESSION['userlogin'] = $user_cookie;
            $_SESSION['user_id'] = $results[0]->user_unique_id;
            $_SESSION['user_type'] = $results[0]->ut_id;

            // $module_table  = get_modules_access_by_usertype($DB, $results[0]->ut_id);

            $sqll = "SELECT * FROM tbl_user_type WHERE ut_id = :ut_id";
            $statementt = $DB->prepare($sqll);
            $statementt->bindValue(":ut_id", $results[0]->ut_id);
            $statementt->execute();
            $resultss = $statementt->fetchAll(PDO::FETCH_OBJ);
            $module_table = json_encode($resultss);

            $_SESSION['module_access'] = json_decode($module_table)[0]->mm_id;

            $_SESSION['time'] = time();
            $_SESSION['created_date'] = $current_session;
            $_SESSION["loggedin"] = true;

            $_SESSION['time'] = time();

            $sql = "SELECT * FROM `tbl_login_package_master` WHERE user_unique_id = :user_id AND created_date = :created_date";

            $statement = $DB->prepare($sql);
            $statement->bindValue(":user_id", $_SESSION['user_id']);
            $statement->bindValue(":created_date", $current_session);
            $statement->execute();
            $res = $statement->fetchAll();

            if ($res[0]['logout_time'] !== '00:00:00') {
                $timeLeftInSeconds = secondsUntilNextDay();
                session_destroy();
                setcookie('hrm_user', '', time() - $timeLeftInSeconds, '/');
                header("Location: " . home_path() . "/login");
            } else {
                return true;
            }

        } else {
            header("Location: " . home_path() . "/login");
        }
    }
}
// Check if the user is logged in, if not then redirect him to login page
authorized_user_only($DB);
