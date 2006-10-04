<?php
//
// $Id: md5PasswordHash.php 711 2006-05-23 18:42:43Z mz $
// $URL: svn://svn.subversion.ru/usr/local/svn/mzz/system/service/md5PasswordHash.php $
//
// MZZ Content Management System (c) 2006
// Website : http://www.mzz.ru
//
// This program is free software and released under
// the GNU/GPL License (See /docs/GPL.txt).
//

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