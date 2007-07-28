<?php

class message extends simple
{
    [...]

    public function getAcl($name = null)
    {
        // у экшна 'delete' логика проверки авторизации будет така€ же
        if ($name == 'view' || $name == 'delete') {
            // получаем id получател€ сообщени€ (или отправител€, в случае с категорией 'sent'
            $user_id = ($this->getCategory()->getName() == 'sent') ? $this->getSender()->getId() : $this->getRecipient()->getId();
            // если id получател€/отправител€ == id текущего пользовател€ - доступ есть
            return $user_id == systemToolkit::getInstance()->getUser()->getId();
        }

        return parent::getAcl($name);
    }
}

?>