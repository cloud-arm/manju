<?php
include('connect.php');
include('config.php');

$project = $_POST['project'];
$reco = $_POST['reco'];

$sql = "UPDATE credit 
        SET recovery_officer_id = ?
		WHERE project_number = ?";
$q = $db->prepare($sql);
$q->execute(array($reco,$project));

header("location: recovery_dashboard.php");
?>