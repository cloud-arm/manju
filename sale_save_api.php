<?php
include("connect.php");
include("config.php");

// Set headers for API response
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Get the raw JSON input
$json_data = file_get_contents('php://input');

// Decode JSON data
$salesData = json_decode($json_data, true);

// Response array to send back the results
$response = array();

foreach ($salesData as $sale) {
    // Extract data from the input JSON
    $invoice_number = $sale['invoice_number'];
    $amount = $sale['amount'];
    $employee_id = $sale['employee_id'];
    $mac_phone = $sale['mac_phone'];
    $mac_name = $sale['mac_name'];
    $sales_name = $sale['sales_name'];
    $sales_phone = $sale['sales_phone'];
    $product_id = $sale['product_id'];
    $serial_no = $sale['serial_no'];
    $customer_type = $sale['customer_type'];
    $nic = $sale['nic'];
    $customer_name = $sale['customer_name'];
    $customer_address = $sale['customer_address'] ;
    $customer_contact = $sale['customer_contact'] ;
    $pay_amount = $sale['pay_amount'];


    // Set default date and time
    $date_sync = date("Y-m-d");
    $time_sync = date("H:i:s");

    try {





        // Check if the customer exists
        $stmt = $db->prepare("SELECT * FROM customer WHERE nic = ?");
        $stmt->execute([$nic]);
        $customer = $stmt->fetch();

        if ($customer) {
            $customer_id = $customer['id'];
        } else {
            // Insert new customer if not found
            $sql = "INSERT INTO customer (name, address, contact, date, nic) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$customer_name, $customer_address, $customer_contact, $date, $nic]);
            $customer_id = $db->lastInsertId(); // Get the new customer ID
        }

        // Insert into `sales` table
        $sql = "INSERT INTO sales (
            invoice_number, customer_name, date, customer_id, pay_amount, customer_type, nic
        ) VALUES (
             ?, ?, ?, ?, ?, ?, ?
        )";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                $invoice_number, $customer_name, $date, $customer_id, $pay_amount, $customer_type, $nic
]);

        // Insert into `job` table
        $sql = "INSERT INTO job (
            name, address, contact, date, nic, mac_phone, mac_name, sales_name, sales_phone,customer_id
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ? ,?
        )";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        $customer_name, $customer_address, $customer_contact, $date, $nic, $mac_phone, $mac_name, $sales_name, $sales_phone , $customer_id
    ]);



        // Success response for this record
        $response[] = [
            "invoice_number" => $invoice_number,
            "status" => "success",
            "message" => "Sales and job records inserted successfully"
        ];
    } catch (Exception $e) {
        // Error response for this record
        $response[] = [
            "invoice_number" => $invoice_number,
            "status" => "failed",
            "message" => $e->getMessage()
        ];
    }
}

// Return the JSON response
echo json_encode($response);
?>
