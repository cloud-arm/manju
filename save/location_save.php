<?php
session_start();
include('../config.php');



$id=$_POST['company_id'];
$id2=$_POST['id'];
$name=$_POST['name'];
$address=$_POST['address'];
$type=$_POST['type'];
$email=$_POST['email'];


echo  $id;
echo $id2;

if($id2 != '0'){
    $result = update('location', ['name' => $name , 'address' => $address,'email' => $email], 'id='.$id2, '../');
}
else{
$insertData = array(
    "data" => array(
        "name" => $name,
        "address" => $address,
        "type" => $type,
        "email" => $email,
        "company_id" => $id,
        "company_name" => select_item('company','name','id='.$id,'../'),
    ),
    "other" => array(
    ),
);
$result=insert("location", $insertData,'../');
}

echo $result['status'];
header("location: ../company_view?id=$id&status=".$result['status']);
