<?php
    
    $user = $userMapper->searchByLogin('editor');       // �������� ������������ 'editor'
    $news = $newsMapper->searchById(100);               // �������� ������� � id = 100 (obj_id ���� ������� ������ ����� ������ 100)
    
    $acl = new acl($user, $news->getObjId());
    
    $access = $acl->get();                              // ����� ��������� ������ array('edit' => true, 'view' => true);
    $access = $acl->get('view');                        // true
    
    $user2 = $userMapper->searchByLogin('visitor');     // �������� ������������ 'visitor'
    $acl = new acl($user2, $news->getObjId());
    
    $access = $acl->get();                              // ����� ��������� ������ array('edit' => false, 'view' => true);
    $access = $acl->get('view');                        // true
    $access = $acl->get('edit');                        // false
    
    $user3 = $userMapper->searchByLogin('hacker');      // �������� ������������ 'hacker'
    $acl = new acl($user3, $news->getObjId());
    
    $access = $acl->get();                              // ����� ��������� ������ array('edit' => false, 'view' => false);
    $access = $acl->get('view');                        // false
    $access = $acl->get('edit');                        // false
    
?>