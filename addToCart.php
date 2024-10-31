<?php
require_once './vendor/autoload.php';

use App\Controller\CartController;

$cartController = new CartController();

switch ($_POST['action']) {
    case 'add':
        $response = $cartController->add($_POST);
        break;
    
    case 'minus':
        $response = $cartController->minus($_POST);
        break;
        
    case 'remove':
        $response = $cartController->remove($_POST);
        break;
        
    default:
        $response = "invalid action";
        break;

}

echo json_encode($response);