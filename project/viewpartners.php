<?php
include("header.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
} else {
    header('Location: login.php');
    exit();
}

if(isset($_SESSION['profile']) && $_SESSION['profile'] == true){
}
else{
    header('Location: profile.php');
    exit();
}

include_once 'dbconnection.php';

// Function to sanitize input
function sanitizeInput($input)
{
    return htmlspecialchars(strip_tags(trim($input)));
}

// Process search input from the form
$searchKeyword = isset($_GET['search_keyword']) ? sanitizeInput($_GET['search_keyword']) : '';

// Process filter input from the form
$filterCommunity = isset($_GET['filter_community']) ? sanitizeInput($_GET['filter_community']) : false;
$filterBusiness = isset($_GET['filter_business']) ? sanitizeInput($_GET['filter_business']) : false;

// Construct SQL query with search and filter conditions
$sql = "SELECT * FROM partners 
        WHERE (name LIKE ? OR description LIKE ? OR type LIKE ? OR resources_available LIKE ? OR phone_number LIKE ? OR active LIKE ? OR upcoming_events LIKE ? OR rating LIKE ? OR email LIKE ?)
        ";

// Check if either Business Partner or Community Partner checkboxes are selected
if ($filterBusiness || $filterCommunity) {
    $sql .= "AND (";
    
    // Check if Business Partner checkbox is selected
    if ($filterBusiness) {
        $sql .= "type LIKE 'Business' ";
    }

    // Check if Community Partner checkbox is selected
    if ($filterCommunity) {
        if ($filterBusiness) {
            $sql .= "OR ";
        }
        $sql .= "type LIKE 'Community' ";
    }

    $sql .= ")";
}

$sql .= "ORDER BY id DESC";

$stmt = $conn->prepare($sql);

// Bind parameters for the search
$searchParam = "%$searchKeyword%";
$stmt->bind_param("ssssssiss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
$stmt->execute();
$result = $stmt->get_result();
$partners = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .topnav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .topnav input[type="text"] {
            flex-grow: 1;
            padding: 6px;
        }

        .topnav .filter-checkboxes {
            display: flex;
        }

        .topnav .filter-checkboxes label {
            margin-right: 10px;
        }

        .topnav button {
            padding: 6px 10px;
        }

        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
        }

        .partner-record {
            flex: 1;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .star-rating {
            color: gold;
            display: inline-block;
        }
    </style>
</head>

<body>

    <h1>All Partners</h1>
    <hr>

    <!-- Add the search and filter form -->
    <form method="GET" action="">
        <div class="topnav">
            <input type="text" placeholder="Search.." name="search_keyword" value="<?php echo $searchKeyword; ?>">
            <div class="filter-checkboxes">
                <label>
                    <input type="checkbox" name="filter_community" <?php echo $filterCommunity ? 'checked' : ''; ?>>
                    Community Partner
                </label>
                <label>
                    <input type="checkbox" name="filter_business" <?php echo $filterBusiness ? 'checked' : ''; ?>>
                    Business Partner
                </label>
            </div>
            <button type="submit">Search</button>
        </div>
    </form>

    <div class="dashboard-container">
        <?php
        foreach ($partners as $partner) {
            echo '<div class="partner-record">';
            echo '<h2>' . (isset($partner['name']) && !empty($partner['name']) ? sanitizeInput($partner['name']) : '') . ' <span class="star-rating">' . (isset($partner['rating']) && !empty($partner['rating']) ? str_repeat('★', $partner['rating']) : '') . '</span></h2>';
            echo '<p>Description: ' . (isset($partner['description']) && !empty($partner['description']) ? sanitizeInput($partner['description']) : '') . '</p>';
            echo '<p>Type: ' . (isset($partner['type']) && !empty($partner['type']) ? sanitizeInput($partner['type']) : '') . '</p>';
            echo '<p>Resources Available: ' . (isset($partner['resources_available']) && !empty($partner['resources_available']) ? sanitizeInput($partner['resources_available']) : '') . '</p>';
            echo '<p>Status: ' . (isset($partner['active']) && !empty($partner['active']) ? sanitizeInput($partner['active']) : '') . '</p>';
            echo '<p>Upcoming Events: ' . (isset($partner['upcoming_events']) && !empty($partner['upcoming_events']) ? sanitizeInput($partner['upcoming_events']) : '') . '</p>';
            echo '<p>Email: ' . (isset($partner['email']) && !empty($partner['email']) ? sanitizeInput($partner['email']) : '') . '</p>';
            echo '<p>Phone Number: ' . (isset($partner['phone_number']) && !empty($partner['phone_number']) ? sanitizeInput($partner['phone_number']) : '') . '</p>';
            echo '</div>';
        }
        ?>
    </div>

    <?php include("footer.html"); ?>

</body>

</html>
