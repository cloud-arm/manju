<?php
session_start();
include('config.php');

$invo = $_POST['id'];
$emp_id = $_POST['emp_id'];
$note = $_POST['note'];

$result = query("SELECT * FROM user WHERE id = '$emp_id'");
for ($i = 0; $r01 = $result->fetch(); $i++) {
    $user_level = $r01['user_lewal'];  
}

if($user_level== 2){
    $result = update(
        'purchases', 
        [
            'approve' => 'reject',
            'reject_note' => $note,
            'sales_manager_id'=> $emp_id
        ], 
        "invoice_no='$invo'", 
        ''
    );
}else{
    $result = update(
        'purchases', 
        [
            'approve' => 'reject',
            'accountant_id'=> $emp_id
        ], 
        "invoice_no='$invo'", 
        ''
    );
}

header("location:job_summery.php?id=$invo");