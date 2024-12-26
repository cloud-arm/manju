<?php
session_start();
include('../config.php');



$id=$_POST['company_id'];
$lo_id=$_POST['location_id'];
$insertData = array(
    "data" => array(
        "name" => $_POST['name'],
        "position" => $_POST['position'],
        "phone_no" => $_POST['phone_no'],
        "phone_no2" => $_POST['phone_no2'],
        "email" => $_POST['email'],
        "company_id" => $_POST['company_id'],
        "company_name" => select_item('company','name','id='.$id,'../'),
        "location_id" => $_POST['location_id'],
        "location" => select_item('location','name','id='.$lo_id,'../'),
    ),
    "other" => array(
    ),
);
$result=insert("contact", $insertData,'../');

//echo $result['status'];
header("location: ../company_view?id=$id&status=".$result['status']);
