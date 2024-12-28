<?php
session_start();
include('config.php');

$id = $_GET['id'];

$result = update(
    'purchases_list', 
    [
        'approve' => '2',
        'action'=> 'approve by stores'
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
        echo $invo;
    }
        header("location:job_summery.php?id=$invo");