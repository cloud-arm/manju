<?php


function tracker($session_id, $session_first_name, $job_no, $last_name,$activity) {
    include('../connect.php');
    date_default_timezone_set("Asia/Colombo");
    include('db_query/insert.php');


    // Create the data array for inserting into the user_activity table
    $insertData1 = array(
        "data" => array(
            "user_id" => $session_id, // Employee ID
            "user_name" => $session_first_name, // User name
            "source_id" => $job_no, // Job number
            "note" => "$activity done by $session_first_name $last_name", // Note about the activity
            "type" => 'job', // Type of activity (job)
            "action" => 0, // Action type (0 in this case)
            "activity" => $activity, // Activity description
            "date" => date('Y-m-d'), // Current date
            "time" => date('H.i.s'), // Current time
        ),
        "other" => array(), // Add any additional data here if needed
    );
    
    // Call the insert function to insert the data into the user_activity table
    $result = insert("user_activity", $insertData1, '../../');
    
    // Return the result (optional)
    return $result;
}


?>