<?php
session_start();
include('../config.php');
include('../connect.php');


$note = isset($_POST['note']) ? $_POST['note'] : '';
$tool = isset($_POST['tool_name']) ? $_POST['tool_name'] : '';
$user = isset($_POST['user_name']) ? $_POST['user_name'] : '';
$s_location = isset($_POST['s_location']) ? $_POST['s_location'] : '';


$tool_name=select_item('tools','name','id='.$tool,'../');
$user_name=select_item('user','name','id='.$user,'../');


$insertData = array(
    "data" => array(
        "name" => $tool_name,
        "user_name" => $user_name,
        "note" => $note,
        "location_id" => $s_location,
        "employee_id" => $user,
        "date"=>date('Y-m-d'),
        "time"=>date('H:i:s'),
        "action"=>'out',
    ),
    "other" => array(
    ),
);
$result=insert("gate_pass", $insertData,'../');


//print_r( $result);
header("location: ../gate_pass.php");

?>