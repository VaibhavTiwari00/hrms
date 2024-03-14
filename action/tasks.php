<?php

include_once '../init.php';

error_reporting(1);




if (isset($_REQUEST['do']) && $_REQUEST["do"] == "add_task") {
    // Sanitize and validate input data

    $data = [];
    $created_by = $_SESSION['user_id'];

    $task_name = sanitizeInput($_POST['task_name']);
    $task_priority = sanitizeInput($_POST['task_priority']);
    $task_type = sanitizeInput($_POST['task_type']);
    $task_assign_to = sanitizeInput($_POST['task_assign_to']);
    $task_start_date = sanitizeInput($_POST['task_start_date']) . ":00";
    if (sanitizeInput($_POST['task_end_date']) == '') {
        $task_end_date = sanitizeInput($_POST['task_end_date']);
    } else {
        $task_end_date = sanitizeInput($_POST['task_end_date']) . ":00";
    }

    $task_project_id = sanitizeInput($_POST['task_project']);
    $task_type = sanitizeInput($_POST['task_type']);
    if (isset($_POST['task_rid'])) {
        $task_rid = sanitizeInput($_POST['task_rid']) == '' ? null : sanitizeInput($_POST['task_rid']);
    } else {
        $task_rid = null;
    }
    $task_frequency = sanitizeInput($_POST['task_frequency']);
    $task_frequency_date = sanitizeInput($_POST['task_frequency_date']);
    $task_desc = $_POST['task_desc'];
    $files = $_FILES['files'];

    $format = "Y-m-d\TH:i:s";

    if ($task_end_date != '') {
        if ($task_start_date > $task_end_date) {
            $data['status'] = false;
            $data['msg'] = "End Date must greater than Start Date";
            echo json_encode($data);
            die();
        }
    }


    $uploadedFiles = [];

    if ($task_project_id == '' && is_int($task_project_id) == 1) {
        $data['status'] = false;
        $data['msg'] = "Please choose project";
        echo json_encode($data);
        die();
    } else {
        if ($task_type == 1) {
            if ($task_frequency == 0 || $task_frequency == '') {
                $data['status'] = false;
                $data['msg'] = "Please choose Task Frequency Type";
                echo json_encode($data);
                die();
            } else if ($task_frequency == 4) {
                if ($task_frequency_date == 0) {
                    $data['status'] = false;
                    $data['msg'] = "Please choose Task Frequency Range Properly";
                    echo json_encode($data);
                    die();
                }
            }
        } else if ($task_type == 0) {
        } else {
            $data['status'] = false;
            $data['msg'] = "Please choose Task Type";
            echo json_encode($data);
            die();
        }
    }

    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
        $uploadDirectory = "/assets/test/";
        $allowedExtensions = array("jpg", "jpeg", "png", "txt", "pdf", "xlsx", "doc", "docx", "csv", "xls"); // Allowed file extensions
        $maxFileSize = 5 * 1024 * 1024; // 5 MB (Max file size in bytes)



        foreach ($_FILES['files']['name'] as $key => $fileName) {
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];

            // Validate file name and extension
            $fileInfo = pathinfo($fileName);
            $fileExtension = strtolower($fileInfo['extension']);

            if (isset($fileExtension) && $fileExtension != '') {
                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize <= $maxFileSize) {
                        // Generate a unique name to prevent overwriting files
                        $newFileName = uniqid('', true) . '.' . $fileExtension;
                        $destination = APPPATH . $uploadDirectory . $newFileName;
                        if (move_uploaded_file($fileTmpName, $destination)) {
                            $uploadedFiles[] = $newFileName; // Store uploaded file names
                        } else {
                            // Handle error moving the file to the destination
                            $data['status'] = false;
                            $data['msg'] = "Error moving one or more files to the destination";
                            echo json_encode($data);
                            die();
                        }
                    } else {
                        // Handle file size exceeding the maximum limit
                        $data['status'] = false;
                        $data['msg'] = "One or more files exceed the maximum limit (5MB).";
                        echo json_encode($data);
                        die();
                    }
                } else {
                    $data['status'] = false;
                    $data['msg'] = "This file format not supported only use (jpg, jpeg, png, txt, pdf, xlsx, doc, docx, csv, xls) format";
                    echo json_encode($data);
                    die();
                }
            }
        }
    } else {
        // Handle if no files were submitted
        $uploadedFiles = [];
    }

    $uploadedFiles = json_encode($uploadedFiles);



    if ($task_type == 0) {
        $task_uni_id =  generate_task_id($DB);
        $sql = "INSERT INTO " . $DB_Prefix . "task_master(`task_unique_id`,`pm_id`,`tm_reference_id`,`task_title`,`tm_desc`,`tm_image`,`tm_priority`,`tm_assign_by`,`tm_assign_to`,`tm_start_date`,`tm_end_date`,`tm_created_by`) VALUES (:task_unique_id,:pm_id,:tm_reference_id,:task_title,:tm_desc,:tm_image,:tm_priority,:tm_assign_by,:tm_assign_to,:tm_start_date,:tm_end_date,:tm_created_by)";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":task_unique_id", $task_uni_id);
        $statement->bindValue(":pm_id", $task_project_id);
        $statement->bindValue(":tm_reference_id", $task_rid);
        $statement->bindValue(":task_title", $task_name);
        $statement->bindValue(":tm_desc", $task_desc);
        $statement->bindValue(":tm_image",  $uploadedFiles);
        $statement->bindValue(":tm_priority", $task_priority);
        $statement->bindValue(":tm_assign_by", $created_by);
        $statement->bindValue(":tm_assign_to", $task_assign_to);
        $statement->bindValue(":tm_start_date", $task_start_date);
        $statement->bindValue(":tm_end_date", $task_end_date);
        $statement->bindValue(":tm_created_by", $created_by);

        $res = $statement->execute();

        $data['status'] = true;
        $data['msg'] = "Task Added successfully";
        echo json_encode($data);
        die();
    } else if ($task_type == 1) {

        $currentDate = date('Y-m-d');

        $dateTime = DateTime::createFromFormat($format, $task_start_date);
        if ($dateTime == false) {
            $data['status'] = false;
            $data['msg'] = "Datetime format not supported";
            echo json_encode($data);
            die();
        }

        $dateStart = $dateTime->format('Y-m-d');

        if ($currentDate > $dateStart) {
            $data['status'] = false;
            $data['msg'] = "Start Date Can not be smaller than current date";
            echo json_encode($data);
            die();
        }

        $repetitive_task_uni_id =  generate_repetitive_task_id($DB);

        $sql = "INSERT INTO " . $DB_Prefix . "repetitive_task_master(`rtm_unique_id`,`pm_id`,`tm_reference_id`,`rtm_title`,`rtm_desc`,`rtm_image`,`rtm_priority`,`rtm_repetitive_type`,`rtm_frequency_repeat_days`,`rtm_assign_by`,`rtm_assign_to`,`rtm_start_date`,`rtm_end_date`,`rtm_created_by`) VALUES (:rtm_unique_id,:pm_id,:tm_reference_id,:rtm_title,:rtm_desc,:rtm_image,:rtm_priority,:rtm_repetitive_type,:rtm_frequency_repeat_days,:rtm_assign_by,:rtm_assign_to,:rtm_start_date,:rtm_end_date,:rtm_created_by)";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":rtm_unique_id", $repetitive_task_uni_id);
        $statement->bindValue(":pm_id", $task_project_id);
        $statement->bindValue(":tm_reference_id", $task_rid);
        $statement->bindValue(":rtm_title", $task_name);
        $statement->bindValue(":rtm_desc", $task_desc);
        $statement->bindValue(":rtm_image",  $uploadedFiles);
        $statement->bindValue(":rtm_priority", $task_priority);
        $statement->bindValue(":rtm_repetitive_type", $task_frequency);
        $statement->bindValue(":rtm_frequency_repeat_days", $task_frequency_date);
        $statement->bindValue(":rtm_assign_by", $created_by);
        $statement->bindValue(":rtm_assign_to", $task_assign_to);
        $statement->bindValue(":rtm_start_date", $task_start_date);
        $statement->bindValue(":rtm_end_date", $task_end_date);
        $statement->bindValue(":rtm_created_by", $created_by);

        $res = $statement->execute();

        $rtm_end_date =  set_repetitive_task_end_date($task_start_date, $task_frequency, $task_frequency_date);

        $dateTime = DateTime::createFromFormat($format, $task_start_date);
        $dateTime->setTime(0, 0, 0);
        $rtm_start_date = $dateTime->format($format);

        if ($rtm_end_date != '' && check_login_of_day($DB, $task_assign_to) >= 1) {
            $task_uni_id =  generate_task_id($DB);

            $sql = "INSERT INTO " . $DB_Prefix . "task_master(`task_unique_id`,`pm_id`,`tm_repetitive_id`,`tm_reference_id`,`task_title`,`tm_desc`,`tm_image`,`tm_priority`,`tm_assign_by`,`tm_assign_to`,`tm_start_date`,`tm_end_date`,`tm_created_by`) VALUES (:task_unique_id,:pm_id,:tm_repetitive_id,:tm_reference_id,:task_title,:tm_desc,:tm_image,:tm_priority,:tm_assign_by,:tm_assign_to,:tm_start_date,:tm_end_date,:tm_created_by)";

            $statement = $DB->prepare($sql);

            $statement->bindValue(":task_unique_id", $task_uni_id);
            $statement->bindValue(":pm_id", $task_project_id);
            $statement->bindValue(":tm_repetitive_id", $repetitive_task_uni_id);
            $statement->bindValue(":tm_reference_id", $task_rid);
            $statement->bindValue(":task_title", $task_name);
            $statement->bindValue(":tm_desc", $task_desc);
            $statement->bindValue(":tm_image",  $uploadedFiles);
            $statement->bindValue(":tm_priority", $task_priority);
            $statement->bindValue(":tm_assign_by", $created_by);
            $statement->bindValue(":tm_assign_to", $task_assign_to);
            $statement->bindValue(":tm_start_date", $rtm_start_date);
            $statement->bindValue(":tm_end_date", $rtm_end_date);
            $statement->bindValue(":tm_created_by", $created_by);

            $res = $statement->execute();
        }



        $data['status'] = true;
        $data['msg'] = "Task Added successfully";
        echo json_encode($data);
        die();
    }
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "repetitive_edit_task") {

    $format = "Y-m-d\TH:i:s";
    // Sanitize and validate input data
    $data = [];
    $modify_by = $_SESSION['user_id'];
    $task_name = sanitizeInput($_POST['task_name']);
    $task_priority = sanitizeInput($_POST['task_priority']);
    $task_assign_to = sanitizeInput($_POST['task_assign_to']);
    $task_start_date = sanitizeInput($_POST['task_start_date']) . ":00";

    if (sanitizeInput($_POST['task_end_date']) == '') {
        $task_end_date = sanitizeInput($_POST['task_end_date']);
    } else {
        $task_end_date = sanitizeInput($_POST['task_end_date']) . ":00";
    }

    $task_frequency = sanitizeInput($_POST['task_frequency']);
    $task_frequency_date = sanitizeInput($_POST['task_frequency_date']);

    $task_id = sanitizeInput($_POST['task_id']);
    $task_desc = $_POST['task_desc'];
    $files = $_FILES['files'];
    $task_project_id = sanitizeInput($_POST['task_project']);

    if ($task_project_id == '' && is_int($task_project_id) == 1) {
        $data['status'] = false;
        $data['msg'] = "Please choose project";
        echo json_encode($data);
        die();
    }
    if ($task_project_id == '' && is_int($task_project_id) == 1) {
        $data['status'] = false;
        $data['msg'] = "Please choose project";
        echo json_encode($data);
        die();
    } else {
        if ($task_frequency == 0 || $task_frequency == '') {
            $data['status'] = false;
            $data['msg'] = "Please choose Task Frequency Type";
            echo json_encode($data);
            die();
        } else if ($task_frequency == 4) {
            if ($task_frequency_date == 0) {
                $data['status'] = false;
                $data['msg'] = "Please choose Task Frequency Date Range Properly";
                echo json_encode($data);
                die();
            }
        }
    }

    $uploadedFiles = [];

    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
        $uploadDirectory = "/assets/test/";
        $allowedExtensions = array("jpg", "jpeg", "png", "txt", "pdf", "xlsx", "doc", "docx", "csv", "xls"); // Allowed file extensions
        $maxFileSize = 5 * 1024 * 1024; // 5 MB (Max file size in bytes)



        foreach ($_FILES['files']['name'] as $key => $fileName) {
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];

            // Validate file name and extension
            $fileInfo = pathinfo($fileName);
            $fileExtension = strtolower($fileInfo['extension']);

            if (isset($fileExtension) && $fileExtension != '') {
                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize <= $maxFileSize) {
                        // Generate a unique name to prevent overwriting files
                        $newFileName = uniqid('', true) . '.' . $fileExtension;
                        $destination = APPPATH . $uploadDirectory . $newFileName;
                        if (move_uploaded_file($fileTmpName, $destination)) {
                            $uploadedFiles[] = $newFileName; // Store uploaded file names
                        } else {
                            // Handle error moving the file to the destination
                            $data['status'] = false;
                            $data['msg'] = "Error moving one or more files to the destination";
                            echo json_encode($data);
                            die();
                        }
                    } else {
                        // Handle file size exceeding the maximum limit
                        $data['status'] = false;
                        $data['msg'] = "One or more files exceed the maximum limit (5MB).";
                        echo json_encode($data);
                        die();
                    }
                } else {
                    $data['status'] = false;
                    $data['msg'] = "This file format not supported only use (jpg, jpeg, png, txt, pdf, xlsx, doc, docx, csv, xls) format";
                    echo json_encode($data);
                    die();
                }
            }
        }
    } else {
        // Handle if no files were submitted
        $uploadedFiles = [];
    }


    $results = get_all_repetitive_task_details_by_id($DB, $task_id);

    $img_arr = json_decode($results[0]['rtm_image']);

    // print_r($results[0]);
    // print_r($img_arr);
    // print_r($uploadedFiles);

    // if(empty($uploadedFiles) && empty($img_arr)){
    //      = [];
    // }

    $totaluploadedFiles = json_encode(array_merge($uploadedFiles, $img_arr));

    $currentDate = date('Y-m-d');

    $dateTime = DateTime::createFromFormat($format, $task_start_date);
    if ($dateTime == false) {
        $data['status'] = false;
        $data['msg'] = "Datetime format not supported";
        echo json_encode($data);
        die();
    }

    $dateStart = $dateTime->format('Y-m-d');


    $sql = "UPDATE " . $DB_Prefix . "repetitive_task_master SET rtm_title = :rtm_title, pm_id = :pm_id, rtm_desc = :rtm_desc,rtm_image = :rtm_image,rtm_priority = :rtm_priority,rtm_assign_to = :rtm_assign_to, rtm_repetitive_type= :rtm_repetitive_type, rtm_frequency_repeat_days = :rtm_frequency_repeat_days, rtm_assign_by=:rtm_assign_by, rtm_start_date = :rtm_start_date,rtm_end_date = :rtm_end_date,rtm_modify_by = :rtm_modify_by WHERE rtm_id = :rtm_id";

    $statement = $DB->prepare($sql);

    $statement->bindValue(":rtm_title", $task_name);
    $statement->bindValue(":pm_id", $task_project_id);
    $statement->bindValue(":rtm_desc", $task_desc);
    $statement->bindValue(":rtm_image",  $totaluploadedFiles);
    $statement->bindValue(":rtm_priority", $task_priority);
    $statement->bindValue(":rtm_assign_to", $task_assign_to);
    $statement->bindValue(":rtm_repetitive_type", $task_frequency);
    $statement->bindValue(":rtm_frequency_repeat_days", $task_frequency_date);
    $statement->bindValue(":rtm_assign_by", $modify_by);
    $statement->bindValue(":rtm_start_date", $task_start_date);
    $statement->bindValue(":rtm_end_date", $task_end_date);
    $statement->bindValue(":rtm_modify_by", $modify_by);
    $statement->bindValue(":rtm_id", $task_id);

    $res = $statement->execute();

    $activity_type = 7;
    log_of_task_activity($DB, $task_id, $task_project_id, $activity_type);

    // echo 1;
    $data['status'] = true;
    $data['msg'] = "Task Edited successfully";
    echo json_encode($data);
    die();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "edit_task") {
    // Sanitize and validate input data

    $data = [];
    $modify_by = $_SESSION['user_id'];
    $task_name = sanitizeInput($_POST['task_name']);
    $task_priority = sanitizeInput($_POST['task_priority']);
    $task_assign_to = sanitizeInput($_POST['task_assign_to']);
    $task_start_date = sanitizeInput($_POST['task_start_date']);
    $task_end_date = sanitizeInput($_POST['task_end_date']);
    $task_id = sanitizeInput($_POST['task_id']);
    $task_desc = $_POST['task_desc'];
    $files = $_FILES['files'];
    $task_project_id = sanitizeInput($_POST['task_project']);

    if ($task_project_id == '' && is_int($task_project_id) == 1) {
        $data['status'] = false;
        $data['msg'] = "Please choose project";
        echo json_encode($data);
        die();
    }

    $uploadedFiles = [];

    if (isset($_FILES['files']) && !empty($_FILES['files'])) {
        $uploadDirectory = "/assets/test/";
        $allowedExtensions = array("jpg", "jpeg", "png", "txt", "pdf", "xlsx", "doc", "docx", "csv", "xls"); // Allowed file extensions
        $maxFileSize = 5 * 1024 * 1024; // 5 MB (Max file size in bytes)

        foreach ($_FILES['files']['name'] as $key => $fileName) {
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];

            // Validate file name and extension
            $fileInfo = pathinfo($fileName);
            $fileExtension = strtolower($fileInfo['extension']);

            if (isset($fileExtension) && $fileExtension != '') {
                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize <= $maxFileSize) {
                        // Generate a unique name to prevent overwriting files
                        $newFileName = uniqid('', true) . '.' . $fileExtension;
                        $destination = APPPATH . $uploadDirectory . $newFileName;
                        if (move_uploaded_file($fileTmpName, $destination)) {
                            $uploadedFiles[] = $newFileName; // Store uploaded file names
                        } else {
                            // Handle error moving the file to the destination
                            $data['status'] = false;
                            $data['msg'] = "Error moving one or more files to the destination";
                            echo json_encode($data);
                            die();
                        }
                    } else {
                        // Handle file size exceeding the maximum limit
                        $data['status'] = false;
                        $data['msg'] = "One or more files exceed the maximum limit (5MB).";
                        echo json_encode($data);
                        die();
                    }
                } else {
                    $data['status'] = false;
                    $data['msg'] = "This file format not supported only use (jpg, jpeg, png, txt, pdf, xlsx, doc, docx, csv, xls) format";
                    echo json_encode($data);
                    die();
                }
            }
        }
    } else {
        // Handle if no files were submitted
        $uploadedFiles = [];
    }


    $results = get_all_task_details_by_id($DB, $task_id);

    $img_arr = json_decode($results[0]['tm_image']);

    // print_r($results[0]);
    // print_r($img_arr);
    // print_r($uploadedFiles);

    // if(empty($uploadedFiles) && empty($img_arr)){
    //      = [];
    // }

    $totaluploadedFiles = json_encode(array_merge($uploadedFiles, $img_arr));

    $sql = "UPDATE " . $DB_Prefix . "task_master SET task_title = :task_title, pm_id = :pm_id, tm_desc = :tm_desc,tm_image = :tm_image,tm_priority = :tm_priority,tm_assign_to = :tm_assign_to, tm_assign_by=:tm_assign_by, tm_start_date = :tm_start_date,tm_end_date = :tm_end_date,tm_modify_by = :tm_modify_by WHERE tm_id = :tm_id";


    $statement = $DB->prepare($sql);

    $statement->bindValue(":task_title", $task_name);
    $statement->bindValue(":pm_id", $task_project_id);
    $statement->bindValue(":tm_desc", $task_desc);
    $statement->bindValue(":tm_image",  $totaluploadedFiles);
    $statement->bindValue(":tm_priority", $task_priority);
    $statement->bindValue(":tm_assign_to", $task_assign_to);
    $statement->bindValue(":tm_assign_by", $modify_by);
    $statement->bindValue(":tm_start_date", $task_start_date);
    $statement->bindValue(":tm_end_date", $task_end_date);
    $statement->bindValue(":tm_modify_by", $modify_by);
    $statement->bindValue(":tm_id", $task_id);

    $res = $statement->execute();
    $activity_type = 7;
    log_of_task_activity($DB, $task_id, $task_project_id, $activity_type);

    // echo 1;
    $data['status'] = true;
    $data['msg'] = "Task Edited successfully";

    echo json_encode($data);
    die();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "task_pick") {


    $modify_by = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $get_data = sanitizeInput($_POST['data']);
    $get_data_arr = explode('_', $get_data);


    if ($get_data_arr[0] == 'active') {

        inactive_cur_task_of_user($DB, $_SESSION['user_id']);

        $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_pick_date = :tm_pick_date,tm_status=:tm_status, tm_active=:tm_active, tm_modify_by=:tm_modify_by WHERE tm_id = :task_id";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":tm_pick_date", $date);
        $statement->bindValue(":tm_modify_by", $modify_by);
        $statement->bindValue(":tm_active", 1);
        $statement->bindValue(":tm_status", 1);
        $statement->bindValue(":task_id", $get_data_arr[1]);

        $res = $statement->execute();

        $data['status'] = true;
        $data['msg'] = "Task Active successfully";
        $data['data'] = $get_data_arr;

        $activity_type = 1;
        $project_id = get_project_id_by_task_id($DB, $get_data_arr[1]);
        log_of_task_activity($DB, $get_data_arr[1], $project_id[0]['pm_id'], $activity_type);

        echo json_encode($data);
    } else if ($get_data_arr[0] == 'inactive') {


        $check =   inactive_cur_task_of_user($DB, $_SESSION['user_id']);

        $data['status'] = true;
        $data['msg'] = "Task Inactive successfully";
        echo json_encode($data);
    } else if ($get_data_arr[0] == 'delete') {

        $get_active_task =  get_active_task_of_any_user($DB, $_SESSION['user_id']);

        if (isset($get_active_task)) {
            if ($get_active_task[0]['tm_id'] == $get_data_arr[1]) {
                inactive_cur_task_of_user($DB, $_SESSION['user_id']);
            }
        }

        $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_del=:tm_del, tm_modify_by=:tm_modify_by WHERE tm_id = :task_id";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":tm_modify_by", $modify_by);
        $statement->bindValue(":tm_del", 1);
        $statement->bindValue(":task_id", $get_data_arr[1]);

        $res = $statement->execute();

        $data['status'] = true;
        $data['msg'] = "Task Deleted Successfully";
        echo json_encode($data);
    } else if ($get_data_arr[0] == 'complete') {

        $get_active_task =  get_active_task_of_any_user($DB, $_SESSION['user_id']);

        if (isset($get_active_task)) {
            if ($get_active_task[0]['tm_id'] == $get_data_arr[1]) {
                inactive_cur_task_of_user($DB, $_SESSION['user_id']);
            }
        }

        $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_status=:tm_status, tm_modify_by=:tm_modify_by WHERE tm_id = :task_id";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":tm_modify_by", $modify_by);
        $statement->bindValue(":tm_status", 3);
        $statement->bindValue(":task_id", $get_data_arr[1]);

        $res = $statement->execute();
        $activity_type = 5;
        $project_id = get_project_id_by_task_id($DB, $get_data_arr[1]);
        log_of_task_activity($DB, $get_data_arr[1], $project_id[0]['pm_id'], $activity_type);

        $data['status'] = true;
        $data['msg'] = "Task Completed Successfully";
        echo json_encode($data);
    }
    die();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "follow_up") {

    $modify_by = $_SESSION['user_id'];
    $task_id = sanitizeInput($_POST['task_id']);
    $task_text = sanitizeInput($_POST['task_reason']);
    $get_active_task =  get_active_task_of_any_user($DB, $modify_by);
    $currentDateTime = date('Y-m-d H:i:s');

    if ($task_id == '' && $task_text == '') {

        $data['status'] = false;
        $data['msg'] = "Something went wrong";
        echo json_encode($data);
        die();
    }

    if (isset($get_active_task)) {
        if ($get_active_task[0]['tm_id'] == $task_id) {
            inactive_cur_task_of_user($DB, $modify_by);
        }
    }

    $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_status=:tm_status, tm_modify_by=:tm_modify_by, tm_hold_date=:tm_hold_date WHERE tm_id = :task_id";

    $statement = $DB->prepare($sql);

    $statement->bindValue(":tm_modify_by", $modify_by);
    $statement->bindValue(":tm_status", 2);
    $statement->bindValue(":task_id", $task_id);
    $statement->bindValue(":tm_hold_date", $currentDateTime);

    $res = $statement->execute();



    $sqlL = "INSERT INTO " . $DB_Prefix . "task_activities(`tm_id`,`remarks`,`created_by`) VALUES (:tm_id,:remarks,:created_by)";

    $statemenT = $DB->prepare($sqlL);

    $statemenT->bindValue(":created_by", $modify_by);
    $statemenT->bindValue(":tm_id", $task_id);
    $statemenT->bindValue(":remarks", $task_text);

    $res = $statemenT->execute();

    $activity_type = 3;
    $project_id = get_project_id_by_task_id($DB, $task_id);
    log_of_task_activity($DB, $task_id, $project_id[0]['pm_id'], $activity_type);

    $data['status'] = true;
    $data['msg'] = "Task Sent For Approval";
    echo json_encode($data);


    die();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "reassign_task") {



    $modify_by = $_SESSION['user_id'];
    $task_id = sanitizeInput($_POST['task_reassign_id']);
    $task_text = sanitizeInput($_POST['task_reassign_reason']);

    if ($task_id == '' && $task_text == '') {

        $data['status'] = false;
        $data['msg'] = "Something went wrong";
        echo json_encode($data);
        die();
    }
    $currentDateTime = date('Y-m-d H:i:s');


    $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_status=:tm_status, tm_modify_by=:tm_modify_by WHERE tm_id = :task_id";

    $statement = $DB->prepare($sql);

    $statement->bindValue(":tm_modify_by", $modify_by);
    $statement->bindValue(":tm_status", 0);
    $statement->bindValue(":task_id", $task_id);

    $res = $statement->execute();



    $sqlL = "INSERT INTO " . $DB_Prefix . "task_activities(`tm_id`,`remarks`,`created_by`) VALUES (:tm_id,:remarks,:created_by)";

    $statemenT = $DB->prepare($sqlL);

    $statemenT->bindValue(":created_by", $modify_by);
    $statemenT->bindValue(":tm_id", $task_id);
    $statemenT->bindValue(":remarks", $task_text);

    $res = $statemenT->execute();

    $activity_type = 4;
    $project_id = get_project_id_by_task_id($DB, $task_id);
    log_of_task_activity($DB, $task_id, $project_id[0]['pm_id'], $activity_type);

    $data['status'] = true;
    $data['msg'] = "Task Reassign Successfully";
    echo json_encode($data);



    die();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "complete_task") {

    $modify_by = $_SESSION['user_id'];
    $task_id = sanitizeInput($_POST['data']);

    if ($task_id == '') {
        $data['status'] = false;
        $data['msg'] = "Something went wrong";
        echo json_encode($data);
        die();
    }

    $currentDateTime = date('Y-m-d H:i:s');

    $task_type = check_task_type($DB, $task_id);

    $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_status=:tm_status, tm_modify_by=:tm_modify_by WHERE tm_id = :task_id";

    $statement = $DB->prepare($sql);

    $statement->bindValue(":tm_modify_by", $modify_by);
    $statement->bindValue(":tm_status", 3);
    $statement->bindValue(":task_id", $task_id);

    $res = $statement->execute();
    $activity_type = 5;
    $project_id = get_project_id_by_task_id($DB, $task_id);
    log_of_task_activity($DB, $task_id, $project_id[0]['pm_id'], $activity_type);

    $data['status'] = true;
    $data['msg'] = "Task Completed Successfully";
    echo json_encode($data);
    die();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "list_tasks") {

    $requestData = $_REQUEST;

    if (isset($_POST['status']) && !empty($_POST['status']) || $_POST['status'] == 0) {
        $status = $_POST['status'];

        $from_new_query = "FROM `" . DB_PREFIX . "task_master` WHERE tm_del = '0' AND tm_status = '$status'";

        // $from_new_query = "FROM `" . DB_PREFIX . "hospital_master` WHERE hm_del = '0' AND ht_id = '$select_center_type'";
    } else {
        $from_new_query = "FROM `" . DB_PREFIX . "task_master` WHERE tm_del = '0'";
    }


    $sqlListType = "SELECT count(*) as cnt $from_new_query";
    $qryListType = $DB->prepare($sqlListType);
    $qryListType->execute();
    $ResultsList = $qryListType->fetch();
    $totalData = $ResultsList['cnt'];
    $totalFiltered = $totalData;

    $sql = "SELECT * $from_new_query";
    $array = array();


    if (!empty($requestData['search']['value'])) {
        $sql .= " AND (tm_title LIKE '%" . $requestData['search']['value'] . "%')";
    }

    if (!empty($_POST['username']) && !empty($_POST['username'])) {

        $username = $_POST['username'];
        $sql .= " AND tm_assign_to = '$username'";
    } else if (!empty($_POST['username_assign']) && !empty($_POST['username_assign'])) {

        $username_assign = $_POST['username_assign'];
        $sql .= " AND tm_assign_by = '$username_assign' AND tm_assign_to != '$username_assign'";
    }

    if (!empty($_POST['task_ref']) && isset($_POST['task_ref'])) {

        $ref_id = $_POST['task_ref'];
        $sql .= " AND tm_reference_id = '$ref_id'";
    }

    $sql .= " ORDER BY CASE 
        WHEN tm_modify_date IS NOT NULL THEN tm_modify_date
        ELSE tm_created_date
    END DESC";

    $qry = $DB->prepare($sql);
    $qry->execute();
    $totalFiltered = $qry->rowCount();

    $qry = $DB->prepare($sql);
    $qry->execute();
    $ResultsList = $qry->fetchAll();


    $data = array();
    $CounterNumber = 0;
    $recordCount = 0;

    foreach ($ResultsList as $row) {

        $task_ref_check =  check_task_have_relocated_task_or_not($DB, $row['tm_id']);
        $CounterNumber++;

        $task_name =  '<a href="' . home_path() . '/tasks/view_task?id=' . base64_encode($row['tm_id']) . '">
                                                    ' . $row['task_title'] . '
                                                </a>';

        $pid = $row['pm_id'];
        $project = get_all_project_details_by_id($DB, $pid);
        $task_start_date = india_dateTime_format($row['tm_start_date']);
        $task_end_date = india_dateTime_format($row['tm_end_date']);
        $assign_by = $row['tm_assign_by'];

        if (!empty($_POST['task_ref']) && isset($_POST['task_ref'])) {
            $task_user = get_user_details_by_id($DB, $row['tm_assign_to']);
            $assign = "<a href='#'>" . $task_user[0]['first_name'] . " " . $task_user[0]['last_name']  . "</a>";
        } else {
            if (isset($username_assign)) {
                $task_user = get_user_details_by_id($DB, $row['tm_assign_to']);
                $assign = "<a href='#'>" . $task_user[0]['first_name'] . " " . $task_user[0]['last_name']  . "</a>";
            } else {
                $task_user = get_user_details_by_id($DB, $row['tm_assign_by']);
                $assign = "<a href='#'>" . $task_user[0]['first_name'] . " " . $task_user[0]['last_name']  . "</a>";
            }
        }



        $priority = $row['tm_priority'];
        if ($priority == 1) {
            $priority_btn = '<div class="dropdown action-label"><a class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> High </a></div>';
        } else if ($priority == 2) {
            $priority_btn = '<div class="dropdown action-label"><a class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-warning"></i> Medium </a></div>';
        } else {
            $priority_btn = '<div class="dropdown action-label"><a class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Easy </a></div>';
        }

        $check_dropdown_time = $row['tm_active'] == 0 ? 'inactive' : 'active';
        $color_success = $row['tm_active'] == 0 ? 'danger' : 'success';




        if ($task_ref_check) {

            $btn_active_status = '<span class="btn btn-sm mb-0 status_btn btn-success reallocate_btn"><i class="la la-tasks"></i>Reallocated</span>';
        } else {
            $btn_active_status = '<div class="dropdown action-label">';
            if (isset($username_assign) || (!empty($_POST['task_ref']) && isset($_POST['task_ref']))) {
                $btn_active_status .= '<a href="" class="btn btn-white btn-sm btn-rounded "><i class="fa fa-dot-circle-o text-' . $color_success . '"></i>' . $check_dropdown_time . '</a>';
            } else {
                if ($row['tm_status'] == '3' || $row['tm_status'] == '2') {
                    $btn_active_status .= '<a class="btn btn-white btn-sm btn-rounded "><i class="fa fa-dot-circle-o text-' . $color_success . '"></i>' . $check_dropdown_time . '</a>';
                } else {
                    $btn_active_status .= ' <a class="btn btn-white btn-sm btn-rounded dropdown-toggle btn_active_inactive" data-toggle="dropdown" id="parent_dropdown_' . $row['tm_id'] . '" data-target="' . $check_dropdown_time . '_' . $row['tm_id'] . '" aria-expanded="false">
                        <i class="fa fa-dot-circle-o text-' . $color_success . '"></i>
                        ' . $check_dropdown_time . '
                    </a>';
                }
                if (isset($username_assign)) {
                } else {
                    $btn_active_status .= '<div class="dropdown-menu">
                <p class="dropdown-item mb-0 dropdown_time" data-target="active_' . $row['tm_id'] . '"><i class="fa fa-dot-circle-o text-success"></i> Active</p>
                <p class="dropdown-item mb-0 dropdown_time" data-target="inactive_' . $row['tm_id'] . '"><i class="fa fa-dot-circle-o text-danger"></i> Inactive</p></div>';
                }
            }
            $btn_active_status .= '</div>';
        }






        $btn_overall_status = '<div class="text-center">';
        if ($row['tm_status'] == '0') {
            $btn_overall_status .= '<p class="btn btn-sm mb-0 status_btn btn-success">New</p>';
        } else if ($row['tm_status'] == '1') {
            $btn_overall_status .= '<p class="btn btn-sm mb-0 status_btn btn-primary">Running</p>';
        } else if ($row['tm_status'] == '3') {
            $btn_overall_status .= '<p class="btn btn-sm mb-0 status_btn btn-info">Completed</p>';
        } else if ($row['tm_status'] == '2') {
            $btn_overall_status .=  '<p class="btn btn-sm mb-0 status_btn btn-danger">Approval Pending</p>';
        }
        $btn_overall_status .= '</div>';

        $action_btn = '<div class="dropdown dropdown-action">
            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
            <div class="dropdown-menu dropdown-menu-right">';

        if ($row['tm_assign_by'] == $_SESSION['user_id'] && $row['tm_status'] != '3') {
            $action_btn .= '<a class="dropdown-item" href="' . home_path() . '/tasks/edit?id=' . base64_encode($row['tm_id']) . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
        }
        if ($row['tm_assign_to'] == $_SESSION['user_id'] && $row['tm_assign_by'] != $_SESSION['user_id']  && $row['tm_status'] != '3' && $row['tm_status'] != '2' && $_SESSION['user_type'] == 2) {
            $action_btn .= '<a class="dropdown-item" href="' . home_path() . '/tasks/add?rid=' . base64_encode($row['tm_id']) . '"><i class="fa fa-pencil m-r-5"></i> Reallocate Task</a>';
        }
        if ($row['tm_status'] == '2' && $row['tm_assign_by'] == $_SESSION['user_id']) {
            $action_btn .= '<button class="dropdown-item complete_task" data-toggle="modal" data_value="' . $row['tm_id'] . '" data-target="#complete_reason">
                        <i class="fa fa-retweet m-r-5"></i>
                        Reassign Task
                    </button> <button class="dropdown-item " id="final_complete" data-toggle="modal" data_value="' . $row['tm_id'] . '" data-target="#complete_task"> <i class="fa fa-check m-r-5"></i> Complete Task</button>';
        }
        if ($row['tm_status'] == '0' && isset($get_list_id)) {

            $action_btn .= ' <button class="dropdown-item task_delete" data-target="delete_' . $row['tm_id'] . '"><i class="fa fa-trash-o m-r-5"></i> Delete</button>';
        }
        if ($row['tm_status'] != '3' && $row['tm_status'] != '2' && $row['tm_assign_to'] == $_SESSION['user_id'] && !isset($get_list_id)) {

            $action_btn .= '<button class="dropdown-item follow_up_task" data-toggle="modal" data_value="' . $row['tm_id'] . '" data-target="#follow_up_reason">
                        <i class="fa fa-check m-r-5"></i>
                        Sent For Approval
                    </button>
                   ';
        }

        $action_btn .= ' </div>
        </div>';

        $task_type = '';
        if ($row['tm_category'] == 0) {
            $task_type = 'Once';
        } else if ($row['tm_category'] == 1) {
            $task_type = 'Daily';
        }
        // $last_entry_date = '<p class="badge badge-soft-warning">' . $last_entry_date . '</p>';

        $nestedData = array();

        $recordCount++;
        $nestedData[] = $CounterNumber;
        $nestedData[] = $task_name;

        if ($_SESSION['user_type'] != 5) {
            $nestedData[] = $project[0]['project_title'];
        }

        $nestedData[] = $task_start_date;
        $nestedData[] = $assign;
        $nestedData[] = $task_end_date;
        $nestedData[] = $priority_btn;
        $nestedData[] = $btn_active_status;
        $nestedData[] = $btn_overall_status;
        $nestedData[] = $action_btn;


        $data[] = $nestedData;
        $ArryDia = empty($ArryDia);
    }


    $json_data = array(
        "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
        "recordsTotal"    => intval($recordCount),  // total number of records
        "recordsFiltered" => intval($recordCount), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );

    echo json_encode($json_data);  // send data as json format




    // SELECT PP.hm_id, hm.hm_name, SUM(CASE WHEN PP.package_type = 2 THEN 1 ELSE 0 END) AS count_package_type_2 , SUM(CASE WHEN PP.package_type = 1 THEN 1 ELSE 0 END) AS count_package_type_1 FROM `tbl_patient_package_master` PP RIGHT JOIN `tbl_hospital_master` hm ON pp.hm_id = hm.hm_id WHERE PP.tppm_del = '0' AND (PP.tppm_status = '1' OR PP.tppm_status = '0') GROUP BY PP.hm_id;



    // SELECT thm.hm_id, thm.hm_name , count(tam.hm_id) AS count FROM `tbl_hospital_master` thm  LEFT JOIN `tbl_appointment_master` tam ON thm.hm_id = tam.hm_id WHERE tam.pam_status = '3' AND tam.pam_del = '0' GROUP BY tam.hm_id ;
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "daily_list_tasks") {

    $requestData = $_REQUEST;

    $from_new_query = "FROM `" . DB_PREFIX . "repetitive_task_master` WHERE rtm_del = '0'";

    $sqlListType = "SELECT count(*) as cnt $from_new_query";
    $qryListType = $DB->prepare($sqlListType);
    $qryListType->execute();
    $ResultsList = $qryListType->fetch();
    $totalData = $ResultsList['cnt'];
    $totalFiltered = $totalData;

    $sql = "SELECT * $from_new_query";
    $array = array();

    if (!empty($requestData['search']['value'])) {
        $sql .= " AND (rtm_title LIKE '%" . $requestData['search']['value'] . "%')";
    }

    $username = $_POST['username'];
    $sql .= " AND rtm_assign_by = '$username'";


    $sql .= " ORDER BY rtm_created_date DESC";

    $qry = $DB->prepare($sql);
    $qry->execute();
    $totalFiltered = $qry->rowCount();

    $ResultsList = $qry->fetchAll();

    $data = array();
    $CounterNumber = 0;
    $recordCount = 0;

    foreach ($ResultsList as $row) {
        $CounterNumber++;

        // $task_name =  $row['rtm_title'];
        $task_name = '<a href="' . home_path() . '/tasks/view_repetitive_task?id=' . base64_encode($row['rtm_id']) . '">' . $row['rtm_title'] . '</a>';


        $pid = $row['pm_id'];
        $project = get_all_project_details_by_id($DB, $pid);
        $task_start_date = india_dateTime_format($row['rtm_start_date']);
        $task_end_date = india_dateTime_format($row['rtm_end_date']);

        if ($task_end_date == "30-11--0001 00:00:00") {
            $task_end_date = "No End Date";
        }

        $assign_by = $row['rtm_assign_by'];
        $task_repetitive_type = $row['rtm_repetitive_type'];

        if ($task_repetitive_type == 1) {
            $task_repetitve_type_name = 'Daily';
        } else if ($task_repetitive_type == 2) {
            $task_repetitve_type_name = 'Weekly';
        } else if ($task_repetitive_type == 3) {
            $task_repetitve_type_name = 'Monthly';
        } else {
            $task_repetitve_type_name = '-';
        }

        $task_repetitive_range = $row['rtm_frequency_repeat_days'];


        $task_user = get_user_details_by_id($DB, $row['rtm_assign_to']);
        $assign = "<a href='#'>" . $task_user[0]['first_name'] . " " . $task_user[0]['last_name']  . "</a>";


        $priority = $row['rtm_priority'];
        if ($priority == 1) {
            $priority_btn = '<div class="dropdown action-label"><a class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> High </a></div>';
        } else if ($priority == 2) {
            $priority_btn = '<div class="dropdown action-label"><a class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-warning"></i> Medium </a></div>';
        } else {
            $priority_btn = '<div class="dropdown action-label"><a class="btn btn-white btn-sm btn-rounded priority_btn "  aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Easy </a></div>';
        }

        $action_btn = '<div class="dropdown dropdown-action">
            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
            <div class="dropdown-menu dropdown-menu-right">';

        if ($row['rtm_assign_by'] == $_SESSION['user_id']) {
            $action_btn .= '<a class="dropdown-item" href="' . home_path() . '/tasks/repetitive_edit?id=' . base64_encode($row['rtm_id']) . '"><i class="fa fa-pencil m-r-5"></i> Edit</a>';
        }

        $action_btn .= ' </div>
        </div>';


        // $last_entry_date = '<p class="badge badge-soft-warning">' . $last_entry_date . '</p>';

        $nestedData = array();

        $recordCount++;
        $nestedData[] = $CounterNumber;
        $nestedData[] = $task_name;
        $nestedData[] = $project[0]['project_title'];
        $nestedData[] = $task_repetitve_type_name;
        $nestedData[] = $task_repetitive_range;
        $nestedData[] = $task_start_date;
        $nestedData[] = $assign;
        $nestedData[] = $task_end_date;
        $nestedData[] = $priority_btn;
        $nestedData[] = $action_btn;


        $data[] = $nestedData;
        $ArryDia = empty($ArryDia);
    }


    $json_data = array(
        "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
        "recordsTotal"    => intval($recordCount),  // total number of records
        "recordsFiltered" => intval($recordCount), // total number of records after searching, if there is no searching then totalFiltered = totalData
        "data"            => $data   // total data array
    );

    echo json_encode($json_data);  // send data as json format




    // SELECT PP.hm_id, hm.hm_name, SUM(CASE WHEN PP.package_type = 2 THEN 1 ELSE 0 END) AS count_package_type_2 , SUM(CASE WHEN PP.package_type = 1 THEN 1 ELSE 0 END) AS count_package_type_1 FROM `tbl_patient_package_master` PP RIGHT JOIN `tbl_hospital_master` hm ON pp.hm_id = hm.hm_id WHERE PP.tppm_del = '0' AND (PP.tppm_status = '1' OR PP.tppm_status = '0') GROUP BY PP.hm_id;



    // SELECT thm.hm_id, thm.hm_name , count(tam.hm_id) AS count FROM `tbl_hospital_master` thm  LEFT JOIN `tbl_appointment_master` tam ON thm.hm_id = tam.hm_id WHERE tam.pam_status = '3' AND tam.pam_del = '0' GROUP BY tam.hm_id ;
}
