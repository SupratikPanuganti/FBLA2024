<?php
include("header.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once 'dbconnection.php';

// Function to sanitize input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

// Check for "id" parameter in the URL
$userId = isset($_GET['id']) ? $_GET['id'] : null;

// Check if it's an update mode
$isUpdateMode = !empty($userId);

// Fetch property details if in update mode
if ($isUpdateMode) {
    // Fetch property details using $propertyId
    $sql = "SELECT * FROM students WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userDetails = $result->fetch_assoc();
    } else {
        $isUpdateMode=false;
    }

    $stmt->close();
}
?>

<form action="profile_submit.php" method="post">
    <h1>User Details Form</h1>
    <h2> Welcome <?php echo $_SESSION["username"]?></h2>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['username']) : $_SESSION["username"] ?>" readonly><br>

    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['firstname']) : '' ?>" required><br>

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" required value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['lastname']) : '' ?>"><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['email']) : '' ?>"><br>

    <label for="phonenumber">Phone Number:</label>
    <input type="tel" id="phonenumber" name="phonenumber" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['phonenumber']) : '' ?>"><br>

    <label for="dob">Date of Birth (MM/dd/YYYY):</label>
    <input type="date" id="dob" name="dob" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['dob']) : '' ?>"><br>

    <label for="street_address">Street Address:</label>
    <input type="text" id="street_address" name="street_address" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['streetaddress']) : '' ?>"><br>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['city']) : '' ?>"><br>

    <label for="state">State:</label>
    <input type="text" id="state" name="state" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['state']) : '' ?>"><br>

    <label for="zipcode">Zip Code:</label>
    <input type="text" id="zipcode" name="zipcode" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['zipcode']) : '' ?>"><br>

    <label for="grade">Grade:</label>
    <input type="text" id="grade" name="grade" value="<?php echo $isUpdateMode ? sanitizeInput($userDetails['grade']) : '' ?>"><br>

    <label for="student_image">Student Image:</label>
    <input type="file" id="student_image" name="student_image" accept="image/*"><br>

    <button type="submit"><?php echo $isUpdateMode ? 'Update' : 'Submit'; ?></button>
</form>
<?php include("footer.html"); ?>