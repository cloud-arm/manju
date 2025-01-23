<?php

session_start();
include('config.php');

$id = $_POST['id'];
$name = $_POST['name'];
$address = $_POST['address'];
$dist_id = $_POST['district'];

$result = query("SELECT * FROM district WHERE id = '$dist_id'",);                       
for($i=0; $row = $result->fetch(); $i++){
    $district = $row['district_name'];
}

echo $id;

// Perform the update operation
$result = update('branch', ['name' => $name, 'address' => $address, 'district' => $district, 'district_id' => $dist_id], 'id=' . $id, '');

// Check if the update was successful
if ($result) {
    // If successful, show an alert message
    echo "<script>
            alert('branch details updated successfully!');
            window.location.href='branch.php';
          </script>";
} else {
    // In case of failure, show an error message
    echo "<script>
            alert('Error updating branch details. Please try again.');
            window.location.href='branch.php';
          </script>";
}

?>
