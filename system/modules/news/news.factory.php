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
 * NewsFactory: фабрика для получения контроллеров новостей
 *
 * @package news
 * @version 0.5
 */

class newsFactory extends simpleFactory
{
    /**
     * Имя модуля
     *
     * @var string
     */
    protected $name = "news"; // оставить его здесь или брать из ТМ? Или тм должен брать отсюда?
}
?>