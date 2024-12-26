<?php
session_start();
include('../../config.php');

// Get the form data
$product_id = $_POST['product_id'];
$location_id = $_POST['location'];
$quantity = $_POST['qty'];
$job_no = $_POST['job_no']; 
$date = date('Y-m-d'); 
$about=$_POST['about'];





 
$product_name=select_item('products','product_name','id='.$product_id,'../../');

$location=select_item('location','name','id='.$location_id,'../../');

$action = select_item('job','action','id='.$job_no,'../../');
//echo "$action";

// Prepare the data to be inserted
$insertData = array(
    "data" => array(
        "name" => $product_name,
        "qty" => $quantity,
        "job_no" => $job_no,
        "location" => $location,
        "location_id" => $location_id,
        "product_id" => $product_id,
        "date" => $date,
        "about" => $about,
        "status" =>'measure',
    ),
    "other" => array(
    ),
);

// Insert the data into the sales_list table
insert("sales_list", $insertData, '../../');

// Redirect back to the job details page
//header("location: ../../job_view.php?id=" . base64_encode($job_no));
//echo "<script>location.href='../../job_view.php';</script>";

if($action== 2){
    
    $result = update('job', ['action'=>3], 'id='.$job_no, '../../');
    
   //header("location: ../../job_view.php?id=" . base64_encode($job_no));
    
 
}
header("location: ../../job_view.php?id=" . base64_encode($job_no));
?>
