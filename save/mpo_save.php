<?php
session_start();
include('../config.php');

$id=$_POST['branch_id'];
$mpo_id=$_POST['mpo_id'];

$result = update('employee',
 [
    'branch_id' => $id,
],
  'id='.$mpo_id, 
  '../'
);

header("location: ../branch_view?id=$id");
