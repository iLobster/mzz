<?php

class message extends simple
{
    [...]

    public function getAcl($name = null)
    {
        // у экшна 'delete' логика проверки авторизации будет такая же
        if ($name == 'view' || $name == 'delete') {
            // получаем id получателя сообщения (или отправителя, в случае с категорией 'sent'
            $user_id = ($this->getCategory()->getName() == 'sent') ? $this->getSender()->getId() : $this->getRecipient()->getId();
            // если id получателя/отправителя == id текущего пользователя - доступ есть
            return $user_id == systemToolkit::getInstance()->getUser()->getId();
        }

        return parent::getAcl($name);
    }
}

?>