<?php
    
    $user = $userMapper->searchByLogin('editor');       // �������� ������������ 'editor'
    $news = $newsMapper->searchById(100);               // �������� ������� � id = 100 (obj_id ���� ������� ������ ����� ������ 100)
    
    $acl = new acl($user, $news->getObjId());
    $access = array('edit' => false, 'view' => false);
    $acl->set($access);                                 // ����� ����������� ����������� ����� ��� ������������ 'editor'
    $acl->set('view', true);                            // ����� �������� �������� �������
    
    $group = $groupMapper->searchByName('banned');
    $acl->set('view', true, $group->getId());           // ��� ������ 'banned' ����� �������� �������� �������
                                                        //(������ � ���������� �� ����� ����� �� ���� ������ ����������� ��� ������� �� ������, ��. ����� 3)

?>