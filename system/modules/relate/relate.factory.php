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
/**
 * pageFactory: фабрика для получения контроллеров страниц
 *
 * @package page
 * @version 0.5
 */

class relateFactory extends simpleFactory
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "relate"; // оставить его здесь или брать из ТМ? Или тм должен брать отсюда?
}
?>