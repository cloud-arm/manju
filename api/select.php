<?php
session_start();
include('../config.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if parameter is provided
if (!isset($_POST['table_name'])) {
    echo json_encode(array("message" => "Error: Missing parameters."));
    exit();
}else{
    $table_name = $_POST['table_name'];
    if (isset($_POST['columns'])) {
        $columns = $_POST['columns'];
    }else{
        $columns = "*";
    }
    $where = $_POST['where'];
    $master_key = $_POST['master_key'];
    $client_key = $_POST['client_key'];

    if($master_key == 0 && $client_key == 0){
        try {
            $result = select($table_name,$columns,$where,'../');
            
            // Fetch the results and create an array
            $result_array = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $result_array[] = $row;
            }
    
            echo json_encode($result_array, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            echo json_encode(["message" => "Error: " . $e->getMessage()]);
        }
    }else{
        echo json_encode(array("message" => "Error: Unauthorized User!"));
    exit();
    }
}


