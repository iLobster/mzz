<?php
/**
 * $URL: http://svn.web/repository/mzz/system/service/sha1PasswordHash.php $
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id: sha1PasswordHash.php 627 2007-02-28 22:30:42Z zerkms $
 */

fileLoader::load('service/passwordHash');

/**
 * sha1PasswordHash: класс для хэширования пароля с помощью SHA1
 *
 * @package system
 * @version 0.1
 */
class sha1PasswordHash extends PasswordHash
{
    /**
     * Применение sha1-хэширования
     *
     * @param string $value значение пароля
     * @return string результат применения sha1-хэширования к $value
     */
    public function apply($value)
    {
        return sha1($value);
    }
}
?>