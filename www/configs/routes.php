<?php
$toolkit = systemToolkit::getInstance();

$router = $toolkit->getRouter($request);
$router->addRoute('default', new requestRoute('', array('section' => 'news', 'action' => 'list')));
$router->addRoute('element', new requestRoute(':section/:id/:action'));
$router->addRoute('list', new requestRoute(':section/:action'));

$router->route($request->get('path', 'mixed', SC_REQUEST));
?>
