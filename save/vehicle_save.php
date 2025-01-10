<?php
session_start();
include('../config.php');
include('../connect.php');


$veh_id=$_POST['veh_id'];
$number=$_POST['number'];
$brand=$_POST['brand'];
$licence = $_POST['licence_date'];
$insurance = $_POST['insurance_date'];

$type=select_item('vehicle_type','name','id='.$veh_id,'../');


$insertData = array(
    "data" => array(
        "brand" => $brand,
        "number" => $number,
        "type" => $veh_id,
        "type_name" => $type,
        "date"=>date('Y-m-d'),
        "licence_date"=>$licence,
        "insurance_date"=>$insurance,
    ),
    "other" => array(
    ),
);
$result=insert("vehicles", $insertData,'../');


//print_r( $result);
header("location: ../vehicles.php");

?>