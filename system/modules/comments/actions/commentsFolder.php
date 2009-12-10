<?php
//commentsFolder actions config

return array(
    'list' => array(
        'controller' => 'folderList',
        'main' => 'deny'
    ),
    'post' => array(
        'controller' => 'post',
        'title' => 'Comment post'
    )
);
?>