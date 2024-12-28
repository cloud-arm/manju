<?php
session_start();
include('connect.php');
include('config.php');
date_default_timezone_set("Asia/Colombo");

$userid = $_SESSION['SESS_MEMBER_ID'];
$username = $_SESSION['SESS_FIRST_NAME'];

$invo = $_POST['id'];
$type = $_POST['type'];
$note = $_POST['note'];

$result = query("SELECT sum(amount),sum(discount) FROM purchases_list WHERE invoice_no='$invo' AND approve !='5' ");
for ($i = 0; $row = $result->fetch(); $i++) {
    $amount = $row['sum(amount)'];
    $dic = $row['sum(discount)'];
}

$date = date("Y-m-d");
$time = date('H:i:s');

    $sql = "INSERT INTO purchases (invoice_no,amount,remarks,date,type) VALUES (?,?,?,?,?)";
    $re = $db->prepare($sql);
    $re->execute(array($invo, $amount, $note, $date, $type));

        $sql = "UPDATE  purchases_list SET action=? WHERE invoice_no=?";
        $ql = $db->prepare($sql);
        $ql->execute(array('active', $invo));


header("location: grn_order_rp.php");
