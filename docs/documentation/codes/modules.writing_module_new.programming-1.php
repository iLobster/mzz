<?php

class messageListController extends simpleController
{
    public function getView()
    {
        $name = $this->request->get('name', 'string'); // получаем имя категории
        $isSent = $name == 'sent';

        $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory'); // получаем маппер
        $messageCategory = $messageCategoryMapper->searchOneByField('name', $name); // ищем категорию

        if (empty($messageCategory)) { // если не нашли - отображаем 404 ошибку
            return $messageCategoryMapper->get404()->run();
        }

        $me = $this->toolkit->getUser(); // получаем текущего пользователя

        $messageMapper = $this->toolkit->getMapper('message', 'message'); // получаем маппер
        $criteria = new criteria(); // составляем критерий поиска
        $criteria->add('category_id', $messageCategory->getId()); // сообщения из текущей категории
        $criteria->add($isSent ? 'sender' : 'recipient', $me->getId()); // для текущего пользователя (если категория "исходящие", то текущий пользователь является отправителем)
        $messages = $messageMapper->searchAllByCriteria($criteria); // ищем все сообщения

        $messageCategories = $messageCategoryMapper->searchAll(); // ищем все категории

        // передаём полученные данные в шаблон
        $this->smarty->assign('messages', $messages);
        $this->smarty->assign('isSent', $isSent);
        $this->smarty->assign('categories', $messageCategories);
        $this->smarty->assign('messageCategory', $messageCategory);
        return $this->smarty->fetch('message/list.tpl');
    }
}

?>