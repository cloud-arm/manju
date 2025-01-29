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
$recovery_list = json_decode($json_data, true);

// respond init
$result_array = array();

foreach ($recovery_list as $list) {

    $tds_value = $list['tds_value'];
    $no_of_installments = $list['no_of_installments'];
    $available_installments = $list['available_installments'];
    $installments_amount = $list['installments_amount'];
    $positive = $list['positive'];
    $status = $list['status'];
    $schedule_date = $list['schedule_date'];
    $project_number = $list['project_number'];
    $recovery_officer_id = $list['recovery_officer_id'];

    $app_id = $list['id'];
   
    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM credit WHERE recovery_officer_id = '$recovery_officer_id' AND project_number = '$project_number' AND ststus = 'Setup'",'../../');

            if ($result instanceof PDOStatement) {
                if ($result->rowCount() > 0) {
                    $con = $result->rowCount();
                }
            }

            if ($con == 0) {

                // update query
                $sql = "UPDATE credit SET tds_value = ?, no_of_installments = ?, available_installments = ?, installments_amount = ?, positive = ?, status = ?, schedule_date = ?, app_id = ? WHERE project_number = ?";
                $ql = $db->prepare($sql);
                $ql->execute(array($tds_value, $no_of_installments, $available_installments, $installments_amount, $positive, $status, $schedule_date, $app_id, $project_number));
            }

            // get credit list id
            $result = query("SELECT * FROM credit WHERE app_id='$app_id'",'../../');
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
