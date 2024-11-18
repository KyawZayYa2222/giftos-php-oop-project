<?php

namespace App\Helper;

class ThrowError {
    public static function error($err) {
        die("
            <div class='err-exception-con'>
                <h3>Internal Error</h3>
                <p>Error: ". $err ."</p>
            </div>
        ");
    }
}
