<?php
// Правило маршрутизации: :section/:action
// URL: http://example.com/demo/view?show_execute_time=1
$request->get('section', 'string', SC_PATH); // demo
$request->get('action', 'string', SC_PATH); // view
$request->get('show_execute_time', 'boolean', SC_GET); // true
?>