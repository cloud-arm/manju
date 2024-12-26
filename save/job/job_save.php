<?php
session_start();
include('../../config.php');


 
$id=$_POST['company_id'];
$invo=date('ymdHis');
$insertData = array(
    "data" => array(
        "name" => select_item('company','name','id='.$id,'../../'),
        "note" => $_POST['note'],
        "company_id" => $_POST['company_id'],
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),
        "invoice_no" => $invo,
        "user_id" => $_SESSION['SESS_MEMBER_ID'],
        "action" => '1',
        "status" => 'pending',
        "all_job_no" => $_POST['all_job_no'],
        "dll" => '0',
        "customer_type" => select_item('company','type','id='.$id,'../../'),
    ),
    "other" => array(
    ),
);
$result=insert("job", $insertData,'../../');
$id=base64_encode(select_item('job','id','invoice_no='.$invo,'../../'));

//echo $result['status'];
header("location: ../../job_view.php?id=$id");