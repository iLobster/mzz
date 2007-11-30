<?php

class messageSendController extends simpleController
{
    public function getView()
    {
        // получаем текущего пользователя
        $me = $this->toolkit->getUser();

        // из запроса - получаем имя получателя
        $recipient = $this->request->get('name', 'string');

        // ищем получателя
        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $recipient_user = $userMapper->searchByLogin($recipient);
        // если получатель был указан в УРЛе, но такого пользователя не существует - показываем ошибку
        if ($recipient && !$recipient_user) {
            $controller = new messageController('Получателя не существует', messageController::WARNING);
            return $controller->run();
        }

        // ищем пользователей, которым можно отправить сообщение (все, кроме текущего пользователя и гостя)
        $criteria = new criteria();
        $criteria->add('id', MZZ_USER_GUEST_ID, criteria::NOT_EQUAL);
        $criteria->setOrderByFieldAsc('login');
        $users = $userMapper->searchAllByCriteria($criteria);
        $usersArray = array();
        foreach ($users as $user) {
            $usersArray[$user->getId()] = $user->getLogin();
        }
        unset($usersArray[$me->getId()]);

        // составляем валидатор для формы
        $validator = new formValidator();
        $validator->add('required', 'message[title]', 'Необходимо указать тему сообщения');
        $validator->add('required', 'message[text]', 'Необходимо указать текст сообщения');
        $validator->add('required', 'message[recipient]', 'Необходимо указать получателя сообщения');
        $validator->add('callback', 'message[recipient]', 'Пользователь не найден', array('checkRecipient', $usersArray));

        // валидируем форму
        if ($validator->validate()) {
            // получаем данные сообщения
            $msg = $this->request->get('message', 'array', SC_POST);

            // получаем необходимые мапперы
            $messageMapper = $this->toolkit->getMapper('message', 'message');
            $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');

            // ищем категории сообщений для отправленного и входящего сообщений
            $incoming = $messageCategoryMapper->searchOneByField('name', 'incoming');
            $sent = $messageCategoryMapper->searchOneByField('name', 'sent');

            // составляем сообщение, которое будет отправлено пользователю
            $message = $messageMapper->create();
            $message->setTitle($msg['title']);
            $message->setText($msg['text']);
            $message->setRecipient($msg['recipient']);
            $message->setSender($me);
            $message->setWatched(0);
            $message->setCategory($incoming);

            // делаем копию, помещаем её в "отправленные"
            $messageSent = $messageMapper->create();
            $messageSent->setTitle($msg['title']);
            $messageSent->setText($msg['text']);
            $messageSent->setRecipient($msg['recipient']);
            $messageSent->setSender($me);
            $messageSent->setWatched(1);
            $messageSent->setCategory($sent);

            // сохраняем оба сообщения
            $messageMapper->save($message);
            $messageMapper->save($messageSent);

            // закрываем jip-окно
            return jipTools::redirect();
        }

        // генерируем урл
        if ($recipient) {
            // если пользователь был указан, то урл будет вида: site/message/USERNAME/send
            $url = new url('withAnyParam');
            $url->add('name', $recipient);
        } else {
            // иначе: site/message/send
            $url = new url('default2');
        }
        $url->setSection('message');
        $url->setAction('send');

        // передаём в шаблон данные
        $this->smarty->assign('recipient', $recipient_user->getId());
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('users', $usersArray);
        return $this->smarty->fetch('message/send.tpl');
    }
}

// функция-валидатор, проверяющая что выбранный пользователь может являться получателем сообщения
function checkRecipient($user_id, $users)
{
    return isset($users[$user_id]);
}

?>
