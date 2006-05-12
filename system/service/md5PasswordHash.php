<?php
//
// $Id$
// $URL$
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

fileLoader::load('service/passwordHash');

/**
 * md5PasswordHash: класс для шифрования пароля в md5
 *
 * @package system
 * @version 0.1
 */
class md5PasswordHash extends PasswordHash
{
    /**
     * Применение хэширования
     *
     * @param string $value значение пароля
     * @return string результат применения хэширования к $value
     */
    public function apply($value)
    {
        return md5($value);
    }
}
?>