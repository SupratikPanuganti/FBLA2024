<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if((isset($_SESSION['profile']) && $_SESSION['profile'] == false) && (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)){
    header('Location: profile.php');
    exit();
}
else {
}
?>
<?php include("header.php"); ?>

<h2><center>Connecting Forsyth: Discover. Connect. Thrive.</center></h2> 
<div class="header">
    <img src="fbla2024logo.jpg" alt="FBLA 2024 Logo" width="100px" height="100px">
    <h1>Pillars of Forsyth</h1>
    <p>Discover Local Business and Community Partners</p>  
</div>

<h2>About Us</h2>

<p>At Pillars of Forsyth, we are dedicated to connecting you with the heartbeat of our community. Our platform serves as a gateway to essential information about local businesses and community partners, fostering meaningful connections that drive growth and collaboration.</p>

<h2>Our Services</h2>

<div class="services">
    <div class="service">
        <h3>Explore Local Businesses</h3>  
        <p>Navigate through a diverse array of local businesses ranging from boutiques to professional services. Discover what makes our community unique and vibrant.</p>
    </div>

    <div class="service">
        <h3>Connect with Community Partners</h3>
        <p>Engage with organizations and community partners committed to making Forsyth thrive. From non-profits to civic groups, find those aligned with your values.</p>
    </div>

    <div class="service">
        <h3>Events and Activities</h3>
        <p>Stay informed about the latest events and activities happening in Forsyth. Whether it's a local festival, a workshop, or a community gathering, find opportunities to connect and participate.</p>
    </div>
</div>

<h2>Why Choose Us?</h2> 

<p>We provide:</p>

<ul>
    <li>Comprehensive Information</li>  
    <li>Seamless Connectivity</li>
    <li>Community-Centric Approach</li>  
</ul>

<p>Discover the pillars of our community today. Whether you're a resident, a business owner, or someone passionate about community engagement, Pillars of Forsyth is your go-to resource.</p>
</div>
<?php include("footer.html"); ?>
