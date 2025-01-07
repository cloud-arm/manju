<?php
include("../connect.php");
include("../config.php");
include('log.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// get json data
$json_data = file_get_contents('php://input');

// get values
$visit_list = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($visit_list as $list) {

    $emp_id = $list['emp_id'];
    $name = $list['name'];
    $address = $list['address'];
    $phone = $list['phone'];
    $nic = $list['nic'];
    $tds_value = $list['tds_value'];
    $schedule_date = $list['schedule_date'];
    $positive = $list['positive'];
    $date = $list['date'];
    $time = $list['time'];
    $product_id = $list['product_id'];

    $app_id = $list['id'];

    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {

            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM visit WHERE app_id = '$app_id'",'../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $con = $row['id'];
            }

            if ($con == 0) {

                // insert query
                $sql = "INSERT INTO visit (emp_id,name,address,phone,nic,tds_value,schedule_date,positive,date,time,product_id,app_id,sync_date,sync_time) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($emp_id, $name, $address, $phone, $nic, $tds_value, $schedule_date, $positive, $date, $time, $product_id, $app_id, $sync_date, $sync_time));
            }

            // get sales list id
            $result = query("SELECT * FROM visit WHERE app_id='$app_id'",'../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $id = $row['id'];
                $ap_id = $row['app_id'];
            }

            // create success respond 
            $res = array(
                "cloud_id" => $id,
                "app_id" => $ap_id,
                "status" => "success",
                "message" => "",
            );

            array_push($result_array, $res);

        } catch (PDOException $e) {

            // create error respond 
            $res = array(
                "cloud_id" => 0,
                "app_id" => 0,
                "status" => "failed",
                "message" => $e->getMessage(),
            );

            array_push($result_array, $res);

        }
}

// send respond
echo (json_encode($result_array));
