<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2005-2007
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @version $Id$
 */

/**
 * PasswordHash: абстрактный класс PasswordHash
 *
 * @package system
 * @version 0.1
 */
abstract class passwordHash
{
    /**
     * Применение хэширования
     *
     * @param string $value значение пароля
     * @return string результат применения хэширования к $value
     */
    public function apply($value)
    {
        return $value;
    }
}
?>