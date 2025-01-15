<?php
session_start();
include('../config.php');
include('../connect.php');


$v_part=$_POST['v_parts'];


$parts1=select_item('tr_parts_list','name','id='.$parts,'../');


$insertData = array(
    "data" => array(
        "name" => $v_part,
        'value' => 0,

    ),
    "other" => array(
    ),
);
$result=insert("tr_parts_list", $insertData,'../');


//print_r( $result);
header("location: ../tr_add_part_list");

?>