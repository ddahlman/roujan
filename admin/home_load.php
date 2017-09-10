<?php
include('../inc/admin_header.php');

?>

  <?php
$page = isset($_GET['page']) ? $_GET['page'] : "";

switch ($page) {
    case 'home':
        include_once("home.php");
        break;
    
    case 'about':
        include_once("about.php");
        break;
    
    case 'booking':
        include_once("booking.php");
        break;
    
    case 'contact':
        include_once("contact.php");
        break;
    
    default:
        include ('home.php');
        break;
}
?>

    <?php
include('../inc/admin_footer.php');
?>