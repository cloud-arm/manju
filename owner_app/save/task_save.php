<?php
session_start();
$fn = $_SESSION['SESS_FIRST_NAME'];
$r = $_SESSION['SESS_LAST_NAME'];
$emp_id = $_SESSION['USER_EMPLOYEE_ID'];
include('../../config.php');
include('../../product_photo_up.php');


$id = $_POST['id'];
$id2 = $_POST['id2'];
echo "this is a id: ".$id;
//$product_id = $_POST['product_id'];
$width = $_POST['width']; 
$height = $_POST['height'];
$unit = $_POST['unit'];

if($unit=='inch'){
    $width=$width/12;
    $height=$height/12;
}

$note = htmlspecialchars($_POST['note'], ENT_QUOTES, 'UTF-8');

$date = date('Y-m-d');

$result = select('sales_list', '*','id='.$id, '../../');
while ($row = $result->fetch()) {
       
        $product_id = $row['product_id'];
        $location_id = $row['location_id'];
        $product_name = $row['name'];
        $job_no = $row['job_no'];
        $m_img = $row['m_img'];
    } 


echo "$job_no";

//echo "$product_id";
//echo "$location_id";
//echo "$product_name";
//echo "$job_no";




$result = update('sales_list', ['width' => $width , 'height'=>$height , 'sqrt'=>$width*$height , 'note'=>$note , 'm_date'=>$date , 'status'=>'artwork','status_id' => '1'], 'id='.$id, '../../');

$result2=select('job', '*','id='.$id, '../../');

if ($result2) {
    $row = $result2->fetch();
    if ($row) {
       
        $status = $row['status'];

    } 
} 
//echo $id;
echo "$status";

if($status = 'pending'){
    $result3 = update('job', ['status'=>'running'], 'id='.$job_no, '../../');
    echo $result['status'];

}

$insertData = array(
    "data" => array(
        "type" =>'measure',
        "job_no" => $job_no,
        "source_id" => $id,
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),
        "name" => $m_img, 
        "action" => '',

    ),
    "other" => array(
    ),
);
$result=insert("img_hub", $insertData,'../../');
//echo $result['massage'];

$insertData1 = array(
    "data" => array(
        "user_id" =>$emp_id,
        "user_name" => $fn,
        "job_no" => $job_no,
        "note" => "measurements add by $fn $r for $product_name",
        "type" => 'job',
        "action" => 0,
        "source_id" => $id,
        "date" => date('Y-m-d'),
        "time" => date('H.i.s'),
        "activity" => 'measure',

    ),
    "other" => array(
    ),
);
$result=insert("user_activity", $insertData1,'../../');


if($id2 == 0){
  header("Location: ../../job_summery?id=".base64_encode($id));
}else{
// Redirect back to the job details page
header("Location: ../task_view.php?location_id=$location_id&job_id=$job_no");
}
exit;
?>
