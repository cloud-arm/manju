<?php
session_start();
include('config.php');

$vehicle_id = $_POST['vehicle_id'];
$driver_id = $_POST['driver_id'];
$invoice = $_POST['invoice_id'];
$date = date('Y-m-d');

$result = update(
    'purchases',
    [
        'driver_id' => $driver_id,
        'lorry_number'=> $vehicle_id,
        'gri_create_date'=> $date
    ],
    "invoice_no = '$invoice'",
    ''
);

header("location: job_summery?id=$invoice");