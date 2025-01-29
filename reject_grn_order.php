<?php

session_start();
include('config.php');

$id=$_POST['id'];
$note = $_POST['note'];
$emp_id = $_POST['emp_id'];

$result = query("SELECT * FROM user WHERE id = '$emp_id'");
for ($i = 0; $r01 = $result->fetch(); $i++) {
    $user_level = $r01['user_lewal'];  
}

if($user_level == 1){
    $result = update(
        'purchases_list', 
        [
            'action' => 'reject by RM',
            'approve' => '20',
            'reject_note' => $note,
            'rm_id' => $emp_id
        ], 
        'id='.$id, 
        ''
    );

$r1 = select_query("SELECT * FROM purchases_list WHERE id='$id' ");
while ($row = $r1->fetch()) {
    $invo = $row['invoice_no'];
}

$re = select_query("SELECT COUNT(approve) AS count_approve FROM purchases_list WHERE invoice_no='$invo' AND approve='0'");
    if ($row = $re->fetch()) {
        $count = $row['count_approve'];
    }
echo $count;
    // If no rows have 'approve=0', update the 'purchases' table
    if ($count == 0) {
        $result = update(
            'purchases', 
            [
                'approve' => 'approve',
                'action' => '1',
            ], 
            "invoice_no='$invo'", 
            '');
        echo $invo;
        header("location:job_summery.php?id=$invo");
    }else{
        header("location:job_summery.php?id=$invo");
    }

}elseif($user_level == 5){
    $result = update(
        'purchases_list', 
        [
            'action' => 'reject By Branch',
            'approve' => '20',
            'reject_note' => $note
        ], 
        'id='.$id, 
        ''
    );

    $r1 = select_query("SELECT * FROM purchases_list WHERE id='$id'");
    while ($row = $r1->fetch()) {
        $invo = $row['invoice_no'];
    }

    header("location:job_summery.php?id=$invo");

}else{
    $result = update(
        'purchases_list', 
        [
            'action' => 'reject By Storse',
            'approve' => '20',
            'reject_note' => $note,
            'store_manager_id' => $emp_id
        ], 
        'id='.$id, 
        ''
    );

$r1 = select_query("SELECT * FROM purchases_list WHERE id='$id' ");
while ($row = $r1->fetch()) {
    $invo = $row['invoice_no'];
}

$re = select_query("SELECT COUNT(approve) AS count_approve FROM purchases_list WHERE invoice_no='$invo' AND approve='1'");
    if ($row = $re->fetch()) {
        $count = $row['count_approve'];
    }
echo $count;
    // If no rows have 'approve=0', update the 'purchases' table
    if ($count == 0) {
        $result = update(
            'purchases', 
            [
                'approve' => 'approve',
                'action' => '4',
            ], 
            "invoice_no='$invo'", 
            '');
        header("location:job_summery.php?id=$invo");
    }else{
        header("location:job_summery.php?id=$invo");
    }

}
?>