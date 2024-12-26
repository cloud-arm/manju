<?php
session_start();


include('../../config.php');


$m_id = $_POST['m_id'];
$location_id = $_POST['location_id'];
$job_no = $_POST['job_no'];



$action = select_item('job','action','id='.$job_no,'../../');



$result = update('job_location', ['m_id' => $m_id], 'id='.$location_id, '../../');



if($action== 3){
    
    $result = update('job', ['action'=>4], 'id='.$job_no, '../../');
}


header("location: ../../job_view.php?id=" . base64_encode($job_no));
exit();
?>
