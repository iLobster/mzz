<?php
//commentsFolder actions config

return array(
    'list' => array(
        'controller' => 'folderList',
        '403handle' => 'none',
        'main' => 'deny',
    ),
    'post' => array(
        'controller' => 'post',
        'title' => 'Comment post',
        '403handle' => 'none',
    ),
    'deleteFolder' => array(
        'controller' => 'folderDeleteFolder',
    ),
);
?>