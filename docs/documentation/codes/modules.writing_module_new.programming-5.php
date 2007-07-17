<?php

class messageSendController extends simpleController
{
    public function getView()
    {
        // �������� �������� ������������
        $me = $this->toolkit->getUser();

        // �� ������� - �������� ��� ����������
        $recipient = $this->request->get('name', 'string');

        // ���� ����������
        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $recipient_user = $userMapper->searchByLogin($recipient);
        // ���� ���������� ��� ������ � ����, �� ������ ������������ �� ���������� - ���������� ������
        if ($recipient && !$recipient_user) {
            $controller = new messageController('���������� �� ����������', messageController::WARNING);
            return $controller->run();
        }

        // ���� �������������, ������� ����� ��������� ��������� (���, ����� �������� ������������ � �����)
        $criteria = new criteria();
        $criteria->add('id', MZZ_USER_GUEST_ID, criteria::NOT_EQUAL);
        $criteria->setOrderByFieldAsc('login');
        $users = $userMapper->searchAllByCriteria($criteria);
        $usersArray = array();
        foreach ($users as $user) {
            $usersArray[$user->getId()] = $user->getLogin();
        }
        unset($usersArray[$me->getId()]);

        // ���������� ��������� ��� �����
        $validator = new formValidator();
        $validator->add('required', 'message[title]', '���������� ������� ���� ���������');
        $validator->add('required', 'message[text]', '���������� ������� ����� ���������');
        $validator->add('required', 'message[recipient]', '���������� ������� ���������� ���������');
        $validator->add('callback', 'message[recipient]', '������������ �� ������', array('checkRecipient', $usersArray));

        // ���������� �����
        if ($validator->validate()) {
            // �������� ������ ���������
            $msg = $this->request->get('message', 'array', SC_POST);

            // �������� ����������� �������
            $messageMapper = $this->toolkit->getMapper('message', 'message');
            $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');

            // ���� ��������� ��������� ��� ������������� � ��������� ���������
            $incoming = $messageCategoryMapper->searchOneByField('name', 'incoming');
            $sent = $messageCategoryMapper->searchOneByField('name', 'sent');

            // ���������� ���������, ������� ����� ���������� ������������
            $message = $messageMapper->create();
            $message->setTitle($msg['title']);
            $message->setText($msg['text']);
            $message->setRecipient($msg['recipient']);
            $message->setSender($me);
            $message->setWatched(0);
            $message->setCategory($incoming);

            // ������ �����, �������� � � "������������"
            $messageSent = $messageMapper->create();
            $messageSent->setTitle($msg['title']);
            $messageSent->setText($msg['text']);
            $messageSent->setRecipient($msg['recipient']);
            $messageSent->setSender($me);
            $messageSent->setWatched(1);
            $messageSent->setCategory($sent);

            // ��������� ��� ���������
            $messageMapper->save($message);
            $messageMapper->save($messageSent);

            // ��������� jip-����
            return jipTools::redirect();
        }

        // ���������� ���
        if ($recipient) {
            // ���� ������������ ��� ������, �� ��� ����� ����: site/message/USERNAME/send
            $url = new url('withAnyParam');
            $url->addParam('name', $recipient);
        } else {
            // �����: site/message/send
            $url = new url('default2');
        }
        $url->setSection('message');
        $url->setAction('send');

        // ������� � ������ ������
        $this->smarty->assign('recipient', $recipient_user->getId());
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('users', $usersArray);
        return $this->smarty->fetch('message/send.tpl');
    }
}

// �������-���������, ����������� ��� ��������� ������������ ����� �������� ����������� ���������
function checkRecipient($user_id, $users)
{
    return isset($users[$user_id]);
}

?>