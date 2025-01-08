<?php
session_start();
include("connect.php");
include('config.php');

$id = $_GET['id'];
$date = date('Y-m-d');

$result = update(
    'purchases_list',
    [
        'approve'=> '3',
        'action'=> 'approve by Branch Manager'
    ],
    "id = '$id'",
    ''
);

$r1 = select_query("SELECT * FROM purchases_list WHERE id='$id' ");
while ($row = $r1->fetch()) {
    $invo = $row['invoice_no'];
    $product_id = $row['product_id'];
    $product_name = $row['name'];
    $qty = $row['qty'];
}

$r2 = select_query("SELECT * FROM branch_stock WHERE product_id='$product_id' ");
if ($r2 && $r2->rowCount() > 0) {
    // Records found
    $result = update(
        'branch_stock',
        [
            'qty'=> $qty
        ],
        "product_id = '$product_id'",
        ''
    );
} else {
    // No records found
    $sql = "INSERT INTO branch_stock (product_id,product_name,qty) VALUES (?,?,?)";
    $ql = $db->prepare($sql);
    $ql->execute(array($product_id,$product_name,$qty));
}

$sql = "INSERT INTO branch_inventory_record (product_id,product_name,invoice_no,date,qty) VALUES (?,?,?,?,?)";
$ql = $db->prepare($sql);
$ql->execute(array($product_id,$product_name,$invo,$date,$qty));

$re = select_query("SELECT COUNT(approve) AS count_approve FROM purchases_list WHERE invoice_no='$invo' AND approve='2'");
    if ($row = $re->fetch()) {
        $count = $row['count_approve'];
    }
echo $count;
    // If no rows have 'approve=0', update the 'purchases' table
    if ($count == 0) {
        $re = select_query("SELECT COUNT(approve) AS count_approve FROM purchases_list WHERE invoice_no='$invo' AND approve='20' AND action = 'reject By Branch'");
        if ($row = $re->fetch()) {
            $count2 = $row['count_approve'];
        }
        if ($count2 == 0) {
            $result = update(
                'purchases', 
                [
                    'approve' => 'approve by branch',
                    'action' => '6',
                ], 
                "invoice_no='$invo'", 
                '');
            header("location:job_summery.php?id=$invo");
        }
    }else{
        header("location:job_summery.php?id=$invo");
    }