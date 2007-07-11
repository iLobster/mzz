<?php
    
    $user = $userMapper->searchByLogin('editor');       // получаем пользователя 'editor'
    $news = $newsMapper->searchById(100);               // получаем новость с id = 100 (obj_id этой новости примем также равным 100)
    
    $acl = new acl($user, $news->getObjId());
    $access = array('edit' => false, 'view' => false);
    $acl->set($access);                                 // будут установлены запрещающие права для пользователя 'editor'
    $acl->set('view', true);                            // будет разрешён просмотр новости
    
    $group = $groupMapper->searchByName('banned');
    $acl->set('view', true, $group->getId());           // для группы 'banned' будет разрешён просмотр новости
                                                        //(однако в результате всё равно никто из этой группы просмотреть эту новость не сможет, см. тезис 3)

?>