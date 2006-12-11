<?php

class userMapper extends simpleMapper
{
    [...]
    /**
     * Выполняет поиск объекта по логину
     *
     * @param string $login логин
     * @return object
     */
    public function searchByLogin($login)
    {
        return $this->searchOneByField('login', $login);
    }
}

?>