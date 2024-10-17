<?php

namespace App\Helper;

use App\Database\Connection;


class Paginator {
    // public static $connect;

    // function __construct() {
    //     $connection = new Connection();
    //     self::$connect = $connection->connect();
    // }


    public static function paginate($connect, $table_name, int $limit, int $page = 1) {
        // echo 'hello';
        // print_r(self::$connect);
        $sql = "SELECT * FROM $table_name";
        $totalRow = $connect->query($sql)->num_rows;

        $totalPage = ceil($totalRow / $limit);

        $startRow = ($page - 1) * $limit;

        $sql = "SELECT * FROM $table_name LIMIT $startRow, $limit";
        $result = $connect->query($sql);

        $prevPage = $page - 1;
        $nextPage = $page + 1;

        return [
            'current_page' => $page,
            'prev_page' => $prevPage,
            'next_page' => $nextPage,
            'total' => $totalRow,
            'total_page' => $totalPage,
            'start_row' => $startRow,
            'end_row' => $startRow + $limit,
            'data' => $result->fetch_all(MYSQLI_ASSOC)
        ];
    }

    // private function GetQuery($sql) {
    //     $result = $this->connect->query($sql);

    //     return $result;
    // }


    // function __destruct() {
    //     if(self::$connect) {
    //         self::$connect->close();
    //     }
    // }
}