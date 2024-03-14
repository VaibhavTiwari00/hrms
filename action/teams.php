<?php

include_once '../init.php';




if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'fetch_state_by_country') {

    $id =  $_POST['id'];
    $data =  get_all_state_list($DB, $id);
    echo json_encode($data);
} else if (isset($_REQUEST['do']) && $_REQUEST["do"] == "show_members") {

    $team_id = sanitizeInput($_POST['team_id']);
    // Sanitize and validate input data
    print_r(check_active_team_member($DB, $team_id));

    exit();
} else {
    echo "Something went wrong";
}

// Function to sanitize input data




die();
