<?php

class messageDeleteController extends simpleController
{
    public function getView()
    {
        // получаем id удаляемого сообщения и само сообщение
        $id = $this->request->get('id', 'integer');
        $messageMapper = $this->toolkit->getMapper('message', 'message');
        $message = $messageMapper->searchByKey($id);

        // если сообщение не найдено - показываем ошибку
        if (!$message) {
            return $messageMapper->get404()->run();
        }

        // определяем категорию и право на удаление сообщения
        $category = $message->getCategory();
        $isSent = $category->getName() == 'sent';

        $me = $this->toolkit->getUser();
        $user_id = $isSent ? $message->getSender()->getId() : $message->getRecipient()->getId();

        // если права нет (текущий пользователь не является получателем, или отправителем - в случае категории 'sent') - показываем ошибку
        if ($user_id != $me->getId()) {
            fileLoader::load('simple/simple403Controller');
            $controller = new simple403Controller();
            return $controller->run();
        }

        // если сообщение находится не в категории "удалённые" - перемещаем его туда
        if ($message->getCategory()->getName() != 'recycle') {
            $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory');
            $recycle = $messageCategoryMapper->searchOneByField('name', 'recycle');
            $message->setCategory($recycle);
            $messageMapper->save($message);
        } else {
            // если уже в "удалённых" - тогда удаляем окончательно
            $messageMapper->delete($message->getId());
        }

        // закрываем jip-окно
        return jipTools::redirect();
    }
}

?>