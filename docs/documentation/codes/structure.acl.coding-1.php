<?php
    
    $user = $userMapper->searchByLogin('editor');       // получаем пользователя 'editor'
    $news = $newsMapper->searchById(100);               // получаем новость с id = 100 (obj_id этой новости примем также равным 100)
    
    $acl = new acl($user, $news->getObjId());
    
    $access = $acl->get();                              // будет возвращён массив array('edit' => true, 'view' => true);
    $access = $acl->get('view');                        // true
    
    $user2 = $userMapper->searchByLogin('visitor');     // получаем пользователя 'visitor'
    $acl = new acl($user2, $news->getObjId());
    
    $access = $acl->get();                              // будет возвращён массив array('edit' => false, 'view' => true);
    $access = $acl->get('view');                        // true
    $access = $acl->get('edit');                        // false
    
    $user3 = $userMapper->searchByLogin('hacker');      // получаем пользователя 'hacker'
    $acl = new acl($user3, $news->getObjId());
    
    $access = $acl->get();                              // будет возвращён массив array('edit' => false, 'view' => false);
    $access = $acl->get('view');                        // false
    $access = $acl->get('edit');                        // false
    
?>