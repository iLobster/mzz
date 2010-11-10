<?php
//errorPage actions config

return array (
    'error404' => 
    array (
        'controller' => '404',
        'main' => 'deny',
        'crud_class' => 'errorPage',
    ),
    'error403' => 
    array (
        'controller' => '403',
        'main' => 'deny',
        'crud_class' => 'errorPage',
    ),
);
?>