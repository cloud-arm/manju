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

    $product_id = $list['product_id'];
    $imi_number = $list['imi_number'];
    $tech_id = $list['tech_id'];
    $pay_type = $list['pay_type'];
    $date = $list['date'];
    $time = $list['time'];
    $amount = $list['amount'];
    $down_payment = $list['down_payment'];
    $balance = $list['balance'];
    $nic = $list['nic'];
    $emp_id = $list['mpo_id'];
    $card_number = $list['card_number'];
    $lat = $list['lat'];
    $lon = $list['lon'];

    $app_id = $list['id'];

    $sync_date = date('Y-m-d');
    $sync_time = date('H:i:s');

    $invoice_no = $emp_id . date('YmdHis');

        //------------------------------------------------------------------------------//
        try {
            //checking duplicate
            $con = 0;
            $result = query("SELECT * FROM sales WHERE imi_number = '$imi_number'",'../../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $con = $row['id'];
            }

            //get the branch id from mpo id
            $result = query("SELECT branch_id,name,des FROM employee WHERE id = '$emp_id'",'../../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $branch_id = $row['branch_id'];
                $emp_name = $row['name'];
                $emp_type = $row['des'];
            }

            $result1 = query("SELECT product_name FROM products WHERE id = '$product_id'",'../../');
            for ($i = 0; $row = $result1->fetch(); $i++) {
                $product_name = $row['product_name'];
            }

            if ($con == 0) {
                //get the technision name
                $result = query("SELECT name FROM employee WHERE id = '$tech_id'",'../../');
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $tech_name = $row['name'];
                }

                //get customer details
                $result1 = query("SELECT name,address,phone,nic FROM visit WHERE nic = '$nic'",'../../');
                for ($i = 0; $row = $result1->fetch(); $i++) {
                    $name = $row['name'];
                    $address = $row['address'];
                    $phone = $row['phone'];
                    $nic = $row['nic'];
                }

                // insert query
                $sql = "INSERT INTO sales (product_id,imi_number,tech_id,pay_type,date,time,amount,down_payment,balance,nic,app_id,sync_date,sync_time,invoice_no,emp_id,branch_id,emp_name,product_name,card_number,sale_status,emp_type,tech_name,lat,lon,cus_name) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql);
                $ql->execute(array($product_id, $imi_number, $tech_id, $pay_type, $date, $time, $amount, $down_payment, $balance, $nic, $app_id, $sync_date, $sync_time, $invoice_no, $emp_id, $branch_id, $emp_name, $product_name, $card_number,"pending",$emp_type,$tech_name,$lat,$lon,$name));

                $sql1 = "UPDATE branch_stock  SET qty = qty - ? WHERE product_id = ? AND branch_id = ?";
                $q = $db->prepare($sql1);
                $q->execute(array(1, $product_id, $branch_id));

                $sql2 = "INSERT INTO payment (pay_type, amount, date, time, invoice_no, credit_balance, down_payment) VALUES (?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql2);
                $ql->execute(array($pay_type, $amount, $date, $time, $invoice_no, $balance, $down_payment));

                if ($pay_type == "Credit") {
                    $sql3 = "INSERT INTO credit (credit_amount, credit_balance, schedule_date, invoice_no, branch_id, status, project_number, lat, lon, cus_name) VALUES (?,?,?,?,?,?,?,?,?,?)";
                $ql = $db->prepare($sql3);
                $ql->execute(array($balance, $balance, '', $invoice_no, $branch_id, "Pending", $card_number, $lat, $lon, $name));
                }

                $sql4 = "INSERT INTO customer (name, address, contact, nic) VALUES (?,?,?,?)";
                $ql = $db->prepare($sql4);
                $ql->execute(array($name, $address, $phone, $nic));

                $sql5 = "UPDATE imi_no  SET status = ? WHERE imi_no = ?";
                $q = $db->prepare($sql5);
                $q->execute(array("Sale", $imi_number));
            }

            // get sales id
            $result = query("SELECT * FROM sales WHERE app_id='$app_id'",'../../');
            for ($i = 0; $row = $result->fetch(); $i++) {
                $id = $row['id'];
                $ap_id = $row['app_id'];
                $invo = $row['invoice_no'];
                $sale_status = $row['sale_status'];
            }

            // create success respond 
            $res = array(
                "cloud_id" => $id,
                "app_id" => $ap_id,
                "invoice_no" => $invo,
                "sale_status" => $sale_status,
                "status" => "success",
                "message" => "",
            );

            array_push($result_array, $res);

        } catch (PDOException $e) {

            // create error respond 
            $res = array(
                "cloud_id" => 0,
                "app_id" => 0,
                "invoice_no" => 0,
                "sale_status" => "",
                "status" => "failed",
                "message" => $e->getMessage(),
            );

            array_push($result_array, $res);

        }
}

// send respond
echo (json_encode($result_array));
