<?php
session_start();
include('connect.php');
include('config.php');
date_default_timezone_set("Asia/Colombo");

$u = $_SESSION['SESS_MEMBER_ID'];
$date = date('Y-m-d');

$invo = $_POST['id'];
$type = $_POST['type'];
$qty = $_POST['qty'];
$id2 = $_POST['id2'];

$pro = $_POST['pr'];
$branch_id = 1;

    $result = query("SELECT * FROM products WHERE id='$pro' ");
    for($i=0; $row = $result->fetch(); $i++){
        $pro_name = $row['product_name']; 
        $unit_price = $row['cost_price'];
    }

    $amount = $qty * $unit_price;

    $sql = "INSERT INTO purchases_list (invoice_no,name,qty,date,price,product_id,type,amount,branch_id) VALUES (?,?,?,?,?,?,?,?,?)";
    $re = $db->prepare($sql);
    $re->execute(array($invo,$pro_name,$qty,$date,$unit_price,$pro,$type,$amount,$branch_id));

    header("location: grn_order.php?id=$invo");
