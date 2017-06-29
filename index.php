<?php
include_once('./inc/header.php');
$page = isset($_GET['page']) ? $_GET['page'] : "";

switch ($page) {
    case 'home':
        include_once('home.php');
        break;
    
    case 'booking':
        include_once('booking.php');
        break;
    
    case 'about':
        include_once('about.php');
        break;
    
    case 'contact':
        include_once('contact.php');
        break;
    
    default:
        include_once('home.php');
        break;
}

include_once('./inc/footer.php');
?>