<?php
session_start();
include('../../config.php');

$id = $_POST['id'];
$chq_no = $_POST['chq_no'];
$chq_date = $_POST['chq_date'];
$amount = $_POST['amount'];
$pay_type = $_POST['pay_type'];
$bank_name = $_POST['bank_name'];

// Get the current total credit balance for the job


// Reduce the current balance by the payment amount if the payment type is not credit

  
    //update('payment', ['credit_balance' => 'credit_balance - '.$amount], "job_no = $id AND pay_type = 'credit'", '../../');
    query("UPDATE `payment` SET credit_balance = credit_balance - $amount  WHERE job_no = $id AND pay_type = 'credit'",'../../');

    $result1=select('payment', 'credit_balance', 'job_no = ' . $id . ' AND pay_type = "credit"', '../../');
    $row = $result1->fetch();
    $credit_balance = $row['credit_balance'];


    if($credit_balance <= 0) {
        query("UPDATE `job` SET status = 'finish'  WHERE id = $id ",'../../');
    }


// Insert the new payment details into the payment table
$insertData = array(
    "data" => array(
        "chq_no" => $chq_no,
        "chq_date" => $chq_date,
        "pay_type" => $pay_type,
        "bank_name" => $bank_name,
        "amount" => $amount,
        'date' => date('Y-m-d'),
        'time' => date('H:i:s'),
        'invoice_no' => date('YmdHis'),
        'job_no' => $id,
    ),
    "other" => array(),
);
insert("payment", $insertData, '../../');

// Redirect back to the job details page
header("location: ../../job_view.php?id=" . base64_encode($id));
exit;
?>
