<?php

class userMapper extends simpleMapper
{
    [...]
    /**
     * ��������� ����� ������� �� ������
     *
     * @param string $login �����
     * @return object
     */
    public function searchByLogin($login)
    {
        return $this->searchOneByField('login', $login);
    }
}

?>