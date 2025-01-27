<?php
session_start();
include('../config.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Retrieve the transaction ID from the POST data


if (!isset($_POST['id'])) {
    echo json_encode(array("message" => "Error: Missing parameters."));
    exit();
}else{
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    try {
        // get employee id
        $result0 = query("SELECT employee_id FROM user WHERE id='$user_id'",'../');
        for ($i = 0; $row = $result0->fetch(); $i++) {
            $emp_id = $row['employee_id'];
        }

        // get branch id
        $result1 = query("SELECT branch_id FROM employee WHERE id='$emp_id'",'../');
        for ($i = 0; $row = $result1->fetch(); $i++) {
            $branch_id = $row['branch_id'];
        }

        // Prepare and execute the SQL query
        $result = query("SELECT * FROM imi_no WHERE id > '$id' AND branch_id = '$branch_id' ",'../');
    
        // Fetch the results and create an array
        $result_array = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $result_array[] = $row;
        }
    
        // Encode the array into JSON and output it
        echo json_encode($result_array);
    } catch (PDOException $e) {
        echo json_encode(array("message" => "Error: " . $e->getMessage()));
    }
}

