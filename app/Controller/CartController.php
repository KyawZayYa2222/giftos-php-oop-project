<?php
namespace App\Controller;

class CartController {
    function __construct() {
        session_start();
    }


    // add to cart 
    public function add($request) {
        $id = $request['id'];
        $carts = isset($_SESSION['carts']) ? $_SESSION['carts'] : [];

        $existCarts = array_filter($carts, function($cart) use($id) {
            return $cart['id'] == $id;
        });

        if(empty($carts) || empty($existCarts)) {
            array_push($carts, [
                'id' => $id,
                'qty' => 1
            ]);
        } else {
            $carts = array_map(function($cart) use($id) {
                if($cart['id'] == $id) {
                    $cart['qty'] += 1;
                    return $cart;
                } else {
                    return $cart;
                }
            }, $carts);
        }
        $_SESSION['carts'] = $carts;

        return $carts;
    }
}