<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'dbconnection.php';

function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST["username"]);
    $firstname = sanitizeInput($_POST["firstname"]);
    $lastname = sanitizeInput($_POST["lastname"]);
    $email = sanitizeInput($_POST["email"]);
    $phonenumber = sanitizeInput($_POST["phonenumber"]);
    $dob = sanitizeInput($_POST["dob"]);
    $street_address = sanitizeInput($_POST["street_address"]);
    $city = sanitizeInput($_POST["city"]);
    $state = sanitizeInput($_POST["state"]);
    $zipcode = sanitizeInput($_POST["zipcode"]);
    $grade = sanitizeInput($_POST["grade"]);
    $student_image = sanitizeInput($_POST["student_image"]);

    // Prepare and execute SQL statement
    $sql = "INSERT INTO students 
    (username, firstname, lastname, email, phonenumber, dob, streetaddress, city, state, zipcode, grade, student_image) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    firstname = VALUES(firstname),
    lastname = VALUES(lastname),
    email = VALUES(email),
    phonenumber = VALUES(phonenumber),
    dob=VALUES(dob),
    streetaddress = VALUES(streetaddress),
    city = VALUES(city),
    state = VALUES(state),
    zipcode = VALUES(zipcode),
    grade= VALUES(grade),
    student_image=VALUES(student_image)";

    echo $sql;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssib", $username, $firstname, $lastname, $email, $phonenumber, $dob, $street_address, $city, $state, $zipcode, $grade, $student_image);


    if ($stmt->execute()){
        $_SESSION["loggedin"] = true;
        $_SESSION["profile"]=true;
        header("Location: index.php");
    }
    else {
       echo "Error: " . $stmt->error;
   }


   $stmt->close();
   $conn->close();
}
?>
