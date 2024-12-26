<?php
session_start();
$fn = $_SESSION['SESS_FIRST_NAME'];
$r = $_SESSION['SESS_LAST_NAME'];
$emp_id = $_SESSION['USER_EMPLOYEE_ID'];
include('../../config.php');

// Retrieve and sanitize form data
$id = (int) $_GET['id'];  // Sales list ID
$qty = (int) $_POST['qty'];  // Quantity 
$print_note = htmlspecialchars($_POST['print_note'], ENT_QUOTES, 'UTF-8');

$material_id = (int) $_POST['material_id'];  // Material ID

// Fetch the selected material's details
$result = select('materials', '*', 'id=' . $material_id, '../../');
if ($result) {
    $row = $result->fetch();
    if ($row) {
        $available_qty = (int) $row['available_qty'];  // Available quantity
        $material_name = $row['name'];  // Material name
    }
}

// Fetch the job number from the sales_list
$salesResult = select('sales_list', '*', 'id=' . $id, '../../');
if ($salesResult) {
    $salesRow = $salesResult->fetch();
    if ($salesRow) {
        $job_no = $salesRow['job_no'];  // Job number
        $product_name = $salesRow['name'];  // Product name
    }
}

// Update the materials table (subtract the quantity)
$updateMaterials = update('materials', ['available_qty' => $available_qty - $qty], 'id=' . $material_id, '../../');

// Update the sales_list table (status, note, qty)
$updateSalesList = update('sales_list', ['status' => 'fix', 'print_note' => $print_note, 'print_qty' => $qty,'status_id'=>'4'], 'id=' . $id, '../../');

// Insert the record into the inventory table
$date = date('Y-m-d');  // Current date
$time = date('H:i:s');  // Current time



$insertData = array(
    "data" => array(
        'material_id' => $material_id,
        'name' => $material_name,
        'job_no' => $job_no,
        'type' => 'out',  // Since this is an outgoing transaction
        'balance' => $available_qty - $qty,  // Store available_qty as the balance before the deduction
        'qty' => $qty,  // Quantity being subtracted
        'date' => $date,
        'time' => $time,
        'sales_list_id' => $id  
    ),
    "other" => array(
    ),
);
$result=insert("inventory", $insertData,'../../');

$insertData1 = array(
    "data" => array(
        'mat_id' => $material_id,
        'mat_name' => $material_name,
        'job_no' => $job_no,
        'qty' => $qty,
        'sales_list_id' => $id,
        'type' => 'print',


    ),
    "other" => array(
    ),
);
$result=insert("fix_materials", $insertData1,'../../');

$insertData1 = array(
    "data" => array(
        "user_id" =>$emp_id,
        "user_name" => $fn,
        "job_no" => $job_no,
        "note" => "printing complete by designer $fn $r for $product_name",
        "type" => 'job',
        "source_id" => $id,
        "action" => 0,
        "activity"=>'printing',
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),

    ),
    "other" => array(
    ),
);
$result=insert("user_activity", $insertData1,'../../');




if ($insertData && $updateSalesList) {
    // Success message
    echo "<script>alert('Approved and inventory updated successfully!');</script>";
} else {
    // Failure message
    echo "<script>alert('Failed to update inventory or status.');</script>";
}

// Redirect back to the job details page
echo "<script>window.location.href = '../../printing.php?id=".$id."';</script>";

exit;
?>
