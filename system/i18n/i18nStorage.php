<?php
/**
 * $URL$
 *
 * MZZ Content Management System (c) 2006
 * Website : http://www.mzz.ru
 *
 * This program is free software and released under
 * the GNU/GPL License (See /docs/GPL.txt).
 *
 * @link http://www.mzz.ru
 * @package system
 * @subpackage request
 * @version $Id$
*/

/**
 * i18nStorage: интерфейс стораджа для переводов
 *
 * @package system
 * @subpackage i18n
 * @version 0.1
 */
interface i18nStorage
{
    /**
     * Конструктор
     *
     * @param string $module имя модуля
     * @param string $lang язык
     */
    public function __construct($module, $lang);

    /**
     * Получение фразы по идентификатору
     *
     * @param string $name
     */
    public function read($name);
}