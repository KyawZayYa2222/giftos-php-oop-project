<?php
require_once './vendor/autoload.php';

use App\Controller\CartController;

$cartController = new CartController();

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

echo json_encode($response);