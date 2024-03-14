<?php include_once '../init.php'; 

// Call the function and get the result
$timeLeftInSeconds = secondsUntilNextDay();

$datetime = date('H:i:s', time());
$date = date('Y/m/d');

inactive_cur_task_of_user($DB, $_SESSION['user_id']);



$sql = "SELECT * FROM `tbl_login_package_master` WHERE user_unique_id = :user_id AND created_date = :created_date";

$statement = $DB->prepare($sql);
$statement->bindValue(":user_id", $_SESSION['user_id']);
$statement->bindValue(":created_date", $_SESSION['created_date']);
$statement->execute();
$res = $statement->fetchAll();

if ($res[0]['logout_time'] == '00:00:00') {

    $sql = "UPDATE tbl_login_package_master SET logout_time = :logoutTime WHERE user_unique_id = :userId AND created_date = :cur_date ";

    $statement = $DB->prepare($sql);
    $statement->bindValue(":userId", $_SESSION['user_id']);
    $statement->bindValue(":logoutTime", $datetime);
    $statement->bindValue(":cur_date", $_SESSION['created_date']);

    $res = $statement->execute();
}


session_destroy();
setcookie('hrm_user', '', time() - $timeLeftInSeconds, '/');
header("Location: " . home_path() . "/login");

exit;
?>

<!-- include_once(): Failed opening '/home3/saaoldelhiind545/hrm.saaol.com/includes/modals/login/session.php' for inclusion (include_path='.:/opt/cpanel/ea-php80/root/usr/share/pear') in /home3/saaoldelhiind545/hrm.saaol.com/includes/footer.php on line 3 -->