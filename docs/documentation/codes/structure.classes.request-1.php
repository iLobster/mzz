<?php
// Правило маршрутизации: :section/:action
// URL: http://example.com/demo/view?show_execute_time=1
$request->getString('section'); // demo
$request->getString('action', SC_PATH); // view
$request->getBoolean('action', SC_PATH); // true
$request->getBoolean('show_execute_time', SC_GET); // true
?>