<?php session_start();
$logged=true;
if (!isset($_SESSION['loggedin'])) {
    $logged=false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ATitle</title>
    <link rel="stylesheet" href="project_style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />
</head>
<body>
    <div class="menu_bar">
        <div class="left_links">
            <div class="logo">
                <img src="fbla2024logo.jpg" class="logo">
            </div>
            <div id="logo">
                <a href="index.php">Home</a>
            </div>
            <?php if ($logged == true && $_SESSION['username']!=='admin') : ?>
                <div id="logo">
                    <a href="viewpartners.php"> View Partners</a>
                </div>
            <?php endif; ?>
            <?php if ($logged == true && $_SESSION['username']!=='admin') : ?>
                <div id="logo">
                    <a href="reports.php"> Reports</a>
                </div>
            <?php endif; ?>
            <?php if ($logged == true && $_SESSION['username']==='admin') : ?>
                <div id="logo">
                    <a href="admindashboard.php"> Admin Dashboard</a>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($logged == false) : ?>
            <div class="right_links">
                <div id="login">
                    <a href="login.php">Log In</a>
                </div>
                <div class="join">
                    <a href="signup.php">Join Now</a>
                </div>
            </div>
        <?php else : ?>
            <div class="right_links">
                <div class="join">
                    <a href="profile.php?id=<?php echo $_SESSION["username"]; ?>">Profile</a>
                </div>
                <div class="join">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <br/>
    <div class="container">
