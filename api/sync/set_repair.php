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
$repair_list = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($repair_list as $list) {

    $emp_id = $list['emp_id'];
    $emp_type = $list['emp_type'];
    $amount = $list['amount'];
    $date = $list['date'];
    $time = $list['time'];
    $project_number = $list['project_number'];
    $repair_imi_number = $list['repair_imi_number'];
    $repair_type = $list['repair_type'];

    $app_id = $list['id'];
   
    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM sale_repair WHERE project_number = '$project_number' AND app_id = '$app_id'",'../../');

            if ($result instanceof PDOStatement) {
                if ($result->rowCount() > 0) {
                    $con = $result->rowCount();
                }
            }

            if ($con == 0) {

                // update query
                $sql = "INSERT INTO sale_repair (emp_id,emp_type,amount,date,time,sync_date,sync_time,project_number,repair_imi_number,repair_type,app_id) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($emp_id, $emp_type, $amount, $date, $time, $sync_date, $sync_time, $project_number, $repair_imi_number, $repair_type, $app_id));
            }

            // get credit list id
            $result = query("SELECT * FROM sale_repair WHERE app_id='$app_id'",'../../');
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
