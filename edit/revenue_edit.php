<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_GET['id'];
$ins = $_POST['ins'];
$lic = $_POST['lice'];



echo $id;



    $result = update('vehicles', 
    [
     'licence_date'=>$lic,
     'insurance_date'=>$ins

    ], 'id='.$id, '../');










echo $result['status'];
header("location: ../revinue");

?>