<?php

include_once("config.php");

$nic_input = $_GET['nic_input'];
$cus_id = 0;
$result = select('visit', '*', "nic	 = '$nic_input'");
for ($i = 0; $row = $result->fetch(); $i++){
    $cus_id = $row['id'];
    $name = $row['name'];
    $cus_address = $row['address'];
    $cus_phone_no = $row['phone'];
    
    

}

    if($cus_id > 0){
        $response = array('cus_name'=>$name,'cus_phone_no'=>$cus_phone_no,'cus_address'=>$cus_address, 'cus_id'=>$cus_id,'action'=>'true');
    }else{
        $response = array('action'=>'false');
    }




$json_response = json_encode($response);
echo $json_response;

