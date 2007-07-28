<?php

class messageViewController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer'); // �������� id ���������
        $messageMapper = $this->toolkit->getMapper('message', 'message'); // �������� ������
        $message = $messageMapper->searchByKey($id); // �������� ���������

        // ���� ��������� �� ������� - ���������� ������
        if (!$message) {
            return $messageMapper->get404()->run();
        }

        // ���� ��������� ��� �� ���� ����������� - ������������� ���� "���������" � 1
        if (!$message->getWatched()) {
            $message->setWatched(1);
            $messageMapper->save($message);
        }

        $category = $message->getCategory(); // �������� ��������� ���������
        $isSent = $category->getName() == 'sent';

        $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory'); // �������� ������ ���������
        $messageCategories = $messageCategoryMapper->searchAll(); // �������� ��� ���������
        
        // ������� ������ � ������
        $this->smarty->assign('categories', $messageCategories);
        $this->smarty->assign('messageCategory', $category);
        $this->smarty->assign('isSent', $isSent);

        $this->smarty->assign('message', $message);

        return $this->smarty->fetch('message/view.tpl');
    }
}

?>