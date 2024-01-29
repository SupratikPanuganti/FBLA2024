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
    $sql = "SELECT * FROM partners WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $partnerDetails = $result->fetch_assoc();
    } else {
        $isUpdateMode=false;
    }

    $stmt->close();
}
?>

<form action="partner_submit.php" method="post">
    <h1>Partner Details Form</h1>

    <input type="hidden" id="id" name="id" value="<?php echo $isUpdateMode ? sanitizeInput($partnerDetails['id']) : '' ?>">

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $isUpdateMode ? sanitizeInput($partnerDetails['name']) : '' ?>"><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="3"><?php echo $isUpdateMode ? sanitizeInput($partnerDetails['description']) : '' ?></textarea><br>

    <label for="type">Type:</label>
    <input type="text" id="type" name="type" required value="<?php echo $isUpdateMode ? sanitizeInput($partnerDetails['type']) : '' ?>"><br>

    <label for="resources_avilable">Resources Avilable:</label>
    <textarea id="resources_avilable" name="resources_avilable" required rows="3"><?php echo $isUpdateMode ? sanitizeInput($partnerDetails['resources_avilable']) : '' ?></textarea><br>

    <label for="phone_number">Phone Number:</label>
    <input type="tel" id="phone_number" name="phone_number" value="<?php echo $isUpdateMode ? sanitizeInput($partnerDetails['phone_number']) : '' ?>"><br>

    <button type="submit"><?php echo $isUpdateMode ? 'Update' : 'Submit'; ?></button>
</form>
<?php include("footer.html"); ?>