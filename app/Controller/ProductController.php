<?php

namespace App\Controller;

use App\Database\Connection;
use App\Helper\Paginator;

class ProductController {
    private $connect;

    function __construct() {
        $connection = new Connection();
        $this->connect = $connection->connect();
    }


    // get paginate
    public function get(int $page = 1) {
        // $limit = 8;
        // $sql = "SELECT * FROM products";
        // $totalRow = $this->GetQuery($sql)->num_rows;

        // $totalPage = ceil($totalRow / $limit);

        // $startRow = ($page - 1) * $limit;

        // $sql = "SELECT * FROM products LIMIT $startRow, $limit";
        // $result = $this->GetQuery($sql);

        // $prevPage = $page - 1;
        // $nextPage = $page + 1;

        // return [
        //     'current_page' => $page,
        //     'prev_page' => $prevPage,
        //     'next_page' => $nextPage,
        //     'total' => $totalRow,
        //     'total_page' => $totalPage,
        //     'start_row' => $startRow,
        //     'end_row' => $startRow + $limit,
        //     'rows' => $result->fetch_all(MYSQLI_ASSOC)
        // ];

        $limit = 8;
        $tableName = "products";

        try {
            $data = Paginator::paginate($this->connect, $tableName, $limit, $page);
            return $data;
        } catch(Exception $err) {
            echo "<div class='err-exception-con'>$err</div>";
        }
    }

    
    private function GetQuery($sql) {
        $result = $this->connect->query($sql);

        return $result;
    }

}