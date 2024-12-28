<?php
session_start();
include('../config.php');




$insertData = array(
    "data" => array(
        "name" => $_POST['name'],
        "address" => $_POST['address'],
        "district" => $_POST['district'],
    ),
    "other" => array(
    ),
);
insert("branch", $insertData,'../');


header("location: ../company");
 