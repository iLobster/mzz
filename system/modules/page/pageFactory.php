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
 * pageFactory: фабрика для получения контроллеров страниц
 *
 * @package modules
 * @subpackage page
 * @version 0.5
 */
class pageFactory extends simpleFactory
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "page"; // оставить его здесь или брать из ТМ? Или тм должен брать отсюда?
}

?>