<?php

class messageListController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string'); // �������� ��� ���������
        $isSent = $name == 'sent';

        $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory'); // �������� ������
        $messageCategory = $messageCategoryMapper->searchOneByField('name', $name); // ���� ���������

        if (empty($messageCategory)) { // ���� �� ����� - ���������� 404 ������
            return $messageCategoryMapper->get404()->run();
        }

        $me = $this->toolkit->getUser(); // �������� �������� ������������

        $messageMapper = $this->toolkit->getMapper('message', 'message'); // �������� ������
        $criteria = new criteria(); // ���������� �������� ������
        $criteria->add('category_id', $messageCategory->getId()); // ��������� �� ������� ���������
        $criteria->add($isSent ? 'sender' : 'recipient', $me->getId()); // ��� �������� ������������ (���� ��������� "���������", �� ������� ������������ �������� ������������)
        $messages = $messageMapper->searchAllByCriteria($criteria); // ���� ��� ���������

        $messageCategories = $messageCategoryMapper->searchAll(); // ���� ��� ���������

        // ������� ���������� ������ � ������
        $this->smarty->assign('messages', $messages);
        $this->smarty->assign('isSent', $isSent);
        $this->smarty->assign('categories', $messageCategories);
        $this->smarty->assign('messageCategory', $messageCategory);
        return $this->smarty->fetch('message/list.tpl');
    }
}

?>