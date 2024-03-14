<?php
include_once '../init.php';


if (isset($_REQUEST['do']) && $_REQUEST["do"] == "delete_file") {

    $modify_by = $_SESSION['user_id'];
    $date = date("Y-m-d H:i:s");
    $get_data = sanitizeInput($_POST['data']);
    $get_data_arr = explode('_', $get_data);

    if ($get_data_arr[0] == 'T') {

        $res =   get_all_task_details_by_id($DB, $get_data_arr[1]);
        // The string representation of an array
        $stringRepresentation = $res[0]['tm_image'];
        // Decode the JSON string to an array
        $img_arr = json_decode($stringRepresentation);


        if (in_array($get_data_arr[2], $img_arr)) {

            if (($key = array_search($get_data_arr[2], $img_arr)) !== false) {
                $filePath  = APPPATH . '/assets/test/' . $get_data_arr[2];
                // echo $filePath;
                if (file_exists($filePath)) {
                    // Attempt to delete the file
                    if (unlink($filePath)) {
                        unset($img_arr[$key]);
                        $sql = "UPDATE " . $DB_Prefix . "task_master SET tm_image=:tm_img, tm_modify_by=:tm_modify_by WHERE tm_id = :task_id";

                        $statement = $DB->prepare($sql);

                        $statement->bindValue(":tm_modify_by", $modify_by);
                        $statement->bindValue(":tm_img", json_encode($img_arr));
                        $statement->bindValue(":task_id", $get_data_arr[1]);

                        $res = $statement->execute();

                        $data['status'] = true;
                        $data['msg'] = "Image Deleted Successfully";
                        echo json_encode($data);
                    } else {
                        $data['status'] = false;
                        $data['msg'] = "Something Went Wrong";
                        echo json_encode($data);
                    }
                } else {
                    $data['status'] = false;
                    $data['msg'] = "File Does Not Exist";
                    echo json_encode($data);
                }
            }
        }
    } else {

        $data['status'] = false;
        $data['msg'] = "Something Went Wrong . $filePath ";
        echo json_encode($data);
    }
} else {
    $data['status'] = false;
    $data['msg'] = "Something Went Wrong";
    echo json_encode($data);
}
