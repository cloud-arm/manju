<?php
session_start();
include('config.php');

$id=$_POST['id'];
$qty = $_POST['qty'];
$emp_id = $_POST['emp_id'];

$result = query("SELECT * FROM user WHERE id = '$u_id'");
for ($i = 0; $r01 = $result->fetch(); $i++) {
    $user_level = $r01['user_lewal'];  
}

if($user_level == 1){
    $result = update(
        'purchases_list', 
        [
            'qty' => $qty,
            'memo' => 'update by rm'
        ], 
        'id='.$id, 
        ''
    );
}else{
    $result = update(
        'purchases_list', 
        [
            'qty' => $qty,
            'memo' => 'update by stores'
        ], 
        'id='.$id, 
        ''
    );
}

$r1 = select_query("SELECT * FROM purchases_list WHERE id='$id' ");
while ($row = $r1->fetch()) {
    $invo = $row['invoice_no'];
}

header("location:job_summery.php?id=$invo");