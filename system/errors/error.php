<?php
function _error($msg) {
    $error = "<div style='border: 1px solid black; padding: 3px; background-color: #F0F0F0'><b>".$msg."</b>";
    $error .= "<br>".print_r(debug_backtrace(),1)."</div>";
}
?>