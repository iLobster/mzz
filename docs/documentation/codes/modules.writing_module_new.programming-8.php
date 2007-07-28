<?php

class messageDeleteController extends simpleController
{
    public function getView()
    {
        // �������� id ���������� ��������� � ���� ���������
        $id = $this->request->get('id', 'integer');
        $messageMapper = $this->toolkit->getMapper('message', 'message');
        $message = $messageMapper->searchByKey($id);

        // ���� ��������� �� ������� - ���������� ������
        if (!$message) {
            return $messageMapper->get404()->run();
        }

        // ���� ��������� ��������� �� � ��������� "��������" - ���������� ��� ����
        if ($message->getCategory()->getName() != 'recycle') {
            $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');
            $recycle = $messageCategoryMapper->searchOneByField('name', 'recycle');
            $message->setCategory($recycle);
            $messageMapper->save($message);
        } else {
            // ���� ��� � "��������" - ����� ������� ������������
            $messageMapper->delete($message->getId());
        }

        // ��������� jip-����
        return jipTools::redirect();
    }
}

?>