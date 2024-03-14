<?php

include_once '../init.php';

error_reporting(1);




if (isset($_REQUEST['do']) && $_REQUEST["do"] == "add_project") {
    // Sanitize and validate input data

    $data = [];


    $created_by = $_SESSION['user_id'];
    $project_name = sanitizeInput($_POST['project_name']);
    $project_priority = sanitizeInput($_POST['project_priority']);
    $project_assign_to = sanitizeInput($_POST['project_dep']);
    $project_start_date = sanitizeInput($_POST['project_start_date']);
    $project_end_date = sanitizeInput($_POST['project_end_date']);
    $project_desc = $_POST['project_desc'];

    $files = $_FILES['files'];

    if ($project_name && $project_priority && $project_assign_to && $project_start_date && $project_end_date) {

        $uploadedFiles = [];

        if (isset($_FILES['files']) && !empty($_FILES['files'])) {
            $uploadDirectory = "/assets/test/";
            $allowedExtensions = array("jpg", "jpeg", "png", "txt", "pdf"); // Allowed file extensions
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
                        $data['msg'] = "Only jpg, jpeg, png, txt, pdf are allowed " . $project_department;
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

        $sql = "INSERT INTO " . $DB_Prefix . "project_master(`project_unique_id`,`project_title`,`pm_desc`,`pm_image`,`pm_priority`,`pm_assign_by`,`pm_assign_to`,`pm_start_date`,`pm_end_date`,`pm_created_by`) VALUES (:project_unique_id,:project_title,:pm_desc,:pm_image,:pm_priority,:pm_assign_by,:pm_assign_to,:pm_start_date,:pm_end_date,:pm_created_by)";

        $statement = $DB->prepare($sql);

        $statement->bindValue(":project_unique_id", "1");
        $statement->bindValue(":project_title", $project_name);
        $statement->bindValue(":pm_desc", $project_desc);
        $statement->bindValue(":pm_image",  $uploadedFiles);
        $statement->bindValue(":pm_priority", $project_priority);
        $statement->bindValue(":pm_assign_by", $created_by);
        $statement->bindValue(":pm_assign_to", $project_assign_to);
        $statement->bindValue(":pm_start_date", $project_start_date);
        $statement->bindValue(":pm_end_date", $project_end_date);
        $statement->bindValue(":pm_created_by", $created_by);

        $res = $statement->execute();
        // echo 1;
        $data['status'] = true;
        $data['msg'] = "Project Added successfully";

        echo json_encode($data);
        die();
    } else {
        $data['status'] = false;
        $data['msg'] = "Somthing Failed";
        echo json_encode($data);
        die();
    }
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "edit_project") {
    // Sanitize and validate input data

    $data = [];
    $modify_by = $_SESSION['user_id'];

    $project_name = sanitizeInput($_POST['project_name']);
    $project_priority = sanitizeInput($_POST['project_priority']);
    $project_assign_to = sanitizeInput($_POST['project_dep']);
    $project_start_date = sanitizeInput($_POST['project_start_date']);
    $project_end_date = sanitizeInput($_POST['project_end_date']);
    $project_id = sanitizeInput($_POST['project_id']);
    $project_desc = $_POST['project_desc'];
    $files = $_FILES['files'];

    if ($project_name && $project_priority && $project_assign_to && $project_start_date && $project_end_date && $project_id) {
        $uploadedFiles = [];

        if (isset($_FILES['files']) && !empty($_FILES['files'])) {
            $uploadDirectory = "/assets/test/";
            $allowedExtensions = array("jpg", "jpeg", "png", "txt", "pdf"); // Allowed file extensions
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
                        $data['msg'] = "Only jpg, jpeg, png, txt, pdf are allowed";
                        echo json_encode($data);
                        die();
                    }
                }
            }
        } else {
            // Handle if no files were submitted
            $uploadedFiles = [];
        }


        $results = get_all_project_details_by_id($DB, $project_id);

        $img_arr = json_decode($results[0]['pm_image']);



        $totaluploadedFiles = json_encode(array_merge($uploadedFiles, $img_arr));

        $sql = "UPDATE " . $DB_Prefix . "project_master SET project_title = :project_title,pm_desc = :pm_desc,pm_image = :pm_image,pm_priority = :pm_priority,pm_assign_to = :pm_assign_to,pm_start_date = :pm_start_date,pm_end_date = :pm_end_date,pm_modify_by = :pm_modify_by WHERE pm_id = :pm_id";


        $statement = $DB->prepare($sql);

        $statement->bindValue(":project_title", $project_name);
        $statement->bindValue(":pm_desc", $project_desc);
        $statement->bindValue(":pm_image",  $totaluploadedFiles);
        $statement->bindValue(":pm_priority", $project_priority);
        $statement->bindValue(":pm_assign_to", $project_assign_to);
        $statement->bindValue(":pm_start_date", $project_start_date);
        $statement->bindValue(":pm_end_date", $project_end_date);
        $statement->bindValue(":pm_modify_by", $modify_by);
        $statement->bindValue(":pm_id", $project_id);

        $res = $statement->execute();
        // echo 1;
        $data['status'] = true;
        $data['msg'] = "Project Edited successfully";

        echo json_encode($data);
        die();
    } else {
        $data['status'] = false;
        $data['msg'] = "Somthing Failed";
        echo json_encode($data);
        die();
    }
} elseif (isset($_REQUEST['do']) && $_REQUEST["do"] == "project_pick") {


    $modify_by = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $get_data = sanitizeInput($_POST['data']);
    $get_data_arr = explode('_', $get_data);


    if ($get_data_arr[0] == 'delete') {
        $project_count = get_all_task_count_of_project($DB, $get_data_arr[1]);

        if ($project_count === 0) {
            $sql = "UPDATE " . $DB_Prefix . "project_master SET pm_del=:pm_del, pm_modify_by=:pm_modify_by WHERE pm_id = :pm_id";

            $statement = $DB->prepare($sql);

            $statement->bindValue(":pm_modify_by", $modify_by);
            $statement->bindValue(":pm_del", 1);
            $statement->bindValue(":pm_id", $get_data_arr[1]);

            $res = $statement->execute();

            $data['status'] = true;
            $data['msg'] = "Project Deleted Successfully";
            echo json_encode($data);
        } else {
            $data['status'] = false;
            $data['msg'] = "Failed: Before deleting the project delete all the task of this project";
            echo json_encode($data);
        }
    }

    die();
}
