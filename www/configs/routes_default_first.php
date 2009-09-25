<?php

$router->addRoute('withId', new requestRoute(':module/:id/:action', array('action' => 'view'), array('id' => '\d+')));

?>