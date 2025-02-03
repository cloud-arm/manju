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

    $total_pay_amount = $list['total_pay_amount'];
    $last_pay_date = $list['last_pay_date'];
    $credit_balance = $list['credit_balance'];
    $last_pay_amount = $list['last_pay_amount'];
    $available_installments = $list['available_installments'];
    $default_amount = $list['default_amount'];
    $default_balance = $list['default_balance'];
    $project_number = $list['project_number'];
    $status = $list['status'];
    $pay_balance = $list['pay_balance'];
    $last_term_date = $list['last_term_date'];

    $app_id = $list['id'];
   
    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM credit WHERE project_number = '$project_number' AND status = 'Setup'",'../../');

            if ($result instanceof PDOStatement) {
                if ($result->rowCount() > 0) {
                    $con = $result->rowCount();
                }
            }

            if ($con != 0) {

                // update query
                $sql = "UPDATE credit SET total_pay_amount = ?, last_pay_date = ?, credit_balance = ?, last_pay_amount = ?, available_installments = ?, status = ?, default_value = ?, default_balance = ?, last_term_date = ?, pay_balance = ? WHERE project_number = ?";
                $ql = $db->prepare($sql);
                $ql->execute(array($total_pay_amount, $last_pay_date, $credit_balance, $last_pay_amount, $available_installments, $status, $default_amount, $default_balance, $last_term_date, $pay_balance, $project_number));
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
