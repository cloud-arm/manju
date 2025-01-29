<?php
session_start();
include('config.php');
include('connect.php');

$id = $_POST['id'];
$emi_no = $_POST['emi_no'];
$date = date('Y-m-d');
$time = date('H:i:s');

$result = query("SELECT * FROM purchases_list WHERE id = '$id'");
for ($i = 0; $r01 = $result->fetch(); $i++) {
    $qty = $r01['qty'];
    $product_id = $r01['product_id'];
    $invoice = $r01['invoice_no'];
    $branch_id = $r01['branch_id'];
}

$sql = "INSERT INTO imi_no (imi_no,date,time,product_id,purchase_list_id,status,branch_id) VALUES (?,?,?,?,?,?,?)";
$re = $db->prepare($sql);
$re->execute(array($emi_no,$date, $time, $product_id,$id,"issued from Stores",$branch_id));

$result = query("SELECT COUNT(*) AS emi_count FROM imi_no WHERE date = '$date' AND purchase_list_id = '$id'");
for ($i = 0; $r01 = $result->fetch(); $i++) {
    $count = $r01['emi_count'];
}

echo $count;
echo $qty;

if ($count == $qty) {
    header("location: job_summery.php?id=$invoice");
}else{
    header("location: emi_add?id=$id");
}