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
$sales_list = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($sales_list as $list) {

    $project_number = $list['project_number'];
    $reason_id = $list['reason_id'];
    $date = $list['date'];
    $time = $list['time'];
    $lat = $list['lat'];
    $lon = $list['lon'];

    $app_id = $list['id'];

    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM recovery_reasons_record WHERE app_id = '$app_id' AND project_number = '$project_number'",'../../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $con = $row['id'];
            }

            if ($con == 0) { 
                //get reason
                $result = query("SELECT name FROM recovery_reasons WHERE id = '$reason_id'",'../../');
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $reason = $row['name'];
                }
                // insert query
                $sql = "INSERT INTO recovery_reasons_record (project_number,reason_id,reason,date,time,sync_date,sync_time,lat,lon,app_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($project_number, $reason_id, $reason, $date, $time, $sync_date, $sync_time, $lat, $lon, $app_id));
            }

            // get sales list id
            $result = query("SELECT * FROM recovery_reasons_record WHERE app_id='$app_id'",'../../');
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
