<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'dbconnection.php';

function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = sanitizeInput($_POST["id"]);
    $name = sanitizeInput($_POST["name"]);
    $description = sanitizeInput($_POST["description"]);
    $type = sanitizeInput($_POST["type"]);
    $resources_avilable = sanitizeInput($_POST["resources_avilable"]);
    $phone_number = sanitizeInput($_POST["phone_number"]);

    // Prepare and execute SQL statement
    $sql = "INSERT INTO partners 
    (id, name, description, type, resources_avilable, phone_number) 
    VALUES (?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    id = VALUES(id),
    name = VALUES(name),
    description = VALUES(description),
    type = VALUES(type),
    resources_avilable=VALUES(resources_avilable),
    phone_number = VALUES(phone_number)";

    echo $sql;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $id, $name, $description, $type, $resources_avilable, $phone_number);


    if ($stmt->execute()){
        header("Location: admindashboard.php");
    }
    else {
       echo "Error: " . $stmt->error;
   }


   $stmt->close();
   $conn->close();
}
?>
