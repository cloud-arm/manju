<?php
session_start();
include('../../config.php');


 
//$id=$_POST['company_id'];
$name = $_POST['name'];
$nic_name = $_POST['nic_name'];
$address = $_POST['address'];
$id_no = $_POST['id_no'];
$mobile = $_POST['mobile'];
$filter_id = $_POST['filter_id'];
$date = $_POST['date'];
$amount = $_POST['amount'];
$sales_name = $_POST['sales_name'];
$sales_id = $_POST['sales_id'];
$sales_phone = $_POST['sales_phone'];
$mac_name = $_POST['mac_name'];
$mac_id = $_POST['mac_id'];
$mac_phone = $_POST['mac_phone'];
$road = $_POST['road'];



$invo=date('ymdHis');
$insertData = array(
    "data" => array(
        "name" => $name,
        "note" => '',
        "company_id" => '',
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),
        "invoice_no" => $invo,
        "user_id" => $_SESSION['SESS_MEMBER_ID'],
        "action" => '1',
        "status" => 'pending',
        "all_job_no" => '',
        "dll" => '0',
        "customer_type" => '',
        "nic_name" => $nic_name,
        "address" => $address,
        "id_no" => $id_no,
        "mobile" => $mobile,
        "filter_id" => $filter_id,
        "date" => $date,
        "amount" => $amount,
        "sales_name" => $sales_name,
        "sales_id" => $sales_id,
        "sales_phone" => $sales_phone,
        "mac_name" => $mac_name,
        "mac_id" => $mac_id,
        "mac_phone" => $mac_phone,
        "road" => $road,

    ),
    "other" => array(
    ),
);
$result=insert("job", $insertData,'../../');
//$id=base64_encode(select_item('job','id','invoice_no='.$invo,'../../'));
$insertData = array(
    "data" => array(
        "name" => $name,
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),
        "nic" => $id_no,
        "address" => $address,
        "phone" => $mobile,
        "tds_value" => "0",
       

    ),
    "other" => array(
    ),
);
$result=insert("visit", $insertData,'../../');

$insertData = array(
    "data" => array(
        "name" => $name,
        "date" => date('Y-m-d'),
        "nic" => $nic_name,
        "address" => $address,
        "contact" => $mobile,
       

    ),
    "other" => array(
    ),
);
$result=insert("customer", $insertData,'../../');


//echo $result['status'];
//header("location: ../../job_view.php?id=$id");