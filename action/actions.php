<?php

include_once '../init.php';

error_reporting(1);


if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'fetch_state_by_country') {

    $id =  $_POST['id'];
    $data =  get_all_state_list($DB, $id);
    echo json_encode($data);
}

if (isset($_REQUEST['do']) && $_REQUEST["do"] == "add_user") {
    // Sanitize and validate input data

    $data = [];
    $created_by = $_SESSION['user_id'];

    $salutation = sanitizeInput($_POST['salutation']);
    $first_name = sanitizeInput($_POST['firstname']);
    $last_name = sanitizeInput($_POST['lastname']);
    $mobile_no = sanitizeInput($_POST['mobile_no']);
    $qualification = sanitizeInput($_POST['qualification']);
    $email = sanitizeInput($_POST['email']);
    $user_name = sanitizeInput($_POST['username']);
    $select_team = sanitizeInput($_POST['select_team']);
    $select_designation = sanitizeInput($_POST['select_designation']);
    $um_image = sanitizeInput($_POST['file_name']);
    $user_type = sanitizeInput($_POST['user_type']);
    $password = sanitizeInput($_POST['password']); // Don't sanitize passwords yet
    $confirmPassword = sanitizeInput($_POST['confirm_pass']);

    if ($password != $confirmPassword) {
        $data['status'] = false;
        $data['msg'] = "passoword not same";
        echo json_encode($data);
        die();
    }

    $user_check = check_user_exist($DB, $user_name);
    if (check_user_exist($DB, $user_name) >= 1) {
        $data['status'] = false;
        $data['msg'] = "Username already exists";
        echo json_encode($data);
        die();
    }


    $MMID = '1,2,3';

    $user_unique_id = uniqid();

    $uploadDirectory = "/assets/users/";
    $allowedExtensions = array("jpg", "jpeg", "png"); // Allowed file extensions
    $maxFileSize = 5 * 1024 * 1024; // 5 MB (Max file size in bytes)
    if (isset($_FILES['file_name'])) {
        $file = $_FILES['file_name'];

        // Extract file details
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        // Validate file name and extension
        $fileInfo = pathinfo($fileName);
        $fileExtension = strtolower($fileInfo['extension']);

        if (in_array($fileExtension, $allowedExtensions)) {
            if ($fileSize <= $maxFileSize) {
                // Generate a unique name to prevent overwriting files
                $newFileName = uniqid('', true) . '.' . $fileExtension;
                $destination = APPPATH . $uploadDirectory . $newFileName;

                if (move_uploaded_file($fileTmpName, $destination)) {
                    $image = $newFileName; // Assign the uploaded file name to $image or store it in a database
                } else {
                    $data['status'] = false;
                    $data['msg'] = "Error moving the file to the destination";
                    echo json_encode($data);
                    die();
                }
            } else {
                $data['status'] = false;
                $data['msg'] = "File size exceeds the maximum limit (5MB).";
                echo json_encode($data);
                die();
            }
        } else {
            $image = null;
        }
    } else {
        $image = null;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO " . $DB_Prefix . "user_master(`user_unique_id`,`mm_id`,`team_id`,`designation_id`,`ut_id`,`salutation`,`first_name`,`last_name`,`mobile_no`,`qualification`,`email`,`user_name`,`password`,`um_created_by`,um_image) VALUES (:user_unique_id,:mm_id,:team_id,:designation_id,:ut_id,:salutation,:first_name,:last_name,:mobile_no,:qualification,:email,:user_name,:password,:um_created_by,:um_image)";


    $statement = $DB->prepare($sql);

    $statement->bindValue(":user_unique_id", $user_unique_id);
    $statement->bindValue(":mm_id", $MMID);
    $statement->bindValue(":team_id", $select_team);
    $statement->bindValue(":designation_id", $select_designation);
    $statement->bindValue(":ut_id", $user_type);
    $statement->bindValue(":salutation", $salutation);
    $statement->bindValue(":first_name", $first_name);
    $statement->bindValue(":last_name", $last_name);
    $statement->bindValue(":mobile_no", $mobile_no);
    $statement->bindValue(":qualification", $qualification);
    $statement->bindValue(":email", $email);
    $statement->bindValue(":user_name", $user_name);
    $statement->bindValue(":password", $password);
    $statement->bindValue(":um_created_by", $created_by);
    $statement->bindValue(":um_image", $image);

    $res = $statement->execute();


    $data['status'] = true;
    $data['msg'] = "Successfully Added";
    echo json_encode($data);
    exit();
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "edit_user") {
    // Sanitize and validate input data

    $data = [];
    $modify_by = $_SESSION['user_id'];
    $user_id = sanitizeInput($_POST['user_id']);
    $salutation = sanitizeInput($_POST['salutation']);
    $first_name = sanitizeInput($_POST['firstname']);
    $last_name = sanitizeInput($_POST['lastname']);
    $mobile_no = sanitizeInput($_POST['mobile_no']);
    $email = sanitizeInput($_POST['email']);
    $user_name = sanitizeInput($_POST['username']);
    $select_team = sanitizeInput($_POST['select_team']);
    $select_designation = sanitizeInput($_POST['select_designation']);
    $um_image = sanitizeInput($_POST['file_name']);
    $user_type = sanitizeInput($_POST['user_type']);

    $user_details_of_edit_user = get_user_details_by_id($DB, $user_id);

    if ($user_name == $user_details_of_edit_user[0]['user_name']) {
    } else {
        $user_check = check_user_exist($DB, $user_name);
        if (check_user_exist($DB, $user_name) >= 1) {
            $data['status'] = false;
            $data['msg'] = "Username already exists";
            echo json_encode($data);
            die();
        }
    }

    if (isset($_FILES['file_name']['name']) && !empty($_FILES['file_name']['name'])) {
        $img_check  = check_img_exist($DB, $_FILES['file_name']['name']);
        if ($img_check  >= 1) {
            $data['status'] = false;
            $data['msg'] = "Image already exists, please use other image";
            echo json_encode($data);
            die();
        } else {
            $uploadDirectory = "/assets/users/";
            $allowedExtensions = array("jpg", "jpeg", "png"); // Allowed file extensions
            $maxFileSize = 5 * 1024 * 1024; // 5 MB (Max file size in bytes)
            if (isset($_FILES['file_name'])) {
                $file = $_FILES['file_name'];

                // Extract file details
                $fileName = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize = $file['size'];
                $fileError = $file['error'];

                // Validate file name and extension
                $fileInfo = pathinfo($fileName);
                $fileExtension = strtolower($fileInfo['extension']);

                if (in_array($fileExtension, $allowedExtensions)) {
                    if ($fileSize <= $maxFileSize) {
                        // Generate a unique name to prevent overwriting files
                        $newFileName = uniqid('', true) . '.' . $fileExtension;
                        $destination = APPPATH . $uploadDirectory . $newFileName;

                        if (move_uploaded_file($fileTmpName, $destination)) {
                            $image = $newFileName; // Assign the uploaded file name to $image or store it in a database
                        } else {
                            $data['status'] = false;
                            $data['msg'] = "Error moving the file to the destination";
                            echo json_encode($data);
                            die();
                        }
                    } else {
                        $data['status'] = false;
                        $data['msg'] = "File size exceeds the maximum limit (5MB).";
                        echo json_encode($data);
                        die();
                    }
                } else {
                    $image = null;
                }
            } else {
                $image = null;
            }
        }
    } else {
        $image = $user_details_of_edit_user[0]['um_image'];
    }



    $MMID = '';




    $sql = "UPDATE tbl_user_master SET team_id = :team_id, designation_id = :designation_id, ut_id = :ut_id,salutation = :salutation,first_name = :first_name,last_name = :last_name,mobile_no = :mobile_no,email = :email,user_name = :user_name,um_image = :um_image,um_modify_by = :um_modify_by WHERE user_unique_id = :userId";


    $statement = $DB->prepare($sql);

    $statement->bindValue(":userId", $user_id);
    $statement->bindValue(":team_id", $select_team);
    $statement->bindValue(":designation_id", $select_designation);
    $statement->bindValue(":ut_id", $user_type);
    $statement->bindValue(":salutation", $salutation);
    $statement->bindValue(":first_name", $first_name);
    $statement->bindValue(":last_name", $last_name);
    $statement->bindValue(":mobile_no", $mobile_no);
    $statement->bindValue(":email", $email);
    $statement->bindValue(":user_name", $user_name);
    $statement->bindValue(":um_image", $image);
    $statement->bindValue(":um_modify_by", $modify_by);
    $res = $statement->execute();


    $data['status'] = true;
    $data['msg'] = "Successfully Edited";
    echo json_encode($data);
    exit();
}





die();
