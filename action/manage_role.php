<?php

include_once '../init.php';



if (isset($_REQUEST['do']) && $_REQUEST["do"] == "show_access") {

    $ut_id = sanitizeInput($_POST['ut_id']);
    echo get_modules_access_by_usertype($DB, $ut_id);

    exit();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "get_modules") {

    $sql = "SELECT * FROM " . $DB_Prefix . "module_master";

    $statement = $DB->prepare($sql);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_OBJ);
    
    echo json_encode($results);
    exit();
    
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "manipulate_access") {

    $mm_id = sanitizeInput($_POST['module_id']);
    $user_type_id = sanitizeInput($_POST['user_type_id']);
    $module_table  = get_modules_access_by_usertype($DB, $user_type_id);

    $cur_module_access_arr = explode(",", json_decode($module_table)[0]->mm_id);

    // print_r($cur_module_access_arr);
    $new_array_access = [];
    if (in_array($mm_id, $cur_module_access_arr)) {
        $new_array_access = array_diff($cur_module_access_arr, [$mm_id]);
    } else {
        $new_array_access = $cur_module_access_arr;
        $new_array_access[] = $mm_id;
    }

    $sql = "UPDATE tbl_user_type SET mm_id = :mm_id WHERE ut_id = :userId ";

    $statement = $DB->prepare($sql);
    $statement->bindValue(':mm_id', implode(",", $new_array_access));
    $statement->bindValue(':userId', $user_type_id);
    $res = $statement->execute();
    echo 1;
    exit();
} else {
    echo "Something went wrong";
}

// Function to sanitize input data




die();
