<?php
namespace App\Controller;

use App\Controller\ProductController;

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

        // get item details 
        $productController = new ProductController();
        $product = $productController->find($id)->fetch_assoc();
        // return $product;

        if(empty($carts) || empty($existCarts)) {
            $product['cart_qty'] = 1;
            array_push($carts, $product);
        } else {
            $carts = array_map(function($cart) use($id) {
                if($cart['id'] == $id) {
                    $cart['cart_qty'] += 1;
                }
                return $cart;
            }, $carts);
        }
        $_SESSION['carts'] = $carts;

        return $carts;
    }


    // reduce cart qty
    public function reduce($request) {
        $id = $request['id'];
        $carts = isset($_SESSION['carts'])? $_SESSION['carts'] : [];

        $carts = array_map(function($cart) use($id) {
            if($cart['id'] == $id && $cart['qty'] > 1) {
                $cart['cart_qty'] -= 1;
            }
            return $cart;
        }, $carts);

        $_SESSION['carts'] = $carts;

        return $carts;
    }    

    // get carts 
    public function get() {
        $carts = isset($_SESSION['carts'])? $_SESSION['carts'] : [];
        $productController = new ProductController();

        $carts = array_map(function($cart) use($productController) {
            $product = $productController->find($cart['id'])->fetch_assoc();
            $product['cart_qty'] = $cart['qty'];
            return $product;
        }, $carts);

        return $carts;
    }

    // remove cart
    public function remove($request) {
        $id = $request['id'];
        $carts = isset($_SESSION['carts'])? $_SESSION['carts'] : [];

        $carts = array_filter($carts, function($cart) use($id) {
            return $cart['id']!= $id;
        });

        $_SESSION['carts'] = $carts;

        return $carts;
    }
}