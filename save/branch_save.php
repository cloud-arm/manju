<?php
session_start();
include('../config.php');

$dist_id = $_POST['district'];

$result = query("SELECT * FROM district WHERE id = '$dist_id'",'../');                       
for($i=0; $row = $result->fetch(); $i++){
    $district = $row['district_name'];
}

$insertData = array(
    "data" => array(
        "name" => $_POST['name'],
        "address" => $_POST['address'],
        "district_id" => $dist_id,
        "district" => $district,
    ),
    "other" => array(
    ),
);
insert("branch", $insertData,'../');


header("location: ../branch");
 