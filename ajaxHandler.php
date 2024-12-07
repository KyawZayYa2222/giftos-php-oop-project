<?php
require_once './vendor/autoload.php';

use App\Controller\CartController;
use App\Controller\ContactController;

$cartController = new CartController();
$contactController = new ContactController();

// add to cart ajax requests 
if($_POST['controller'] == 'addToCart') {
    switch ($_POST['action']) {
        case 'add':
            $response = $cartController->add($_POST);
            break;
        
        case 'reduce':
            $response = $cartController->reduce($_POST);
            break;
            
        case 'remove':
            $response = $cartController->remove($_POST);
            break;
            
        default:
            $response = "invalid action";
            break;
    }
}


// contact ajax request 
if($_POST['controller'] == 'contact') {
    if($_POST['action'] == 'markAsRead') {
        $response = $contactController->markAsRead($_POST['id']);
    }
}


// json response 
echo json_encode($response);