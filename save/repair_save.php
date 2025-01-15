<?php
session_start();
include('../config.php');
include('../connect.php');


echo $veh_no=$_POST['veh_no'];  
echo "<br>";
echo $re_type=$_POST['re_type']; 
echo "<br>";
echo $value=$_POST['value']; 

echo "<br>";

echo $id = $_POST['id2'];

echo "<br>";

$type_name=select_item('repair_type','name','id='.$re_type,'../');

echo $type_name;


$insertData = array(
    "data" => array(
        "type_id" => $re_type,
        "approve" => 0,
        "value" => $value,
        "number" => $veh_no,
        "type_name" => $type_name,
        "date"=>date('Y-m-d'),
        "vehicle_id"=>$id,
    ),
    "other" => array(
    ),
);
$result=insert("repair", $insertData,'../');


//print_r( $result);
header("location: ../repire.php?id=".$id);

?>