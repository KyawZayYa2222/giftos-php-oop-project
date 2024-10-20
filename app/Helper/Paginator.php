<?php

namespace App\Helper;

use App\Database\Connection;


class Paginator {
    public static $currentPage, $prevPage, $nextPage, $totalPage, $totalRow, $startRow, $endRow, $total;

    public static function paginate($connect, $sql, int $limit, int $page = 1) {
        self::$totalRow = $connect->query($sql)->num_rows;

        self::$totalPage = ceil(self::$totalRow / $limit);

        // Handle invalid page 
        $page = $page > self::$totalPage ? self::$totalPage : $page;
        $page = $page < 1 ? 1 : $page;

        $startRow = ($page - 1) * $limit;

        $sql .= " LIMIT $startRow, $limit";
        $result = $connect->query($sql);

        self::$prevPage = $page - 1;
        self::$nextPage = $page + 1;
        self::$currentPage = $page;
        self::$startRow = $startRow + 1;
        self::$endRow = ($page * $limit) <= self::$totalRow ? ($page * $limit) : self::$totalRow;

        return [
            'current_page' => self::$currentPage,
            'prev_page' => self::$prevPage,
            'next_page' => self::$nextPage,
            'total' => self::$totalRow,
            'total_page' => self::$totalPage,
            'start_row' => self::$startRow,
            'end_row' => self::$endRow,
            'data' => $result->fetch_all(MYSQLI_ASSOC),
            'link' => self::link()
        ];
    }


    private static function link() {
        $baseUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $pagination = '';
        $pagination .= "<div class='row p-0 m-0'>
                <div class='col-sm-12 col-md-5'>
                    <div class='dataTables_info' id='dataTable_info' role='status' aria-live='polite'>
                        Showing ".self::$startRow." to ".self::$endRow." of ".self::$totalRow." entries
                    </div>
                </div>
                <div class='col-sm-12 col-md-7'>
                    <div class='dataTables_paginate paging_simple_numbers' id='dataTable_paginate'>
                        <ul class='pagination text-right'>";


        if(self::$totalPage > 1) {
            $pageLink = '';
            $prevDisable = 'disabled';
            $nextDisable = 'disabled';

            // prev page link 
        if(self::$prevPage > 0) {
            $prevDisable = '';
        }
        $pagination .= "<li class='paginate_button page-item previous $prevDisable' id='dataTable_previous'>
                            <a href='$baseUrl?page=".self::$prevPage."' aria-controls='dataTable' data-dt-idx='0' tabindex='0' class='page-link'>Previous</a>
                        </li>";

        // page links 
            for ($page=1; $page<=self::$totalPage; $page++) {
                if(self::$currentPage === $page) {
                    $pageActive = 'active';
                } else {
                    $pageActive = '';
                }
                $pageLink .= "<li class='paginate_button page-item $pageActive'>
                                            <a href='$baseUrl?page=$page' aria-controls='dataTable' data-dt-idx='2' tabindex='0' class='page-link'>$page</a>
                                        </li>";
            }
            $pagination .= $pageLink;
            

            // next page link 
        if(self::$nextPage <= self::$totalPage) {
            $nextDisable = '';
        }
        $pagination .= "<li class='paginate_button page-item next $nextDisable' id='dataTable_next'>
                            <a href='$baseUrl?page=".self::$nextPage."' aria-controls='dataTable' data-dt-idx='7' tabindex='0' class='page-link'>Next</a>
                        </li>";


            $pagination .= "</ul>
                                </div>
                            </div>
                        </div>";
        }

        return $pagination;
    }
}