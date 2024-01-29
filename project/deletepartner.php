<?php
include_once 'dbconnection.php';

// Check if 'id' is set in the POST request
if (isset($_POST['id'])) {
    // Sanitize and get the partner ID
    $partnerId = htmlspecialchars(strip_tags($_POST['id']));

    // Prepare and execute the SQL query to delete the partner
    $sql = "DELETE FROM partners WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $partnerId);

    if ($stmt->execute()) {
        // If deletion is successful, send a success response
        echo json_encode(['status' => 'success', 'message' => 'Partner deleted successfully']);
    } else {
        // If an error occurs during deletion, send an error response
        echo json_encode(['status' => 'error', 'message' => 'Error deleting partner']);
    }

    // Close the statement
    $stmt->close();
} else {
    // If 'id' is not set in the POST request, send an error response
    echo json_encode(['status' => 'error', 'message' => 'Missing partner ID']);
}

// Close the database connection
$conn->close();
?>
