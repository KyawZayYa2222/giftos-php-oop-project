<?php

namespace App\Controller;

use App\Database\Connection;

class Product {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }


    // get paginate
    public function paginate(int $page = 1) {
        $limit = 8;
        $sql = "SELECT * FROM products";
        $totalRow = $this->GetQuery($sql)->num_rows;

        $totalPage = ceil($totalRow / $limit);

        $startRow = ($page - 1) * $limit;

        $sql = "SELECT * FROM products LIMIT $startRow, $limit";
        $result = $this->GetQuery($sql);

        $prevPage = $page - 1;
        $nextPage = $page + 1;

        // if($result->num_rows > 0) {
        //     $rows[] = $result->fetch_assoc();
        // }

        return [
            'current_page' => $page,
            'prev_page' => $prevPage,
            'next_page' => $nextPage,
            'total' => $totalRow,
            'total_page' => $totalPage,
            'start_row' => $startRow,
            'end_row' => $startRow + $limit,
            'rows' => $result->fetch_all(MYSQLI_ASSOC)
        ];
        // print_r($result->fetch_assoc());
    }

    
    private function GetQuery($sql) {
        $result = $this->connect->query($sql);

        return $result;
    }

}