<?php

include_once '../init.php';




error_reporting(1);
ini_set('display_errors', true);


$requestData = $_REQUEST;



if (isset($_POST['select_center_type']) && $_POST['select_center_type'] != 0) {

    $select_center_type = $_POST['select_center_type'];

    $from_new_query = "FROM tbl_user_master WHERE um_del = '0'";
} else {
    $from_new_query = "FROM tbl_user_master WHERE um_del = '0'";
}


$sqlListType = "SELECT count(*) as cnt $from_new_query";
$qryListType = $DB->prepare($sqlListType);
$qryListType->execute();
$ResultsList = $qryListType->fetch();
$totalData = $ResultsList['cnt'];
$totalFiltered = $totalData;

$sql = "SELECT * $from_new_query";

$array = array();


// if (!empty($requestData['search']['value'])) {

//     $sql .= " AND (first_name LIKE '%" . $requestData['search']['value'] . "%')";
// }

if (isset($_POST['filter_date']) && !empty($_POST['filter_date'])) {
    $date = $_POST['filter_date'];
} else {
    $date = date('Y-m-d');
}
if (isset($_POST['filter_team']) && $_POST['filter_team'] != 0) {
    $filter_team = $_POST['filter_team'];
    $sql .= " AND team_id = '$filter_team'";
} else {
    $sql .= "";
}

if (isset($_POST['select_center_zone']) && !empty($_POST['select_center_zone'])) {
    $center_zone = $_POST['select_center_zone'];

    $sql .= " AND hm_zone = '$center_zone'";
}


$qry = $DB->prepare($sql);
$qry->execute();

$totalFiltered = $qry->rowCount();
$ResultsList = $qry->fetchAll();

$data = array();
$CounterNumber = 0;
$recordCount = 0;

foreach ($ResultsList as $row) {
    $CounterNumber++;

    $name = $row['first_name'] . ' ' . $row['last_name'];

    $login_time = get_login_time_date_wise($DB, $date, $row['user_unique_id']);
    $logout_time = get_logout_time_date_wise($DB, $date, $row['user_unique_id']);
    $working_time = get_working_time_date_wise($DB, $date, $row['user_unique_id']);


    // $last_entry_date = '<p class="badge badge-soft-warning">' . $last_entry_date . '</p>';

    $nestedData = array();

    $recordCount++;
    $nestedData[] = $CounterNumber;
    $nestedData[] = $name;
    $nestedData[] = $login_time;
    $nestedData[] = $logout_time;
    $nestedData[] = $working_time;

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
