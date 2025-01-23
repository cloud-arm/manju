<?php
include("../../connect.php");
include("../../config.php");
include('../log.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get json data
$json_data = file_get_contents('php://input');

// get values
$cash_list = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($cash_list as $list) {

    $emp_id = $list['emp_id'];
    $emp_name = $list['emp_name'];
    $emp_type = $list['emp_type'];
    $balance = $list['balance'];
    $last_update = $list['last_update'];

    $app_id = $list['id'];
   
    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM cash_account WHERE emp_id = '$emp_id' AND app_id = '$app_id'",'../../');

            if ($result instanceof PDOStatement) {
                if ($result->rowCount() > 0) {
                    $con = $result->rowCount();
                }
            }

            if ($con == 0) {

                // update query
                $sql = "INSERT INTO cash_account (emp_id,emp_name,emp_type,balance,last_update,sync_date,sync_time,app_id) VALUES (?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($emp_id, $emp_name, $emp_type, $balance, $last_update, $sync_date, $sync_time, $app_id));
            }

            // get credit list id
            $result = query("SELECT * FROM cash_account WHERE app_id='$app_id'",'../../');
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
