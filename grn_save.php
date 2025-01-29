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
$emp_id = $_POST['emp_id'];

$result = query("SELECT sum(amount),sum(discount) FROM purchases_list WHERE invoice_no='$invo' AND approve !='5' ");
for ($i = 0; $row = $result->fetch(); $i++) {
    $amount = $row['sum(amount)'];
    $dic = $row['sum(discount)'];
}

$result1 = query("SELECT branch_id FROM employee WHERE id='$emp_id' ");
for ($i = 0; $row = $result1->fetch(); $i++) {
    $branch_id = $row['branch_id'];
}

$result2 = query("SELECT name FROM branch WHERE id='$branch_id' ");
for ($i = 0; $row = $result2->fetch(); $i++) {
    $branch_name = $row['name'];
}

$date = date("Y-m-d");
$time = date('H:i:s');

    $sql = "INSERT INTO purchases (invoice_no,amount,remarks,date,type,branch_id,branch_name) VALUES (?,?,?,?,?,?,?)";
    $re = $db->prepare($sql);
    $re->execute(array($invo, $amount, $note, $date, $type, $branch_id, $branch_name));

        $sql = "UPDATE  purchases_list SET action=?, branch_id=? WHERE invoice_no=?";
        $ql = $db->prepare($sql);
        $ql->execute(array('active', $branch_id, $invo));


header("location: grn_order_rp.php");
