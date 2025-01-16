<?php
session_start();
include('../config.php');
include('../connect.php');


$veh_no=$_POST['veh_no'];
$rep_type=$_POST['rep_type'];
$parts=$_POST['parts'];
$value = $_POST['value1'];
$id = $_POST['id2'];

$parts1=select_item('tr_parts_list','name','id='.$parts,'../');


$insertData = array(
    "data" => array(
        "vehicle_no" => $veh_no,
        "repire_type" => $rep_type,
        "parts" => $parts1,
        "date"=>date('Y-m-d'),
        "value"=>$value,
    ),
    "other" => array(
    ),
);
$result=insert("tr_parts_record", $insertData,'../');


//print_r( $result);
header("location: ../tr_add_extra.php?id=".$id);

?>