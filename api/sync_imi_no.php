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
    try {
        // Prepare and execute the SQL query
        $result = query("SELECT imi_no, product_id, date, time, purchase_list_id, id FROM imi_no WHERE id > '$id' ",'../');
    
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

