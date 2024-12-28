<?php
session_start();
include('../config.php');

$id=$_POST['id'];
$branch_id = $_POST['branch_id'];

$result = update(
    'employee',
    [
        'branch_id' => $branch_id,
    ],
    'id = ' . $id . '',
    "../"
);

//echo $result['status'];
header("location: ../branch_view?id=$id");
