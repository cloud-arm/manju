<?php
include 'connect.php'; // include your database connection
include 'config.php'; // include your config file

if (isset($_GET['id'])) {
    $manager_id = $_GET['id'];

    $result = query("SELECT branch_id FROM employee WHERE id = '$manager_id'");
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                $id = $row['branch_id'];
                            }
 
    try {
        // Prepare the delete statement
        $result = update('employee',
 [
    'branch_id' => 0,
],
  'id='.$manager_id
);
        
        // Redirect back to the list page after deletion
        header("Location: branch_view.php?id=$id");
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>