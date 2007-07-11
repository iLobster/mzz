<?php

class news404Controller extends simpleController
{
    protected function getView()
    {
        $this->response->setTitle('Ошибка. Запрашиваемая новость не найдена.');
        return $this->smarty->fetch('news/notfound.tpl');
    }
}

?>