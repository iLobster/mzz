<?php

class messageViewController extends simpleController
{
    public function getView()
    {
        $id = $this->request->get('id', 'integer'); // получаем id сообщения
        $messageMapper = $this->toolkit->getMapper('message', 'message'); // получаем маппер
        $message = $messageMapper->searchByKey($id); // получаем сообщение

        // если сообщение не найдено - показываем ошибку
        if (!$message) {
            return $messageMapper->get404()->run();
        }

        // если сообщение ещё не было просмотрено - устанавливаем флаг "просмотра" в 1
        if (!$message->getWatched()) {
            $message->setWatched(1);
            $messageMapper->save($message);
        }

        $category = $message->getCategory(); // получаем категорию сообщения
        $isSent = $category->getName() == 'sent';

        $messageCategoryMapper = $this->toolkit->getMapper('message', 'messageCategory'); // получаем маппер категорий
        $messageCategories = $messageCategoryMapper->searchAll(); // выбираем все категории
        
        // передаём данные в шаблон
        $this->smarty->assign('categories', $messageCategories);
        $this->smarty->assign('messageCategory', $category);
        $this->smarty->assign('isSent', $isSent);

        $this->smarty->assign('message', $message);

        return $this->smarty->fetch('message/view.tpl');
    }
}

?>