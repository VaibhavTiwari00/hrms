<?php
include_once '../init.php';

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'update_last_login') {

    $date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    $logout_time = '00:00:00';
    $current_time = date("H:i:s");

    $sql = "UPDATE tbl_login_package_master SET last_login_time = :last_login_time WHERE user_unique_id = :user_id AND logout_time = :logout_time AND DATE(created_date) = :date_created";

    $statement = $DB->prepare($sql);

    $statement->bindValue(':last_login_time', $current_time);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':logout_time', $logout_time);
    $statement->bindValue(':date_created', $date);

    $result = $statement->execute();
    if ($result) {
        $data['status'] = true;
        $data['msg'] = "Updated Successfully";
        $data['data'] = "$current_time";
        echo json_encode($data);
    } else {
        $data['status'] = false;
        $data['msg'] = "Something went Wrong";
        $data['data'] = "$current_time";
        echo json_encode($data);
    }




    // $data = get_all_state_list($DB, $id);
    // echo json_encode($id);
}
