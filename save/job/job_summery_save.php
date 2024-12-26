<?php
session_start();
$fn = $_SESSION['SESS_FIRST_NAME'];
$r = $_SESSION['SESS_LAST_NAME'];
$emp_id = $_SESSION['USER_EMPLOYEE_ID'];
include('../../config.php');

// Get the ID from the URL
$id = $_GET['id'];

// Fetch the existing sales list data
$result = select('sales_list', '*', 'id=' . $id, '../../');

if ($result) {
    $row = $result->fetch();
    if ($row) {
        $product_id = $row['product_id'];
        $location_id = $row['location_id'];
        $product_name = $row['name'];
        $job_no = $row['job_no'];
    }
}

// Retrieve the note from the form submission
$art_note = isset($_POST['note']) ? htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8') : '';  // Sanitize special characters


// Update both the 'status' and 'art_note' in the sales_list table
$result = update('sales_list', ['status' => 'on_aprove', 'art_note' => $art_note,'status_id'=>'2'], 'id=' . $id, '../../');

$insertData1 = array(
    "data" => array(
        "user_id" =>$emp_id,
        "user_name" => $fn,
        "job_no" => $job_no,
        "note" => "Disgner note add by designer $fn $r for $product_name",
        "type" => 'job',
        "action" => 0,
        "source_id" => $id,
        "activity"=>'art_work',
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),

    ),
    "other" => array(
    ),
);
$result=insert("user_activity", $insertData1,'../../');

// Redirect back to the job summary page


echo $result['status'];
header("Location: ../../job_summery?id=" . base64_encode($id));
exit;
?>
