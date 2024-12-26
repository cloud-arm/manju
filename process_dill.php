<?php
include 'connect.php'; // include your database connection
include 'config.php';  // include your config file

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $reason = $_POST['reason'];
    // Retrieve the job number based on the provided id
 //   $r = select_item('sales_list', 'job_no', 'id='.$id);

    $result = select('sales_list', '*', 'id=' . $id);

if ($result) {
    $row = $result->fetch();
    if ($row) {
        $job_no = $row['job_no'];
    }
}
    

        echo $job_no;
        // Perform the update on the sales_list
        $r2 = update('sales_list', ['action' => '5', 'status' => 'delete'], 'id='.$id, '');

        // Redirect to the appropriate page with the job number encoded
        header("Location: job_view.php?id=".base64_encode($job_no));

}
?>
