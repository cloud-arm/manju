<?php
session_start();
include('config.php');

$invo = $_GET['id'];
$emp_id = $_GET['emp_id'];

echo 'emp id is '.$emp_id;
echo 'id is '.$emp_id;

$result = query("SELECT * FROM user WHERE id = '$emp_id'");
for ($i = 0; $r01 = $result->fetch(); $i++) {
    $user_level = $r01['user_lewal'];  
}

if($user_level== 2){
    $result = update(
        'purchases', 
        [
            'approve' => 'approve',
            'action' => '2',
            'sales_manager_id'=> $emp_id
        ], 
        "invoice_no='$invo'", 
        ''
    );
}else{
    $result = update(
        'purchases', 
        [
            'approve' => 'approve',
            'action' => '3',
            'accountant_id'=> $emp_id
        ], 
        "invoice_no='$invo'", 
        ''
    );
}

header("location:job_summery.php?id=$invo");