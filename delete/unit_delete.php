<?php
include '../connect.php'; // include your database connection
include '../config.php'; // include your config file

if (isset($_GET['id'])) {
    $unit_id = $_GET['id'];


    
    
    try {
        // Prepare the delete statement
        $stmt = $db->prepare("DELETE FROM unit_record WHERE id = :id");
        $stmt->bindParam(':id', $unit_id);
        $stmt->execute();
        
        // Redirect back to the list page after deletion
        header("Location: ../unit");
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
