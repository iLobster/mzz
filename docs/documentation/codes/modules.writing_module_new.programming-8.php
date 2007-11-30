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