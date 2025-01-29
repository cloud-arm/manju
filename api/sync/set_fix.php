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

    $imi_no = $list['imi_no'];
    $project_number = $list['project_number'];
    $date = $list['date'];
    $time = $list['time'];
    $tds_value = $list['tds_value'];
    $water_source = $list['water_source'];
    $nic = $list['nic'];
    $tech_id = $list['tech_id'];

    $app_id = $list['id'];

    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM fix WHERE imi_no = '$imi_no' AND project_number = '$project_number'",'../../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $con = $row['id'];
            }

            if ($con == 0) {
                //get technision name
                $result = query("SELECT * FROM employee WHERE id = '$tech_id'",'../../');
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $tech_name = $row['name'];
                }

                // insert query
                $sql = "INSERT INTO fix (imi_no,project_number,date,time,tds_value,water_source,nic,app_id,sync_date,sync_time,tech_id,tech_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($imi_no, $project_number, $date, $time, $tds_value, $water_source, $nic, $app_id, $sync_date, $sync_time, $tech_id, $tech_name));

                $sql1 = "UPDATE sales SET sale_status = ? WHERE imi_number = ? AND card_number = ?";
                $q = $db->prepare($sql1);
                $q->execute(array("fixed", $imi_no, $project_number, ));
            }

            // get sales list id
            $result = query("SELECT * FROM fix WHERE app_id='$app_id'",'../../');
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
