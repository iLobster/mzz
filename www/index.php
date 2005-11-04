<?php
require_once './config.php';
require_once SYSTEM . 'index.php';
require_once SYSTEM . '/core/request/httprequest.php';
$_POST['z'] = 'bla';
echo '<br>';
var_dump(HttpRequest::get('z', SC_GET));
?>