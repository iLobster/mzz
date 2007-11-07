<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU Lesser General Public License (See /docs/LGPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

fileLoader::load('forms/validators/formValidator');

/**
 * messageSendController: контроллер для метода send модуля message
 *
 * @package modules
 * @subpackage message
 * @version 0.1
 */

class messageSendController extends simpleController
{
    public function getView()
    {
        $me = $this->toolkit->getUser();

        $recipient = $this->request->get('name', 'string');

        $userMapper = $this->toolkit->getMapper('user', 'user', 'user');
        $recipient_user = $userMapper->searchByLogin($recipient);
        if ($recipient && !$recipient_user) {
            $controller = new messageController('Получателя не существует', messageController::WARNING);
            return $controller->run();
        }

        $criteria = new criteria();
        $criteria->add('id', MZZ_USER_GUEST_ID, criteria::NOT_EQUAL);
        $criteria->setOrderByFieldAsc('login');
        $users = $userMapper->searchAllByCriteria($criteria);
        $usersArray = array();
        foreach ($users as $user) {
            $usersArray[$user->getId()] = $user->getLogin();
        }
        unset($usersArray[$me->getId()]);

        $validator = new formValidator();
        $validator->add('required', 'message[title]', 'Необходимо указать тему сообщения');
        $validator->add('required', 'message[text]', 'Необходимо указать текст сообщения');
        $validator->add('required', 'message[recipient]', 'Необходимо указать получателя сообщения');
        $validator->add('callback', 'message[recipient]', 'Пользователь не найден', array('checkRecipient', $usersArray));
        $validator->add('required', 'captcha', 'Введите текст, изображенный на картинке');
        $validator->add('captcha', 'captcha', 'Неверный текст');

        if ($validator->validate()) {
            $msg = $this->request->get('message', 'array', SC_POST);

            $messageMapper = $this->toolkit->getMapper('message', 'message');
            $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');

            $incoming = $messageCategoryMapper->searchOneByField('name', 'incoming');
            $sent = $messageCategoryMapper->searchOneByField('name', 'sent');

            $message = $messageMapper->create();
            $message->setTitle($msg['title']);
            $message->setText($msg['text']);
            $message->setRecipient($msg['recipient']);
            $message->setSender($me);
            $message->setWatched(0);
            $message->setCategory($incoming);

            $messageSent = $messageMapper->create();
            $messageSent->setTitle($msg['title']);
            $messageSent->setText($msg['text']);
            $messageSent->setRecipient($msg['recipient']);
            $messageSent->setSender($me);
            $messageSent->setWatched(1);
            $messageSent->setCategory($sent);

            $messageMapper->save($message);
            $messageMapper->save($messageSent);

            return jipTools::redirect();
        }

        if ($recipient) {
            $url = new url('withAnyParam');
            $url->add('name', $recipient);
        } else {
            $url = new url('default2');
        }
        $url->setSection('message');
        $url->setAction('send');

        $this->smarty->assign('recipient', $recipient_user->getId());
        $this->smarty->assign('action', $url->get());
        $this->smarty->assign('errors', $validator->getErrors());
        $this->smarty->assign('users', $usersArray);
        return $this->smarty->fetch('message/send.tpl');
    }
}

function checkRecipient($user_id, $users)
{
    return isset($users[$user_id]);
}

?>