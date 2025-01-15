<?php
session_start();
include('../config.php');
include('../connect.php');

$id=$_GET['id'];




echo $id;



    $result = update('repair', 
    [
     'approve'=>1,
     'appr_date'=>date('Y-m-d')

    ], 'id='.$id, '../');










echo $result['status'];
header("location: ../tr_vehicle_manage");

?>